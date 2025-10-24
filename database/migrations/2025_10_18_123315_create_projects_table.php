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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('order_column')->nullable()->default(0);
            $table->string('special_key', 100)->unique()->nullable();
            $table->string('cus_contact_key', 100)->nullable();
            $table->string('brand_key', 100)->nullable()->default(null);
            $table->string('team_key', 100)->nullable()->default(null);
            $table->string('type', 50)->nullable()->default(null);
            $table->enum('value', ['regular', 'standard', 'premium', 'exclusive'])->default('regular');
            $table->string('label', 50)->nullable()->default(null);
            $table->string('theme_color', 50)->nullable()->default(null);
            $table->enum('project_status', ['is_progress', 'on_hold', 'cancelled', 'finished'])
                ->default('is_progress');
            $table->boolean('is_progress')->nullable()->default(false);
            $table->integer('progress')->nullable()->default(0);
            $table->enum('bill_type', ['fix rate', 'project_hours', 'task_hours'])
                ->default('fix rate');
            $table->decimal('total_rate', 12, 2)->nullable()->default(0)
                ->comment('Total billable rate or cost');
            $table->decimal('estimated_hours', 8, 2)->nullable()->default(0)
                ->comment('Total estimated hours');
            $table->date('start_date')->nullable()->default(null);
            $table->date('deadline')->nullable()->default(null);
            $table->json('tags')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->boolean('is_notify')->nullable()->default(true);
            $table->nullableMorphs('creator');
            $table->integer('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
