<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\FilteringInterface;
use App\Interfaces\Repositories\RepositoryInterface;
use App\Repositories\Filters\FilterQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilderRequest;

/**
 * @template T of Model
 */
abstract readonly class AbstractRepository implements RepositoryInterface, FilteringInterface
{
    public function __construct()
    {
        QueryBuilderRequest::setArrayValueDelimiter('||');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder<T>
     */
    public function getQuery(): Builder
    {
        return $this->getModel()->newQuery();
    }

    /**
     * @return T
     */
    abstract public function getModel(): Model;

    public function getAllowedFilters(): array
    {
        return [];
    }

    public function getAllowedSorts(): array
    {
        return [];
    }

    protected function getDefaultSort(): ?string
    {
        return null;
    }

    public function updateModel(Model $model, array $updates): void
    {
        $model->update($updates);
    }

    public function updateBy(array $conditions, array $updates): void
    {
        $models = $this->getQuery()->where($conditions)->get();

        foreach ($models as $model) {
            $model->update($updates);
        }
    }

    public function updateOrCreate(array $conditions, array $data): ?Model
    {
        return $this->getQuery()->updateOrCreate($conditions, $data);
    }

    public function insert(array $inserts): void
    {
        $this->getQuery()->insert($inserts);
    }

    public function upsert(array $data, array $uniqueBy, ?array $update = null): void
    {
        $this->getQuery()->upsert($data, $uniqueBy, $update);
    }

    public function insertGetId(array $inserts): int
    {
        return $this->getQuery()->insertGetId($inserts);
    }

    public function create(array $data): Model
    {
        return $this->getQuery()->create($data);
    }

    public function getById(int $id, ?array $with = null, ?array $select = ['*']): Model
    {
        $query = $this->getQuery()->select($select)->where('id', $id);

        if ($with) {
            $query->with($with);
        }

        return $query->firstOrFail();
    }

    public function getByIdWithoutRelations(int $id, array $where = [], array $select = ['*']): Model
    {
        $query = $this->getQuery()
            ->withoutEagerLoads()
            ->select($select)
            ->where('id', $id)
            ->where($where);

        return $query->firstOrFail();
    }

    public function getByIds(array $ids, ?array $with = [], ?array $select = ['*']): Collection
    {
        $query = $this->getQuery()->select($select)->whereIn('id', $ids);

        if ($with) {
            $query->with($with);
        }

        return $query->get();
    }

    public function findBy(array $conditions, ?array $with = null, ?array $select = ['*']): Model
    {
        $query = $this->getQuery()->select($select)->where($conditions);

        if ($with) {
            $query->with($with);
        }

        $this->addFilters($query);

        return $query->firstOrFail();
    }

    public function exists(array $conditions): bool
    {
        return $this->getQuery()->where($conditions)->exists();
    }

    public function getAll(?array $select = ['*'], ?array $with = [], ?array $where = []): Collection
    {
        $query = $this
            ->getQuery()
            ->with($with)
            ->where($where)
            ->select($select);

        $this->addFilters($query);

        return $query->get();
    }

    public function delete(array $ids): void
    {
        $models = $this->getQuery()->whereIn('id', $ids)->get();

        foreach ($models as $model) {
            $model->delete();
        }
    }

    public function deleteModel(Model $model): void
    {
        $model->delete();
    }

    public function deleteById(int $id): void
    {
        $model = $this->getQuery()->where('id', $id)->first();
        $model->delete();
    }

    public function deleteBy(array $conditions): void
    {
        $models = $this->getQuery()->where($conditions)->get();

        foreach ($models as $model) {
            $model->delete();
        }
    }

    public function updateById(int $id, array $values): Model
    {
        $model = $this->getById($id);
        $model->update($values);

        return $model;
    }

    public function paginateAll(
        ?int $page,
        ?int $perPage,
        array $with = [],
        array $select = ['*'],
        array $where = []
    ): LengthAwarePaginator {
        $query = $this->getQuery()->select($select)->where($where);

        if ($with) {
            $query->with($with);
        }

        $this->addFilters($query);
        $this->trimPerPage($perPage);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function deleteRelation(Model $model, string $relationName): void
    {
        $model->$relationName()->delete();
    }

    public function updateOrCreateRelation(Model $model, string $relationName, array $conditions, array $data): Model
    {
        return $model->$relationName()->updateOrCreate($conditions, $data);
    }

    public function createRelation(Model $model, string $relationName, array $data): Model
    {
        return $model->$relationName()->create($data);
    }

    public function updateRelation(Model $model, string $relationName, array $conditions, array $data): int
    {
        return $model->$relationName()->where($conditions)->update($data);
    }

    public function deleteNotExistingRelations(Model $model, string $relationName, array $ids): void
    {
        $query = $model->$relationName();

        if (! empty($ids)) {
            $query->whereNotIn('id', $ids);
        }

        $models = $query->get();

        foreach ($models as $model) {
            $model->delete();
        }
    }

    public function syncRelation(Model $model, string $relationName, array $data): void
    {
        $model->$relationName()->sync($data);
    }

    protected function addFilters(Builder $query): void
    {
        new FilterQuery($query, $this->getAllowedFilters(), $this->getAllowedSorts(), $this->getDefaultSort());
    }

    protected function trimPerPage(int &$perPage, int $limit = 100): void
    {
        if ($perPage > $limit) {
            $perPage = $limit;
        }
    }
}
