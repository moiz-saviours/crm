<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NavigationHelper
{
    public static function hasAccess($routeName): bool
    {
        $user = Auth::user();
        if (!$user || !$user->department) {
            return false;
        }
        $accessRules = config('access_rules');
        $normalizedDepartment = self::normalizeKey($user->department?->name ?? '');
        $normalizedAccessRules = collect($accessRules)->mapWithKeys(fn($v, $k) => [self::normalizeKey($k) => $v])->toArray();
        $departmentRules = $normalizedAccessRules[$normalizedDepartment] ?? [];
        if (isset($departmentRules['restrictions']) && in_array($routeName, $departmentRules['restrictions'])) {
            return false;
        }
        if (isset($departmentRules['routes']) && in_array($routeName, $departmentRules['routes'])) {
            return true;
        }
        $roleName = self::normalizeKey($user->role?->name ?? '');
        $normalizedRoles = [];
        if (isset($departmentRules['roles'])) {
            foreach ($departmentRules['roles'] as $key => $value) {
                $normalizedRoles[self::normalizeKey($key)] = $value;
            }
        }
        $roleRules = $normalizedRoles[$roleName] ?? [];
        if (isset($roleRules['restrictions']) && in_array($routeName, $roleRules['restrictions'])) {
            return false;
        }
        if (isset($roleRules['routes']) && in_array($routeName, $roleRules['routes'])) {
            return true;
        }
        return false;
    }

    private static function normalizeKey(mixed $key): string
    {
        return Str::snake(str_replace(['/', '\\'], ' ', strtolower($key)));
    }
}
