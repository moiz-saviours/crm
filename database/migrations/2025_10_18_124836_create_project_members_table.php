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

            $table->nullableMorphs('member');

            $table->string('role')->nullable()->default(null);
            $table->boolean('is_active')->nullable()->default(true);

            $table->softDeletes();
            $table->timestamps();

            $table->unique(
                ['project_id'],
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
