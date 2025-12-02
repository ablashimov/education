<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Group\Exam\ExamController;
use App\Http\Controllers\Api\V1\Group\Exam\ExamStatusController;
use App\Http\Controllers\Api\V1\Results\UserResultsController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\NotificationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
//    Route::get('google/initiate', [AuthController::class, 'googleInitiate']);
//    Route::post('google/callback', [AuthController::class, 'googleCallback']);

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);
    Route::post('/email/verification-notification', [AuthController::class, 'sendEmailVerification']);
    Route::post('/email/verify', [AuthController::class, 'verifyEmail']);

    Route::middleware(['auth:sanctum', 'organization'])->group(function () {
        Route::get('/user', [UserController::class, 'authUser']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::prefix('users')->group(function () {
            Route::post('/', [UserController::class, 'store'])->can('create', User::class);
            Route::get('/', [UserController::class, 'index'])->can('viewAny', User::class);
            Route::prefix('{user}')->whereNumber('id')->group(function () {
                Route::put('/', [UserController::class, 'edit'])->middleware('can:update,user');
                Route::get('/', [UserController::class, 'show'])->middleware('can:view,user');
                Route::delete('/', [UserController::class, 'delete'])->middleware('can:delete,user');
            });
        });

        Route::prefix('results')->group(function () {
            Route::get('/', [UserResultsController::class, 'index']);
            Route::get('/{assignedExamId}', [UserResultsController::class, 'show']);
        });

        Route::prefix('exams')->group(function () {
            Route::get('/', [ExamController::class, 'index']);
            Route::get('statuses', [ExamStatusController::class, 'index']);
        });

        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'index']);
            Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
            Route::put('/{id}/read', [NotificationController::class, 'markAsRead']);
            Route::put('/read-all', [NotificationController::class, 'markAllAsRead']);
        });
    });

    Route::get('health', function () {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toISOString(),
            'version' => '1.0.0',
        ]);
    });
});

