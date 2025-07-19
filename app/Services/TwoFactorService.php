<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class TwoFactorService
{
    public function generateCode($user, string $method): VerificationCode
    {
        VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->where('method', $method)
            ->delete();
        return VerificationCode::create([
            'morph_id' => $user->id,
            'morph_type' => get_class($user),
            'code' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT),
            'method' => $method,
            'expires_at' => now()->addMinutes(5),
        ]);
    }

    /**
     * Delete a verification code for a given user and method.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $method
     * @return int Number of deleted records
     */
    public function deleteCode($user, string $method): int
    {
        return VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->delete();
    }

    public function sendEmailCode($user, string $code): array
    {
        try {
            $message_id = Str::random(16);
            Mail::to($user->email)->send(new TwoFactorCodeMail($user, $code, $message_id));
            $verificationCode = VerificationCode::where('morph_id', $user->id)
                ->where('morph_type', get_class($user))
                ->where('code', $code)
                ->latest()
                ->first();
            if ($verificationCode) {
                $verificationCode->update([
                    'status' => 'sent',
                    'response_id' => $message_id,
                    'response' => json_encode([
                        'provider' => config('mail.default'),
                        'sent_to' => $user->email,
                        'timestamp' => now()->toDateTimeString(),
                    ]),
                ]);
            }
            return [
                'success' => true,
                'message' => 'Verification email sent successfully.',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Email sending failed. Please try again later.',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
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
            $messageParams = [
                'from' => config('services.twilio.from'),
                'body' => "Your verification code is: $code"
            ];
            if (!app()->environment('local')) {
                $messageParams['statusCallback'] = route('api.twilio.status.callback');
            } else {
                $baseUrl = rtrim(env('DEV_BASE_URL'), '/');
                $messageParams['statusCallback'] = $baseUrl . route('api.twilio.status.callback', [], false);
            }
            $message = $twilio->messages->create($user->phone_number, $messageParams);
            if (app()->environment('local')) {
                Log::info('[LOCAL] SMS sending skipped', [
                    'user_id' => $user->id,
                    'phone' => $user->phone_number,
                    'code' => $code,
                    'would_send' => true
                ]);
            }
            $status = $message->status ?? 'unknown';
            $statusMessage = match ($status) {
                'queued' => 'Your message has been queued for delivery.',
                'sending' => 'Your message is being sent.',
                'sent' => 'Your message has been sent.',
                'delivered' => 'Your message was delivered.',
                'undelivered' => 'Message delivery failed. Please try again or contact support.',
                'failed' => 'Message failed. Try again later.',
                default => 'Message is being processed.'
            };
            $verificationCode = VerificationCode::where('morph_id', $user->id)
                ->where('morph_type', get_class($user))
                ->where('code', $code)
                ->latest()
                ->first();
            if ($verificationCode) {
                $props = [];
                foreach ((new \ReflectionClass($message))->getProperties() as $prop) {
                    $prop->setAccessible(true);
                    $props[$prop->getName()] = $prop->getValue($message);
                }
                $verificationCode->update([
                    'status' => $message->status,
                    'response_id' => $message->sid,
                    'response' => json_encode([
                        'provider' => 'twilio',
                        'sent_to' => $user->phone_number,
                        'status' => $status,
                        'timestamp' => now()->toDateTimeString(),
                        'details' => $props,
                    ]),
                ]);
            }
            return [
                'success' => true,
                'message' => $statusMessage,
                'status' => $status,
                'sid' => $message->sid,
                'to' => $message->to,
                'date_created' => $message->dateCreated instanceof \DateTimeInterface ? $message->dateCreated->format('Y-m-d H:i:s') : null,];
        } catch (\Twilio\Exceptions\RestException $e) {
            Log::error('Twilio SMS error', ['code' => $e->getCode(), 'message' => $e->getMessage()]);
            return [
                'success' => false,
                'error' => $e->getCode() == 21211 ? 'Invalid phone number.' : 'SMS sending failed. Please try again later.',
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            Log::error('SMS send failed', ['exception' => $e]);
            return [
                'success' => false,
                'error' => 'SMS sending failed. Please try again later.',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
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
