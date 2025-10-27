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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pseudo_record_id')->nullable()->default(null);
            // Thread management
            $table->string('thread_id')->nullable()->default(null)->index()->comment('Unique thread identifier');
            $table->string('message_id')->nullable()->default(null)->comment('Email Message-ID header');
            $table->string('in_reply_to')->nullable()->default(null)->comment('Parent message ID');
            $table->text('references')->nullable()->default(null)->comment('All message references in thread');
            // Email metadata
            $table->string('from_email')->nullable()->default(null);
            $table->string('from_name')->nullable()->default(null);
            $table->json('to')->nullable()->default(null);
            $table->json('cc')->nullable()->default(null);
            $table->json('bcc')->nullable()->default(null);
            $table->string('subject')->nullable()->default(null);
            $table->longText('body_html')->nullable()->default(null);
            $table->text('body_text')->nullable()->default(null);
            // IMAP specific
            $table->bigInteger('imap_uid')->nullable()->default(null)->comment('IMAP UID');
            $table->string('imap_folder')->nullable()->default(null)->comment('IMAP folder name');
            $table->json('imap_flags')->nullable()->default(null)->comment('IMAP flags as JSON');
            // Status and type management
            $table->enum('type', ['incoming', 'outgoing', 'draft'])->default('incoming');
            $table->enum('folder', ['inbox', 'sent', 'drafts', 'spam', 'trash', 'archive'])->default('inbox');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_important')->default(false);
            $table->boolean('is_starred')->default(false);
            // Timestamps
            $table->timestamp('message_date')->useCurrent();
            $table->timestamp('sent_at')->nullable()->default(null);
            $table->timestamp('received_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            // Indexes for performance
            $table->index(['pseudo_record_id', 'folder']);
            $table->index(['pseudo_record_id', 'thread_id']);
            $table->index(['pseudo_record_id', 'message_date']);
            $table->index(['pseudo_record_id', 'is_read']);
            $table->foreign('pseudo_record_id')->references('id')->on('user_pseudo_records')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
