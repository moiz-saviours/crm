<?php

namespace App\Http\Controllers;

use App\Models\VerificationCode;
use Illuminate\Http\Request;

class SmsServiceContoller extends Controller
{
    public function statusCallback(Request $request)
    {
        $sid = $request->input('MessageSid');
        $status = $request->input('MessageStatus');
        VerificationCode::where('response_id', $sid)->update([
            'status' => $status,
        ]);
        return response()->json(['success' => true]);
    }

    public function smsStatus($sid)
    {
        $verification = VerificationCode::where('response_id', $sid)->first();
        if (!$verification) {
            return response()->json(['error' => 'Not found'], 404);
        }
//        $verification->status = 'sent';
//        $verification->save();
        return response()->json(['status' => $verification->status ?? 'queued']);
    }
}
