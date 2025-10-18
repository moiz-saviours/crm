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

            $table->unsignedBigInteger('senderable_id');
            $table->string('senderable_type');

            $table->unsignedBigInteger('receiverable_id');
            $table->string('receiverable_type');

            $table->enum('conversation_status', ['pending', 'approved', 'rejected', 'blocked'])
                ->default('pending');

            $table->unsignedBigInteger('last_message_id')->nullable()->default(null);

            $table->boolean('status')->default(true);


            $table->timestamps();

            $table->index(['senderable_id', 'senderable_type']);
            $table->index(['receiverable_id', 'receiverable_type']);
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
