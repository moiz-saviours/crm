<?php

use App\Http\Controllers\Api\{
    ApiAuthorizePaymentController,
    ApiPaypalPaymentController,
    ApiSecurePaymentController,
    ApiStripePaymentController
};
use App\Http\Controllers\ApiInvoiceController;
use App\Http\Controllers\ApiPaymentAttachmentController;
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
Route::post('paypal-create-order', [ApiPaypalPaymentController::class, 'createOrder'])->name('api.paypal.create-order');
Route::post('paypal-capture-order', [ApiPaypalPaymentController::class, 'captureOrder'])->name('api.paypal.capture-order');
Route::post('paypal-cancel-order', [ApiPaypalPaymentController::class, 'cancelOrder'])->name('api.paypal.cancel-order');

Route::post('upload-payment-proof',[ApiPaymentAttachmentController::class,'upload_attachment'])->name('api.upload-payment-proof');


//});
Route::get('fetch-invoice/{invoice?}', [ApiInvoiceController::class, 'fetch_invoice'])->missing(function (Request $request) {
    return response()->json(['error' => 'Invalid url.'], 404);
});
Route::post('/api/check-user', function(Request $request) {
    $email = $request->input('email');
    $table = $request->input('table');

    if (!$email || !$table) {
        return response()->json(['error' => 'Missing email or table'], 400);
    }
    $allowedTables = ['users', 'admins'];
    if (!in_array($table, $allowedTables)) {
        return response()->json(['error' => 'Invalid table'], 400);
    }
    $exists = DB::table($table)->where('email', $email)->exists();

    return response()->json(['exists' => $exists]);
});
Route::post('/check-channels', function(Request $request) {

    $tableToCheck = ($request->has('type') && $request->get('type') === 999) ? 'admins' : 'users';

    $channels = [
        'payusinginvoice' => 'Channel 1',
        'paymentbyinvoice' => 'Channel 2',
        'paymentviainvoice' => 'Channel 3',
        'paythroughinvoice' => 'Channel 4',
        'payviainvoice' => 'Channel 5',
    ];

    $validChannels = [];

    foreach ($channels as $domain  => $channelName) {
        try {
            $response = Http::timeout(3)->post("https://{$domain}.com/api/check-user", [
                'email' => $request->email,
                'table' => $tableToCheck
            ]);

            if ($response->ok() && $response->json('exists')) {
                $validChannels[] = [
                    'domain' => $domain,
                    'name' => $channelName,
                ];
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    return response()->json($validChannels);
})->name('check.channels');



Route::fallback(function () {
    return response()->json(['error' => 'Controller or function not found'], 404);
});
