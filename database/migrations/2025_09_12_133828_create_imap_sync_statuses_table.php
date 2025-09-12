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
        Schema::create('imap_sync_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pseudo_record_id')->nullable()->default(null);

            $table->string('folder_name')->comment('IMAP folder name');
            $table->bigInteger('last_uid')->default(0);
            $table->bigInteger('uid_validity')->default(0);
            $table->timestamp('last_sync_at')->nullable();
            $table->integer('synced_count')->default(0);
            $table->text('sync_error')->nullable();
            $table->timestamps();

            $table->unique(['pseudo_record_id', 'folder_name']);
            $table->foreign('pseudo_record_id')->references( 'id')->on('user_pseudo_records')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imap_sync_statuses');
    }
};
