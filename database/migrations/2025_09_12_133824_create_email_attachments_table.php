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
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email_id')->nullable()->default(null);

            $table->string('original_name');
            $table->string('storage_name');
            $table->string('mime_type');
            $table->bigInteger('size');
            $table->string('storage_path');
            $table->string('content_id')->nullable();
            $table->boolean('is_inline')->default(false);
            $table->timestamps();
            $table->foreign('email_id')->references( 'id')->on('emails')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_attachments');
    }
};
