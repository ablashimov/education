<?php

declare(strict_types=1);

namespace App\Policies;

use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use App\Models\AdminUser;
use App\Models\ExamInstance;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;

class ExamInstancePolicy extends BasePolicy
{
    public function create(User|AdminUser $authUser): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }
        $assignedExam = request()->route('assignedExam');
        $attemptNumber = $assignedExam->instances->count() + 1;

        if ($attemptNumber > $assignedExam->attempts_allowed) {
            return Response::deny('Ви перевищели дозволену кількість спроб');
        }

        $notFinished = $assignedExam->instances->filter(function (ExamInstance $instance) {
            return is_null($instance->attempt);
        });

        if ($notFinished->isNotEmpty()) {
            return Response::deny('Ви маєте незавершену спробу');
        }

        return Response::allow();
    }

    public function view(User|AdminUser $authUser, ExamInstance $examInstance): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }
        $examInstance->load('assignment');

        $canView = $examInstance->user_id === $authUser->id
            && $examInstance->assignment->start_at->lte(Carbon::now())
            && $examInstance->assignment->end_at->gte(Carbon::now());

        return $canView ? Response::allow() : Response::deny();
    }

    public function update(User|AdminUser $authUser, ExamInstance $examInstance): Response
    {
        if ($this->isAdminPanelAction()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function delete(User|AdminUser $authUser, ExamInstance $examInstance): Response
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

    public function restore(User|AdminUser $authUser, ExamInstance $examInstance): Response
    {
        return Response::deny();
    }

    public function forceDelete(User|AdminUser $authUser, ExamInstance $examInstance): Response
    {
        return Response::deny();
    }
}
