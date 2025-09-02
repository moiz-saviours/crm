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
        if (!Schema::hasTable('user_pseudo_records')) {
            Schema::create('user_pseudo_records', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->default(null);
                $table->string('pseudo_name')->nullable()->default(null);
                $table->string('pseudo_email')->nullable()->default(null);
                $table->string('pseudo_phone')->nullable()->default(null);
                $table->nullableMorphs('creator');
                $table->tinyInteger('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('user_pseudo_records')) {
            Schema::dropIfExists('user_pseudo_records');
        }
    }
};
