<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\ExamAssignment;
use App\Models\User;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;

class ExamAssignmentPolicy extends BasePolicy
{
    public function viewAny(User|AdminUser $authUser): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function create(User|AdminUser $authUser): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function view(User|AdminUser $authUser, ExamAssignment $examAssignment): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }

        $canView = $examAssignment->user_id === $authUser->id
            && $examAssignment->start_at->lte(Carbon::now())
            && $examAssignment->end_at->gte(Carbon::now());

        return $canView ? Response::allow() : Response::deny();
    }

    public function update(User|AdminUser $authUser, ExamAssignment $examAssignment): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function delete(User|AdminUser $authUser, ExamAssignment $examAssignment): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function deleteAny(User|AdminUser $authUser): Response
    {
        if (Filament::isServing()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function restore(User|AdminUser $authUser, ExamAssignment $examAssignment): Response
    {
        return Response::deny();
    }

    public function forceDelete(User|AdminUser $authUser, ExamAssignment $examAssignment): Response
    {
        return Response::deny();
    }
}
