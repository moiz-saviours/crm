<?php

namespace Database\Seeders;

use App\Enums\PermissionScope;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Permission;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    /**
     * @var mixed|string[]
     */
    public mixed $actions = [
        'view' => 'View {model} records',
        'view_any' => 'View any {model} records',
        'create' => 'Create {model} records',
        'update' => 'Update {model} records',
        'change_status' => 'Change {model} Status',
        'delete' => 'Delete {model} records',
        'restore' => 'Restore deleted {model} records',
        'force_delete' => 'Permanently delete {model} records'
    ];
    protected array $excludedModels = [
        'ActivityLog',
        'Admin',
        'CcInfo',
        'Permission',
        'PermissionAssignment',
        'User',
        'PasswordReset',
        'PersonalAccessToken'
    ];
    protected array $customModelNames = [
        'ClientContact' => 'ClientContact',
    ];

    public function run(): void
    {
        $modelFiles = File::files(app_path('Models'));
        foreach ($modelFiles as $file) {
            $modelName = pathinfo($file, PATHINFO_FILENAME);
            if (in_array($modelName, $this->excludedModels)) {
                continue;
            }
            $displayName = $this->getDisplayName($modelName);
            $modelClass = 'App\\Models\\' . $modelName;
            $tableName = (new $modelClass)->getTable();
            $hasStatusColumn = Schema::hasColumn($tableName, 'status');
            foreach ($this->actions as $action => $descriptionTemplate) {
                if ($action === 'change_status' && !$hasStatusColumn) {
                    continue;
                }
                Permission::firstOrCreate([
                    'model_type' => $modelClass,
                    'action' => $action,
                ], [
                    'description' => str_replace('{model}', $displayName, $descriptionTemplate)
                ]);
            }
        }
        $this->createSpecialPermissions();
    }

    /**
     * Get the display name for descriptions
     */
    protected function getDisplayName(string $modelName): string
    {
        return preg_replace('/(?<!^)[A-Z]/', ' $0', $modelName);
    }

    /**
     * Create non-CRUD permissions
     */
    protected function createSpecialPermissions(): void
    {
        $specialPermissions = [
            [
                'model_type' => 'system',
                'action' => 'admin',
                'description' => 'Full system administration access'
            ],
            [
                'model_type' => 'report',
                'action' => 'view',
                'description' => 'View all reports'
            ],
            [
                'model_type' => 'audit',
                'action' => 'view',
                'description' => 'View system audit logs'
            ],
            [
                'model_type' => 'dashboard',
                'action' => 'view',
                'description' => 'Access main dashboard'
            ],
            [
                'model_type' => 'dashboard',
                'action' => 'view_sales',
                'description' => 'View sales dashboard'
            ],
            [
                'model_type' => 'dashboard',
                'action' => 'view_finance',
                'description' => 'View finance dashboard'
            ],
        ];
        foreach ($specialPermissions as $permission) {
            Permission::firstOrCreate([
                'model_type' => $permission['model_type'],
                'action' => $permission['action'],
            ], $permission);
        }
    }
}
