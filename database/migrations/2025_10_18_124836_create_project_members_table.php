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
        Schema::create('project_members', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('project_id')->nullable()->default(null);
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('NO ACTION');

            $table->unsignedBigInteger('memberable_id')->nullable()->default(null);
            $table->string('memberable_type')->nullable()->default(null);

            $table->string('role', 100)->nullable()->default(null);
            $table->boolean('is_active')->nullable()->default(true);

            $table->timestamps();

            $table->unique(
                ['project_id', 'memberable_id', 'memberable_type'],
                'unique_project_member'
            );
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};
