<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Group\Exam\ExamAnswerController;
use App\Http\Controllers\Api\V1\Group\Exam\ExamInstanceAttemptController;
use App\Http\Controllers\Api\V1\Group\Exam\ExamInstanceController;
use App\Http\Controllers\Api\V1\Group\Exam\GroupExamController;
use App\Http\Controllers\Api\V1\Group\GroupController;
use App\Http\Controllers\Api\V1\Group\InviteController;
use App\Http\Controllers\Api\V1\Group\Module\LessonController;
use App\Http\Controllers\Api\V1\Group\Module\ModuleController;
use App\Http\Controllers\Api\V1\Group\UserGroupController;
use App\Models\ExamInstance;
use App\Models\Group;
use App\Models\User;
use App\Models\UserGroupInvite;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'organization'])->group(function () {
    Route::prefix('available-groups')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->can('viewAny', Group::class);
        Route::get('/{group}', [GroupController::class, 'show'])->middleware('can:viewAvailable,group');
    });

    Route::prefix('groups')->group(function () {
        Route::get('/', [UserGroupController::class, 'index']);

        Route::prefix('{group}')->whereNumber('id')->middleware('can:view,group')->group(function () {
            Route::get('', [UserGroupController::class, 'show']);
            Route::prefix('modules')->whereNumber('id')->group(function () {
                Route::get('', [ModuleController::class, 'index']);
                Route::prefix('{moduleId}')->whereNumber('moduleId')->group(function () {
                    Route::get('', [ModuleController::class, 'show']);
                    Route::prefix('lessons')->group(function () {
                        Route::get('', [LessonController::class, 'index']);
                        Route::get('{lessonId}', [LessonController::class, 'show'])->whereNumber('lessonId');
                    });
                });
            });

            Route::prefix('assigned-exams')->group(function () {
                Route::get('', [GroupExamController::class, 'index']);
                Route::prefix('{assignedExam}')->middleware('can:view,assignedExam')->group(function () {
                    Route::get('', [GroupExamController::class, 'show']);
                    Route::post('/exam-instances', [ExamInstanceController::class, 'store'])
                        ->can('create', ExamInstance::class);
                    Route::get('/exam-instances', [ExamInstanceController::class, 'index']);
                });
            });
        });
        Route::prefix('{groupId}/invites')->whereNumber('groupId')->group(function () {
            Route::get('available-users', [InviteController::class, 'availableUsers'])->can('viewAny', User::class);
            Route::post('', [InviteController::class, 'store'])->can('create', UserGroupInvite::class);
            Route::get('', [InviteController::class, 'index'])->can('viewAny', UserGroupInvite::class);
            Route::delete('/{inviteId}', [InviteController::class, 'delete'])->can('delete', UserGroupInvite::class);
        });
    });

    Route::prefix('exam-instances/{examInstance}')->middleware('can:view,examInstance')->group(function () {
        Route::get('', [ExamInstanceController::class, 'show']);
        Route::get('/attempts/{attemptId}', [ExamInstanceAttemptController::class, 'show']);
        Route::post('/attempts/{attemptId}/answers', [ExamAnswerController::class, 'store']);
    });
});
