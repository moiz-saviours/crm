<?php

namespace App\Traits;

use App\Enums\PermissionScope;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

trait HasPermissions
{
    public function permissions(): MorphToMany
    {
        return $this->morphToMany(
            Permission::class,
            'assignable',
            'permission_assignments'
        )->withPivot('granted', 'scope');
    }

    public function hasPermission($model, string $action): bool
    {
        if (is_object($model)) {
            $modelClass = 'App\\Models\\' . ucwords(Str::camel(class_basename($model)));
        } else if (is_string($model)) {
            $modelClass = $model;
        } else {
            return false;
        }
        $permission = $this->permissions()
            ->where('model_type', $modelClass)
            ->where('action', $action)
            ->wherePivot('granted', true)
            ->first();
        if (!$permission) {
            return false;
        }
        $scope = $permission->pivot->scope ?? PermissionScope::NONE->value;
        return $this->checkScope($scope, $model);
    }

    protected function checkScope(string $scope, $model = null): bool
    {
        if ($scope === PermissionScope::NONE->value) {
            return false;
        }
        if ($scope === PermissionScope::ALL->value) {
            return true;
        }
        if (!$model) {
            return false;
        }
        return true;
    }

    public function assignPermission(
        string $model_type,
        string $action,
        string $scope = PermissionScope::NONE->value,
        bool   $granted = true
    ): void
    {
        $permission = Permission::firstOrCreate([
            'model_type' => $model_type,
            'action' => $action,
            'scope' => $scope
        ]);
        $this->permissions()->syncWithoutDetaching([
            $permission->id => [
                'granted' => $granted,
                'scope' => $scope
            ]
        ]);
    }

    public function updatePermissionScope(
        string $model_type,
        string $action,
        string $scope
    ): void
    {
        $permission = Permission::where('model_type', $model_type)
            ->where('action', $action)
            ->first();
        if ($permission) {
            $this->permissions()->updateExistingPivot($permission->id, [
                'scope' => $scope
            ]);
        }
    }
}
