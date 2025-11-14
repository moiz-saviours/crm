<?php
//
//use App\Http\Controllers\Developer\Auth\{
//    AuthenticatedSessionController as DeveloperAuthenticatedSessionController,
////    ConfirmablePasswordController as DeveloperConfirmablePasswordController,
////    EmailVerificationNotificationController as DeveloperEmailVerificationNotificationController,
////    EmailVerificationPromptController as DeveloperEmailVerificationPromptController,
////    NewPasswordController as DeveloperNewPasswordController,
////    PasswordController as DeveloperPasswordController,
////    PasswordResetLinkController as DeveloperPasswordResetLinkController,
////    VerifyEmailController as DeveloperVerifyEmailController,
//    RegisteredDeveloperController as DeveloperRegisteredDeveloperController
//};
//use Illuminate\Support\Facades\Route;
//Route::prefix('developer')->name('developer.')->group(function () {
//    Route::middleware('guest:developer')->group(function () {
//        Route::get('register', [DeveloperRegisteredDeveloperController::class, 'create'])->name('register');
//        Route::post('register', [DeveloperRegisteredDeveloperController::class, 'store']);
//        Route::get('login', [DeveloperAuthenticatedSessionController::class, 'create'])->name('login');
//        Route::post('login', [DeveloperAuthenticatedSessionController::class, 'store']);
////        Route::get('forgot-password', [DeveloperPasswordResetLinkController::class, 'create'])->name('password.request');
////        Route::post('forgot-password', [DeveloperPasswordResetLinkController::class, 'store'])->name('password.email');
////        Route::get('reset-password/{token}', [DeveloperNewPasswordController::class, 'create'])->name('password.reset');
////        Route::post('reset-password', [DeveloperNewPasswordController::class, 'store'])->name('password.store');
//    });
//
//    Route::middleware('auth:developer')->group(function () {
//        Route::get('/dashboard', function () {
//            return view('developer.dashboard');
//        })->name('dashboard');
////        Route::get('verify-email', DeveloperEmailVerificationPromptController::class)->name('verification.notice');
////        Route::get('verify-email/{id}/{hash}', DeveloperVerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
////        Route::post('email/verification-notification', [DeveloperEmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
////        Route::get('confirm-password', [DeveloperConfirmablePasswordController::class, 'show'])->name('password.confirm');
////        Route::post('confirm-password', [DeveloperConfirmablePasswordController::class, 'store']);
////        Route::put('password', [DeveloperPasswordController::class, 'update'])->name('password.update');
//        Route::post('logout', [DeveloperAuthenticatedSessionController::class, 'destroy'])->name('logout');
//    });
//});
