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
        Schema::create('message_attachments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('message_id')->nullable()->default(null);
            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('NO ACTION');

            $table->string('file_name')->nullable()->default(null);
            $table->string('file_path')->nullable()->default(null);
            $table->string('file_type', 100)->nullable()->default(null);
            $table->unsignedBigInteger('file_size')->nullable()->default(null);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_attachments');
    }
};
