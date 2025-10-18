<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete()
                ->comment('Linked brand reference');

            $table->string('special_key', 100)->unique()->comment('Unique internal key for project tracking');
            $table->string('brand_key', 100)->nullable();
            $table->string('team_key', 100)->nullable();

            $table->string('type', 50)->nullable();
            $table->enum('value', ['regular', 'standard', 'premium', 'exclusive'])->default('regular');
            $table->string('label', 50)->nullable();
            $table->string('theme_color', 50)->nullable();

            $table->enum('status', ['isprogress', 'on hold', 'cancelled', 'finished'])->default('isprogress');
            $table->boolean('is_progress')->default(false);
            $table->integer('progress')->default(0);

            $table->enum('bill_type', ['fix rate', 'project_hours', 'task_hours'])->default('fix rate');
            $table->decimal('total_rate', 12, 2)->default(0)->comment('Total billable rate or cost');
            $table->decimal('estimated_hours', 8, 2)->default(0)->comment('Total estimated hours');

            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();

            $table->json('tags')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_notify')->default(true);

            $table->nullableMorphs('created_morph');

            $table->timestamps();
            $table->softDeletes()->comment('Soft delete support for project recovery');
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
