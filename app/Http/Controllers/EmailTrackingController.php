<?php

namespace App\Http\Controllers;

use App\Models\EmailEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailTrackingController extends Controller
{
public function trackClick($id, Request $request)
{
    Log::info('trackClick Hit');
    Log::info("➡ Entering trackClick()", [
        'email_id' => $id,
        'ip'       => $request->ip(),
    ]);

    $url = $request->query('url');

    EmailEvent::create([
        'email_id'   => $id,
        'event_type' => 'click',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'url'        => $url,
        'created_at' => now(),
    ]);

    Log::info("trackClick(): Recorded", [
        'email_id' => $id,
        'url'      => $url,
    ]);

    return redirect()->away(urldecode($url));
}
public function trackOpen($id, Request $request)
{
    Log::info('trackOpen Hit');
    Log::info("➡ Entering trackOpen()", [
        'email_id' => $id,
        'ip'       => $request->ip(),
    ]);

    EmailEvent::create([
        'email_id'   => $id,
        'event_type' => 'open',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'created_at' => now(),
    ]);

    Log::info("trackOpen(): Recorded", [
        'email_id' => $id,
    ]);

    return response()->file(public_path('assets/images/pixel.png'));
}

    public function trackBounce(Request $request)
    {
        Log::info('trackBounce Hit');

        Log::info("➡ Entering trackBounce()", [
            'ip' => $request->ip(),
        ]);

        $emailId = $request->input('email_id');

        EmailEvent::create([
            'email_id'   => $emailId,
            'event_type' => 'bounce',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        Log::error("trackBounce(): Recorded", [
            'email_id' => $emailId,
        ]);

        return response()->json(['status' => 'recorded'], 200);
    }

    public function trackDelivery(Request $request)
    {
        Log::info('trackDelivery Hit');

        Log::info("➡ Entering trackDelivery()", [
            'ip' => $request->ip(),
        ]);

        $emailId = $request->input('email_id');

        EmailEvent::create([
            'email_id'   => $emailId,
            'event_type' => 'delivery',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        Log::info("trackDelivery(): Recorded", [
            'email_id' => $emailId,
        ]);

        return response()->json(['status' => 'recorded'], 200);
    }

    public function trackSpamReport(Request $request)
    {
        Log::info('trackSpamReport Hit');

        Log::info("➡ Entering trackSpamReport()", [
            'ip' => $request->ip(),
        ]);

        $emailId = $request->input('email_id');

        EmailEvent::create([
            'email_id'   => $emailId,
            'event_type' => 'spam_report',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        Log::warning("trackSpamReport(): Recorded", [
            'email_id' => $emailId,
        ]);

        return response()->json(['status' => 'recorded'], 200);
    }


}
