<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Jenssegers\Agent\Agent;

class TwoFactorService
{
    public function generateCode(Model $user, string $method, string $deviceId = null): VerificationCode
    {
        VerificationCode::forUser($user)->whereNull('verified_at')->where('device_id', $deviceId)->delete();
        return VerificationCode::create([
            'morph_id' => $user->id,
            'morph_type' => get_class($user),
            'code' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT),
            'method' => $method,
            'expires_at' => now()->addMinutes(5),
            'device_id' => $deviceId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
        ]);
    }

    /**
     * Send the verification code via specified method with rate limiting
     */
    public function sendCode(Model $user, VerificationCode $verificationCode): array
    {
        // Rate limiting by device
        $key = '2fa-attempts:' . $verificationCode->device_id;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return [
                'success' => false,
                'message' => 'Too many attempts. Please wait before requesting a new code.',
                'retry_after' => RateLimiter::availableIn($key)
            ];
        }
        RateLimiter::hit($key);
        return match ($verificationCode->method) {
            'email' => $this->sendEmailCode($user, $verificationCode->code),
            'sms' => $this->sendSmsCode($user, $verificationCode->code),
            default => throw new \InvalidArgumentException("Unsupported verification method")
        };
    }

    /**
     * Delete a verification code for a given user and method.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $method
     * @return int Number of deleted records
     */
    public function deleteCode(Model $user, string $deviceId = null): int
    {
        return VerificationCode::forUser($user)->where('device_id', $deviceId)->delete();
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

    public function verifyCode($user, string $code, string $method, string $deviceId = null): bool
    {
        $verificationCode = VerificationCode::forUser($user)
            ->where('code', $code)
            ->byMethod($method)
            ->where('device_id', $deviceId)
            ->valid()
            ->first();
        if ($verificationCode) {
            $verificationCode->markAsVerified();
            RateLimiter::clear('2fa-attempts:' . $deviceId);
            return true;
        }
        return false;
    }

    /**
     * Check if device has active verification
     */
    public function hasActiveVerification(Model $user, string $deviceId): bool
    {
        return VerificationCode::forUser($user)
            ->where('device_id', $deviceId)
            ->valid()
            ->exists();
    }

    public function generateDeviceFingerprint(): string
    {
        $agent = new Agent();
        $components = [
            $agent->browser(),
            $agent->version($agent->browser()),
            $agent->platform(),
            $agent->version($agent->platform()),
            $agent->device(),
            request()->ip(),
            session()->getId()
        ];
        return hash('sha256', implode('|', array_filter($components)));
    }
}
