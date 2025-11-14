<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ForceLogoutTrait
{
    protected function forceLogoutUser($user): void
    {
        $user->touch();
        $this->updateUserSignature($user);
    }

    protected function updateUserSignature($user): void
    {
        $guard = $user instanceof \App\Models\Admin ? 'admin' : 'web';
        $userSignatureKey = "{$guard}_user_signature:{$user->id}";
        $currentSignature = $this->generateUserSignature($user);
        Cache::put($userSignatureKey, $currentSignature, 86400);
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
            'password' => $user->password,
            'status' => $user->status,
            'deleted_at' => $user->deleted_at,
            'updated_at' => $user->updated_at,
        ];
        return hash('sha256', implode('|', $criticalFields));
    }
}
