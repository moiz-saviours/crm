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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('special_key')->nullable()->default(null)->unique();
            $table->string('name')->nullable()->default(null);
            $table->string('slug', 120)->nullable()->unique()->comment('URL-friendly identifier');
            $table->string('url')->nullable()->default(null)->unique();
            $table->string('logo')->nullable()->default(null);
            $table->string('favicon')->nullable()->default(null);
            $table->string('description', 500)->nullable();
            $table->string('language', 10)->nullable()->default('en');
            $table->string('timezone', 50)->nullable()->default('UTC');
            $table->nullableMorphs('creator');
            $table->nullableMorphs('owner');
            $table->tinyInteger('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
            $table->string('meta_title', 100)->nullable()->default(null);
            $table->string('meta_description', 200)->nullable()->default(null);
            $table->string('meta_keywords')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('last_activity_at')->nullable();
            $table->index('special_key');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
