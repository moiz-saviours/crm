<?php

use App\Http\Controllers\Api\ApiAuthorizePaymentController;
use App\Http\Controllers\Api\ApiSecurePaymentController;
use App\Http\Controllers\Api\ApiStripePaymentController;
use App\Http\Controllers\ApiInvoiceController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return new UserResource($request->user());
})->middleware('auth:sanctum', 'abilities:create,update,read');
Route::post('login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $tokenExpiration = $request->remember ? now()->addDays(30) : now()->addSeconds(10);
        $token = $user->createToken('User Login Token', ['create', 'update', 'read'], $tokenExpiration)->plainTextToken;
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }
    return response()->json([
        'status' => 'error',
        'message' => 'Invalid credentials',
    ], 401);
});
//Route::middleware(['auth:sanctum', 'abilities:create,update,read'])->group(function () {
Route::post('process-payment', [ApiAuthorizePaymentController::class, 'processPayment'])->name('api.authorize.process-payment');
Route::post('secure-process-payment', [ApiSecurePaymentController::class, 'processPayment'])->name('api.secure.process-payment');
Route::post('stripe-process-payment', [ApiStripePaymentController::class, 'processPayment'])->name('api.stripe.process-payment');
Route::post('paypal-process-payment', function (){
    return response()->json(['status' => 'success']);
})->name('api.paypal.process-payment');



//});
Route::get('fetch-invoice/{invoice?}', [ApiInvoiceController::class, 'fetch_invoice'])->missing(function (Request $request) {
    return response()->json(['error' => 'Invalid url.'], 404);
});
Route::fallback(function () {
    return response()->json(['error' => 'Controller or function not found'], 404);
});


