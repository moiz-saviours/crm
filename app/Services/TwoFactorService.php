<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use Twilio\Rest\Client;

class TwoFactorService
{
    public function generateCode($user, string $method): VerificationCode
    {
        VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->where('method', $method)
            ->whereNull('verified_at')
            ->delete();
        return VerificationCode::create([
            'morph_id' => $user->id,
            'morph_type' => get_class($user),
            'code' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT),
            'method' => $method,
            'expires_at' => now()->addMinutes(5),
        ]);
    }

    public function sendEmailCode($user, string $code): array
    {
        try {
            Mail::to($user->email)->send(new TwoFactorCodeMail($user, $code));
            $verificationCode = VerificationCode::where('morph_id', $user->id)
                ->where('morph_type', get_class($user))
                ->where('code', $code)
                ->latest()
                ->first();
            if ($verificationCode) {
                $verificationCode->update([
                    'status' => 'sent',
                    'response' => json_encode([
                        'provider' => 'laravel',
                        'sent_to' => $user->email,
                        'timestamp' => now()->toDateTimeString(),
                    ]),
                ]);
            }
            return [
                'success' => true,
                'message' => 'Verification email sent successfully',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage(),
            ];
        }
    }

    public function sendSmsCode($user, string $code): array
    {
        try {

            $twilio = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );
            $message = $twilio->messages->create(
                $user->phone_number,
                [
                    'from' => config('services.twilio.from'),
                    'body' => "Your verification code is: $code"
                ]
            );
            return [
                'success' => true,
                'message' => $message,
                'status' => $message->status,
                'sid' => $message->sid,
                'to' => $message->to,
                'date_created' => $message->dateCreated->format('Y-m-d H:i:s'),
            ];
        } catch (\Twilio\Exceptions\RestException $e) {
            return [
                'success' => false,
                'error' => $e->getCode() == 21211 ? 'Invalid phone number' : 'Twilio error: ' . $e->getMessage(),
                'code' => $e->getCode(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to send SMS',
                'log' => $e->getMessage(),
            ];
        }
    }

    public function verifyCode($user, string $code, string $method): bool
    {
        $verificationCode = VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->where('code', $code)
            ->where('method', $method)
            ->valid()
            ->first();
        if ($verificationCode) {
            $verificationCode->markAsVerified();
            return true;
        }
        return false;
    }
}
