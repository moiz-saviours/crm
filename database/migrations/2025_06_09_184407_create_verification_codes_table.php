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
        if (!Schema::hasTable('verification_codes')) {
            Schema::create('verification_codes', callback: function (Blueprint $table) {
                $table->id();
                $table->nullableMorphs('morph');
                $table->string('code', 6)->nullable()->default(null);
                $table->string('method')->nullable()->default(null);
                $table->timestamp('expires_at')->nullable()->default(null);
                $table->timestamp('verified_at')->nullable()->default(null);
                $table->json('response')->nullable();
                $table->string('status')->nullable();
                $table->string('response_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->index(['morph_id', 'morph_type']);
                $table->index(['code', 'expires_at', 'verified_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};
