<?php

declare(strict_types=1);

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class FilterQuery extends QueryBuilder
{
    public function __construct(Builder $query, ?array $filters = null, ?array $sorts = null, ?string $defaultSort = null)
    {
        parent::__construct($query);

        if ($sorts) {
            $this->allowedSorts($sorts);
        }

        if ($filters) {
            $this->allowedFilters($filters);
        }

        if ($defaultSort) {
            $this->defaultSorts($defaultSort);
        }
    }
}
