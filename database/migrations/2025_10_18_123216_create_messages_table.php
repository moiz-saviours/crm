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

            $table->unsignedBigInteger('conversation_id');
            $table->foreign('conversation_id')
                ->references('id')
                ->on('conversations')
                ->onDelete('NO ACTION');

            $table->unsignedBigInteger('senderable_id');
            $table->string('senderable_type');

            $table->unsignedBigInteger('reply_to')->nullable()->default(null);
            $table->foreign('reply_to')
                ->references('id')
                ->on('messages')
                ->onDelete('NO ACTION');

            $table->text('content')->nullable();
            $table->enum('message_type', ['text', 'image', 'video', 'audio', 'file', 'system'])
                ->default('text');

            $table->enum('message_status', ['sent', 'delivered', 'seen', 'failed'])
                ->default('sent');
            $table->boolean('status')->default(true);
            $table->timestamp('edited_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['senderable_id', 'senderable_type']);
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->foreign('last_message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign('conversations_last_message_id_foreign');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['conversation_id']);
            $table->dropForeign(['reply_to']);
        });

        Schema::dropIfExists('messages');
    }
};
