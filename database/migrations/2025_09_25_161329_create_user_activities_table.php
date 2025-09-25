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
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->string('event_type')->nullable()->default(null);
            $table->json('event_data')->nullable()->default(null);
            $table->string('ip')->nullable()->default(null);
            $table->string('user_agent')->nullable()->default(null);
            $table->string('country')->nullable()->default(null);
            $table->string('state')->nullable()->default(null);
            $table->string('region')->nullable()->default(null);
            $table->string('zip_code')->nullable()->default(null);
            $table->string('browser')->nullable()->default(null);
            $table->string('latitude')->nullable()->default(null);
            $table->string('longitude')->nullable()->default(null);
            $table->SoftDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
