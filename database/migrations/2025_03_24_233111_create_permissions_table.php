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
        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('model_type');
                $table->string('action');
                $table->string('description')->nullable();
                $table->timestamps();
                $table->unique(['model_type', 'action']);
            });
        }
        if (!Schema::hasTable('permission_assignments')) {
            Schema::create('permission_assignments', function (Blueprint $table) {
                $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
                $table->morphs('assignable');
                $table->string('scope')->default('none');
                $table->boolean('granted')->default(true);
                $table->timestamps();
                $table->primary(['permission_id', 'assignable_id', 'assignable_type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_assignments');
        Schema::dropIfExists('permissions');
    }
};
