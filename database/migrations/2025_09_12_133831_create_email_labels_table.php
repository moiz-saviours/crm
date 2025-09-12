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
        Schema::create('email_labels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pseudo_record_id')->nullable()->default(null);

            $table->string('name');
            $table->string('color')->default('#64748b');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->unique(['pseudo_record_id', 'name']);
            $table->foreign('pseudo_record_id')->references( 'id')->on('user_pseudo_records')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_labels', function (Blueprint $table) {
            if (Schema::hasColumn('email_labels', 'pseudo_record_id')) {
                $table->dropForeign(['pseudo_record_id']);
            }
        });
        Schema::dropIfExists('email_labels');
    }
};
