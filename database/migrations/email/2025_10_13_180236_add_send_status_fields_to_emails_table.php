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
        Schema::table('emails', function (Blueprint $table) {
            $table->enum('send_status', ['pending', 'sent', 'failed'])
                ->default('pending')
                ->index()
                ->after('folder');

            $table->text('error_message')
                ->nullable()
                ->comment('Error message if sending fails')
                ->after('send_status');

            $table->unsignedTinyInteger('retry_count')
                ->default(0)
                ->comment('Number of resend attempts')
                ->after('error_message');

            $table->timestamp('last_attempt_at')
                ->nullable()
                ->comment('Timestamp of last send attempt')
                ->after('retry_count');
        });
    }

    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->dropColumn(['send_status', 'error_message', 'retry_count', 'last_attempt_at']);
        });
    }
};
