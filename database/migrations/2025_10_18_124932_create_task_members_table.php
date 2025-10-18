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
        Schema::create('task_members', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('task_id')->nullable()->default(null);
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('memberable_id')->nullable()->default(null);
            $table->string('memberable_type')->nullable()->default(null);

            $table->string('role', 100)->nullable()->default(null);
            $table->boolean('is_active')->nullable()->default(true);

            $table->timestamps();

            $table->unique(
                ['task_id', 'memberable_id', 'memberable_type'],
                'unique_task_member'
            );
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_members');
    }
};
