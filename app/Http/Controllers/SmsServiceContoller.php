<?php

namespace App\Http\Controllers;

use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsServiceContoller extends Controller
{
    public function statusCallback(Request $request)
    {
        try {

            $sid = $request->input('MessageSid');
            $status = $request->input('MessageStatus');
            VerificationCode::where('response_id', $sid)->update([
                'status' => $status,
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            Log::channel('twilio')->error($exception->getFile().' :: '.$exception->getMessage().' :: '.json_encode(($request->all() ?? [])));
        }
        return response(['success' => true], 200);
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
