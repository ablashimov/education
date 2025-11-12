<?php

namespace App\Providers;

use App\Interfaces\Repositories\AnswerRepositoryInterface;
use App\Interfaces\Repositories\AttemptRepositoryInterface;
use App\Interfaces\Repositories\ExamInstanceRepositoryInterface;
use App\Interfaces\Repositories\ExamResultStatusRepositoryInterface;
use App\Interfaces\Repositories\ExamScheduleRepositoryInterface;
use App\Interfaces\Repositories\GroupInviteRepositoryInterface;
use App\Interfaces\Repositories\GroupRepositoryInterface;
use App\Interfaces\Repositories\LessonRepositoryInterface;
use App\Interfaces\Repositories\ModuleRepositoryInterface;
use App\Interfaces\Repositories\ExamQuestionRepositoryInterface;
use App\Interfaces\Repositories\RoleRepositoryInterface;
use App\Interfaces\Repositories\StatusRepositoryInterface;
use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Repositories\AnswerRepository;
use App\Repositories\AttemptRepository;
use App\Repositories\ExamInstanceRepository;
use App\Repositories\ExamResultStatusRepository;
use App\Repositories\ExamScheduleRepository;
use App\Repositories\GroupInviteRepository;
use App\Repositories\GroupRepository;
use App\Repositories\LessonRepository;
use App\Repositories\ModuleRepository;
use App\Repositories\ExamQuestionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StatusRepository;
use App\Repositories\ExamAssignmentRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerAliases();
        $this->registerRepositories();
    }

    private function registerAliases(): void
    {
        $this->app->alias(
            \App\Models\Role::class,
            \Spatie\Permission\Models\Role::class
        );

        $this->app->alias(
            \App\Models\Permission::class,
            \Spatie\Permission\Models\Permission::class
        );
    }

    private function registerRepositories(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->singleton(StatusRepositoryInterface::class, StatusRepository::class);
        $this->app->singleton(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->singleton(GroupInviteRepositoryInterface::class, GroupInviteRepository::class);
        $this->app->singleton(ModuleRepositoryInterface::class, ModuleRepository::class);
        $this->app->singleton(ExamAssignmentRepositoryInterface::class, ExamAssignmentRepository::class);
        $this->app->singleton(ExamQuestionRepositoryInterface::class, ExamQuestionRepository::class);
        $this->app->singleton(ExamInstanceRepositoryInterface::class, ExamInstanceRepository::class);
        $this->app->singleton(ExamScheduleRepositoryInterface::class, ExamScheduleRepository::class);
        $this->app->singleton(ExamResultStatusRepositoryInterface::class, ExamResultStatusRepository::class);
        $this->app->singleton(LessonRepositoryInterface::class, LessonRepository::class);
        $this->app->singleton(AttemptRepositoryInterface::class, AttemptRepository::class);
        $this->app->singleton(AnswerRepositoryInterface::class, AnswerRepository::class);
    }
}
