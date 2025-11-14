<?php

use App\Http\Controllers\Admin\Auth\{AuthenticatedSessionController as AdminAuthenticatedSessionController,
    ConfirmablePasswordController as AdminConfirmablePasswordController,
    EmailVerificationNotificationController as AdminEmailVerificationNotificationController,
    EmailVerificationPromptController as AdminEmailVerificationPromptController,
    NewPasswordController as AdminNewPasswordController,
    PasswordController as AdminPasswordController,
    PasswordResetLinkController as AdminPasswordResetLinkController,
    TwoFactorController as AdminTwoFactorController,
    VerifyEmailController as AdminVerifyEmailController,
    RegisteredAdminController as AdminRegisteredAdminController
};
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['restricted.ips'])->group(function () {
        Route::middleware(['guest:admin'])->group(function () {
//        Route::get('register', [AdminRegisteredAdminController::class, 'create'])->name('register');
//        Route::post('register', [AdminRegisteredAdminController::class, 'store']);
            Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
            Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);
//        Route::get('forgot-password', [AdminPasswordResetLinkController::class, 'create'])->name('password.request');
//        Route::post('forgot-password', [AdminPasswordResetLinkController::class, 'store'])->name('password.email');
//        Route::get('reset-password/{token}', [AdminNewPasswordController::class, 'create'])->name('password.reset');
//        Route::post('reset-password', [AdminNewPasswordController::class, 'store'])->name('password.store');
        });
        Route::middleware(['auth:admin'])->group(function () {
            Route::middleware('2fa:admin')->group(function () {
                Route::get('/two-factor-auth', [AdminTwoFactorController::class, 'show'])->name('2fa.show');
                Route::post('/two-factor-auth/send', [AdminTwoFactorController::class, 'send'])->name('2fa.send');
                Route::get('/two-factor-auth/verify-show', [AdminTwoFactorController::class, 'verifyShow'])->name('2fa.verify.show');
                Route::post('/two-factor-auth/verify', [AdminTwoFactorController::class, 'verify'])->name('2fa.verify');
            });
//        Route::get('verify', AdminEmailVerificationPromptController::class)->name('verification.notice');
//        Route::get('verify/{id}/{hash}', AdminVerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
            Route::get('verify-email', AdminEmailVerificationPromptController::class)->name('verification.notice');
            Route::get('verify-email/{id}/{hash}', AdminVerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
            Route::post('email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
            Route::get('confirm-password', [AdminConfirmablePasswordController::class, 'show'])->name('password.confirm');
            Route::post('confirm-password', [AdminConfirmablePasswordController::class, 'store']);
            Route::put('password', [AdminPasswordController::class, 'update'])->name('password.update');
            Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
        });
    });

});
