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
                // Device tracking
                $table->string('session_id')->nullable()->default(null);
                $table->string('device_id')->nullable()->default(null);
                $table->string('ip_address', 45)->nullable()->default(null);
                $table->text('user_agent')->nullable()->default(null);
                // Verification code
                $table->string('code', 6)->nullable()->default(null);
                $table->string('method')->nullable()->default(null);
                // Status
                $table->timestamp('expires_at')->nullable()->default(null);
                $table->timestamp('verified_at')->nullable()->default(null);
                $table->string('status')->nullable()->default(null);
                // Additional data
                $table->json('response')->nullable()->default(null);
                $table->string('response_id')->nullable()->default(null);
                $table->timestamps();
                $table->softDeletes();
                // Indexes
                $table->index(['morph_id', 'morph_type']);
                $table->index(['code', 'expires_at', 'verified_at']);
                $table->index(['device_id', 'ip_address']);
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
