<?php

namespace App\Traits;

use App\Models\Admin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

trait ForceLogoutTrait
{
    protected function forceLogoutUser($user): void
    {
        if ($this->getCriticalChanges($user)) {
            $user->touch();
            $this->updateUserSignature($user);
            $this->destroy_session($user);
        }
    }

    /**
     * Get the list of critical fields that were changed
     */
    protected function getCriticalChanges($user): bool
    {
        $criticalFields = ['department_id', 'role_id', 'position_id', 'password', 'email', 'email_verified_at', 'status', 'deleted_at'];
        foreach ($criticalFields as $field) {
            if ($user->isDirty($field)) {
                return true;
            }
        }
        return false;
    }

    protected function updateUserSignature($user): void
    {
        $guard = $user instanceof \App\Models\Admin ? 'admin' : 'web';
        $userSignatureKey = "{$guard}_user_signature:{$user->id}";
        $currentSignature = $this->generateUserSignature($user);
        $storedSignature = Cache::get($userSignatureKey);
        if (!$storedSignature) {
            Cache::put($userSignatureKey, $currentSignature, 86400); // 24 hours
        }
    }

    /**
     * Generate a signature based on critical user properties
     *
     * @param mixed $user
     * @return string
     */
    protected function generateUserSignature(mixed $user): string
    {
        $criticalFields = [
            'department_id' => $user->department_id,
            'role_id' => $user->role_id,
            'position_id' => $user->position_id,
            'password' => $user->password,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'status' => $user->status,
            'deleted_at' => $user->deleted_at,
        ];
        return hash('sha256', implode('|', $criticalFields));
    }

    protected function destroy_session($user): array
    {
        $deletedSessions = [];
        try {
            $verificationCodes = $user->verification_codes()->get();
            $sessionIds = $verificationCodes->whereNotNull('verified_at')->pluck('session_id')->toArray();
            foreach ($sessionIds as $sessionId) {
                $path = storage_path("framework/sessions/{$sessionId}");
                if (File::exists($path)) {
                    File::delete($path);
                    $deletedSessions[] = $sessionId;
                }
            }
            $user->verification_codes()->whereNull('deleted_at')->update(['deleted_at' => now()]);
            Log::info("Password updated for User ID: {$user->id}. Invalidated sessions: " . implode(', ', $deletedSessions));
            return $deletedSessions;
        } catch (\Exception $e) {
            Log::error("Failed to destroy sessions for User ID: {$user->id}. Error: {$e->getMessage()}", [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            return [];
        }
    }
}
