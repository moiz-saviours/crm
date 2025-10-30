<?php

use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Api\{ApiAuthorizePaymentController,
    ApiPaypalPaymentController,
    ApiSecurePaymentController,
    ApiStripePaymentController
};
use App\Http\Controllers\ApiInvoiceController;
use App\Http\Controllers\ApiPaymentAttachmentController;
use App\Http\Controllers\SmsServiceContoller;
use App\Http\Controllers\UserActivityController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::get('/user', function (Request $request) {
    return new UserResource($request->user());
})->middleware('auth:sanctum', 'abilities:create,update,read');
Route::post('login', function (Request $request) {
    return response()->json([
        "status" => "success",
        "token" => "4|hHHj048PF3COVsC5bueo9QCTJm1FORliEtEDNu4h137d0f4b",
        "user" => ["id" => 1,
            "name" => "Smith John",
            "email" => "smith.john@customer-portal.com",
            "phone" => "1234567890",
            "ip_address" => null,
            "image" => null,
            "status" => 1,
            "deleted_at" => null,
            "updated_at" => "2025-02-06T17:42:05.000000Z",
            "created_at" => "2025-02-04T18:50:32.000000Z"]
    ]);
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
Route::post('upload-payment-proof', [ApiPaymentAttachmentController::class, 'upload_attachment'])->name('api.upload-payment-proof');
//});
Route::get('fetch-invoice/{invoice?}', [ApiInvoiceController::class, 'fetch_invoice'])->missing(function (Request $request) {
    return response()->json(['error' => 'Invalid url.'], 404);
});
Route::post('/check-user', function (Request $request) {
    $email = $request->input('email');
    $table = $request->input('table');
    if (!$email || !$table) {
        return response()->json(['error' => 'Missing email or table'], 400);
    }
    $allowedTables = ['users', 'admins'];
    if (!in_array($table, $allowedTables)) {
        return response()->json(['error' => 'Invalid table'], 400);
    }
    $exists = DB::table($table)->where('email', $email)->where('status', 1)->exists();
    return response()->json(['exists' => $exists]);
});
Route::post('/channel-login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    $guard = "web";
    if ($request->type && $request->type == 999) {
        $guard = "admin";
    }
    if (Auth::guard($guard)->attempt($request->only('email', 'password'))) {
//        $request->session()->regenerate();
        return response()->json([
            'status' => 'ok',
            'user' => Auth::user(),
            'session_id' => session()->getId(),
        ]);
    }
    return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
});
Route::post('/check-channels', function (Request $request) {

    $authUser = Auth::user();
    $tableToCheck = ($authUser && Auth::guard('admin')->check() === 'admin') ? 'admins' : 'users';
    $channels = [
        'payusinginvoice' => 'Channel 1',
        'paymentbyinvoice' => 'Channel 2',
        'paymentviainvoice' => 'Channel 3',
        'paythroughinvoice' => 'Channel 4',
        'payviainvoice' => 'Channel 5',
    ];
    $validChannels = [];
    $promises = [];
    foreach ($channels as $domain => $channelName) {
        if ($domain === $request->current_domain) {
            continue;
        }
        $server = app()->environment('development') ? 'crm-development/' : 'crm-development/';
        try {
            $url = "https://{$domain}.com/{$server}api/check-user";
            $response = Http::timeout(3)->post($url, [
                'email' => $authUser->email,
                'table' => $tableToCheck
            ]);
            if ($response->ok() && $response->json('exists')) {
                $validChannels[] = [
                    'domain' => $domain,
                    'name' => $channelName,
                ];
            }
        } catch (\Exception $e) {
            \Log::error("Channel check failed for {$domain}: " . $e->getMessage());
            continue;
        }
    }
    return response()->json([
        'url' => $url,
        'validChannels' => $validChannels,
        'checked' => count($validChannels),
        'email' => $authUser->email,
        'table' => $tableToCheck
    ]);
})->name('check.channels');
Route::fallback(function () {
    return response()->json(['error' => 'Controller or function not found'], 404);
});
Route::post('twilio/status-callback', [SmsServiceContoller::class, 'statusCallback'])->name('api.twilio.status.callback');
Route::post('/brand-leads', [LeadController::class, 'storeFromScript']);
Route::post('/track-activity', [UserActivityController::class, 'store']);
Route::post('customer/login', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    if (!in_array($request->email, ['zuwop@mailinator.com', 'zilixed@mailinator.com', 'Testing.22825102025@gmail.com'])) {
        return response()->json(['error' => 'Invalid credentials'], 400);
    }
    $user = \App\Models\CustomerContact::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['error' => 'Invalid credentials'], 400);
    }
    $tokenExpiration = $request->remember ? now()->addDay() : now()->addHours(12);
    $token = $user->createToken('User Login Token', ['create', 'update', 'read'], $tokenExpiration)->plainTextToken;
    return response()->json([
        'status' => 'success',
        'token' => $token,
        'token_type' => 'Bearer',
        'expires_at' => $tokenExpiration->toISOString(),
        'user' => new UserResource($user),
    ]);
});
Route::get('customer', function (Request $request) {
    $user = $request->user();
    if (!$user) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
    return response()->json([
        "id" => $user->id,
        "name" => $user->name,
        "email" => $user->email,
        "phone" => $user->phone,
        "ip_address" => $user->ip_address,
        "status" => $user->status,
        "deleted_at" => $user->deleted_at,
        "updated_at" => $user->updated_at?->toISOString(),
        "created_at" => $user->created_at?->toISOString()
    ]);
})->middleware('auth:sanctum', 'abilities:create,update,read');
require __DIR__ . '/api-chat.php';
