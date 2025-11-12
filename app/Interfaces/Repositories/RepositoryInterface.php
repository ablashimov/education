<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
interface RepositoryInterface
{
    /**
     * @return T
     */
    public function getModel(): Model;

    /**
     * @return Builder<T>
     */
    public function getQuery(): Builder;

    public function updateModel(Model $model, array $updates): void;

    public function updateBy(array $conditions, array $updates): void;

    public function updateById(int $id, array $values): Model;

    public function updateOrCreate(array $conditions, array $data): ?Model;

    public function create(array $data): Model;

    public function insert(array $inserts): void;

    public function upsert(array $data, array $uniqueBy, ?array $update = null): void;

    public function insertGetId(array $inserts): int;

    public function getById(int $id, ?array $with = [], ?array $select = ['*']): Model;

    public function getByIdWithoutRelations(int $id, array $where = [], array $select = ['*']): Model;

    public function getByIds(array $ids, ?array $with = [], ?array $select = ['*']): Collection;

    public function findBy(array $conditions, ?array $with = null, ?array $select = ['*']): Model;

    public function exists(array $conditions): bool;

    public function getAll(?array $select = ['*'], ?array $with = [], ?array $where = []): Collection;

    public function delete(array $ids): void;

    public function deleteModel(Model $model): void;

    public function deleteById(int $id): void;

    public function deleteBy(array $conditions): void;

    public function paginateAll(
        ?int $page,
        ?int $perPage,
        array $with = [],
        array $select = ['*'],
        array $where = []
    ): LengthAwarePaginator;

    public function deleteRelation(Model $model, string $relationName): void;

    public function updateOrCreateRelation(
        Model $model,
        string $relationName,
        array $conditions,
        array $data
    ): Model;

    public function createRelation(Model $model, string $relationName, array $data): Model;

    public function updateRelation(Model $model, string $relationName, array $conditions, array $data): int;

    public function deleteNotExistingRelations(
        Model $model,
        string $relationName,
        array $ids
    ): void;

    public function syncRelation(Model $model, string $relationName, array $data): void;
}
