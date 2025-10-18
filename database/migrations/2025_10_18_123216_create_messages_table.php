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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
        $table->morphs('senderable');
        $table->foreignId('reply_to')->nullable()->constrained('messages')->nullOnDelete();
        $table->text('content')->nullable();
        $table->enum('message_type', ['text', 'image', 'video', 'audio', 'file', 'system'])->default('text');
        $table->enum('status', ['sent', 'delivered', 'seen', 'failed'])->default('sent');
        $table->boolean('is_edited')->default(false);
        $table->timestamp('edited_at')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
