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

            $table->unsignedBigInteger('project_id')->nullable()->default(null);
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('NO ACTION');

            $table->string('special_key', 100)->unique()->nullable()->default(null);

            $table->enum('task_status', ['isprogress', 'on hold', 'cancelled', 'finished'])
                ->default('isprogress');
            $table->string('label', 50)->nullable()->default(null);

            $table->text('description')->nullable()->default(null);
            $table->boolean('status')->default(true);

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
