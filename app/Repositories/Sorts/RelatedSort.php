<?php

namespace App\Repositories\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\QueryBuilder\Sorts\Sort;

class RelatedSort implements Sort
{
    public function __construct(protected string $relation, protected string $property) {}

    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $model = $query->getModel();
        $table = $model->getTable();
        
        $relation = $model->{$this->relation}();
        
        if (! $relation instanceof BelongsTo) {
            return;
        }

        $relatedTable = $relation->getRelated()->getTable();
        $foreignKey = $relation->getForeignKeyName();
        $ownerKey = $relation->getOwnerKeyName();

        if (! $query->getQuery()->columns) {
            $query->select($table . '.*');
        }

        // Check if join already exists to avoid duplicates (basic check)
        $joins = $query->getQuery()->joins ?? [];
        $joinExists = false;
        foreach ($joins as $join) {
            if ($join->table === $relatedTable) {
                $joinExists = true;
                break;
            }
        }

        if (! $joinExists) {
            $query->leftJoin($relatedTable, "{$table}.{$foreignKey}", '=', "{$relatedTable}.{$ownerKey}");
        }

        $query->orderBy("{$relatedTable}.{$this->property}", $direction);
    }
}
