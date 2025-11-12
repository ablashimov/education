<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\RoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

readonly class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    /**
     * @return Role
     */
    public function getModel(): Model
    {
        return new Role();
    }
}
