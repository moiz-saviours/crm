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
        Schema::create('user_pseudo_records', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('morph');
            $table->string('pseudo_name')->nullable()->default(null);
            $table->string('pseudo_email')->nullable()->default(null)->unique();
            $table->string('pseudo_phone')->nullable()->default(null);
            $table->string('server_host')->nullable()->default(null);
            $table->string('server_port')->nullable()->default(null);
            $table->string('server_encryption')->nullable()->default(null);
            $table->string('server_username')->nullable()->default(null);
            $table->string('server_password')->nullable()->default(null);
            $table->enum('imap_type', ['imap', 'smtp', 'custom'])->default('imap');
            $table->nullableMorphs('creator');
            $table->tinyInteger('is_verified')->nullable()->default(0)->comment('0 = unverified, 1 = verified');
            $table->tinyInteger('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pseudo_records');
    }
};
