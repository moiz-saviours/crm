<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class NavigationHelper
{
    public static function hasAccess($routeName)
    {
        $user = Auth::user();
        if (!$user || !$user->department) {
            return false;
        }
        $accessRules = config('access_rules');
        $department = strtolower($user->department->name);
        if (array_key_exists($department, $accessRules)) {
            $departmentRules = $accessRules[$department];
            if (isset($departmentRules['routes']) && in_array($routeName, $departmentRules['routes'])) {
                return true;
            }
            if (isset($departmentRules['roles'])) {
                $roleRules = $departmentRules['roles'][$user->role->name] ?? [];
                if (isset($roleRules['routes']) && in_array($routeName, $roleRules['routes'])) {
                    return true;
                }
                if (isset($roleRules['restrictions']) && in_array($routeName, $roleRules['restrictions'])) {
                    return false;
                }
            }
        }
        return false;
    }
}
