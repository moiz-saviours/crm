<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Matheus Daniel Update
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('client_contacts')) {
            Schema::create('client_contacts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('special_key')->nullable()->default(null)->unique();
                $table->string('name')->nullable()->default(null);
                $table->string('email')->unique();
                $table->string('phone')->nullable()->default(null);
                $table->string('address')->nullable()->default(null);
                $table->string('city')->nullable()->default(null);
                $table->string('state')->nullable()->default(null);
                $table->string('country')->nullable()->default(null);
                $table->string('zipcode')->nullable()->default(null);
                $table->string('ip_address')->nullable()->default(null);
                $table->morphs('creator');
                $table->integer('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
                $table->softDeletes();
                $table->timestamps();

                $table->index('special_key');

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_contacts');
    }
};
