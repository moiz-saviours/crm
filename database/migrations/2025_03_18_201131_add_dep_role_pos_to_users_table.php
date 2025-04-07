<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'department_id')) {
                $table->foreignId('department_id')
                    ->nullable()
                    ->after('type')
                    ->constrained('departments')
                    ->nullOnDelete();
            }
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')
                    ->nullable()
                    ->after('department_id')
                    ->constrained('roles')
                    ->nullOnDelete();
            }
            if (!Schema::hasColumn('users', 'position_id')) {
                $table->foreignId('position_id')
                    ->nullable()
                    ->after('role_id')
                    ->constrained('positions')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['role_id']);
            $table->dropForeign(['position_id']);
            $table->dropColumn(['department_id', 'role_id', 'position_id']);
        });
    }
};
