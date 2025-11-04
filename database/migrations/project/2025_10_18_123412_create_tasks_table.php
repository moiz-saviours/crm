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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('order_column')->nullable()->default(0);

            $table->unsignedBigInteger('project_id')->nullable()->default(null);
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('NO ACTION');

            $table->unsignedBigInteger('special_key')->nullable()->default(null)->unique();

            $table->enum('task_status', ['is_progress', 'on_hold', 'cancelled', 'finished'])
                ->default('is_progress');
            $table->string('label')->nullable()->default(null);

            $table->text('description')->nullable()->default(null);
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
        Schema::dropIfExists('tasks');
    }
};
