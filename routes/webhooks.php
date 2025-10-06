<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/authorize/events', function (Request $request) {
    // Log the incoming payload for debugging
    Log::info('Authorize.Net Webhook Received', $request->all());

    // Validate the payload (you can implement HMAC validation here)
    $payload = $request->all();

    if (!isset($payload['notificationId']) || !isset($payload['eventType'])) {
        return response()->json(['error' => 'Invalid webhook data'], 400);
    }

    // Handle different event types
    switch ($payload['eventType']) {
        case 'net.authorize.payment.authcapture.created':
            Log::info('Payment Authorized and Captured', $payload);
            // Process payment success logic
            break;

        case 'net.authorize.payment.refund.created':
            Log::info('Refund Processed', $payload);
            // Handle refund logic
            break;

        case 'net.authorize.payment.void.created':
            Log::info('Payment Voided', $payload);
            // Handle voided payment logic
            break;

        default:
            Log::warning('Unhandled Webhook Event', $payload);
            break;
    }

    return response()->json(['message' => 'Webhook received'], 200);
});
