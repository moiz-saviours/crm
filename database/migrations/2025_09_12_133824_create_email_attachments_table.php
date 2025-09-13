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
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email_id')->nullable()->default(null);
            $table->string('original_name')->nullable()->default(null);
            $table->string('storage_name')->nullable()->default(null);
            $table->string('mime_type')->nullable()->default(null);
            $table->bigInteger('size')->nullable()->default(null);
            $table->string('storage_path')->nullable()->default(null);
            $table->string('content_id')->nullable()->default(null);
            $table->boolean('is_inline')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_attachments', function (Blueprint $table) {
            if (Schema::hasColumn('email_attachments', 'email_id')) {
                $table->dropForeign(['email_id']);
            }
        });
        Schema::dropIfExists('email_attachments');
    }
};
