<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('email_attachments', function (Blueprint $table) {
            // Add new column for base64 storage
            $table->longText('base64_content')->nullable()->after('original_name');

            // Drop old file-storage related columns
            $table->dropColumn(['storage_name', 'storage_path']);
        });
    }

    public function down(): void
    {
        Schema::table('email_attachments', function (Blueprint $table) {
            // Restore dropped columns
            $table->string('storage_name')->nullable()->default(null)->after('original_name');
            $table->string('storage_path')->nullable()->default(null)->after('size');

            // Remove base64 column
            $table->dropColumn('base64_content');
        });
    }
};
