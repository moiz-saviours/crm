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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('sender');

            $table->nullableMorphs('sender');
            $table->nullableMorphs('receiver');

            $table->enum('conversation_status', ['pending', 'approved', 'rejected', 'blocked'])
                ->default('pending');

            $table->unsignedBigInteger('last_message_id')->nullable()->default(null);

            $table->integer('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
            $table->softDeletes();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
