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
        Schema::create('email_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email_id');
            $table->enum('event_type', ['open', 'click', 'forward', 'reply', 'bounce', 'delivery', 'unsubscribe', 'spam_report']);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->text('url')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('email_id')
                ->references('id')->on('emails')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_events');
    }
};
