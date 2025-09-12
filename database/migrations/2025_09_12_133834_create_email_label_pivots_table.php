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
        Schema::create('email_label_pivots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email_id')->nullable()->default(null);

            $table->unsignedBigInteger('label_id')->nullable()->default(null);

            $table->timestamps();

            $table->unique(['email_id', 'label_id']);

            $table->foreign('email_id')->references( 'id')->on('emails')->onDelete('NO ACTION');
            $table->foreign('label_id')->references( 'id')->on('email_labels')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('email_label_pivot', function (Blueprint $table) {
            if (Schema::hasColumn('email_label_pivot', 'email_id')) {
                $table->dropForeign(['email_id']);
            }
            if (Schema::hasColumn('email_label_pivot', 'label_id')) {
                $table->dropForeign(['label_id']);
            }
        });
        Schema::dropIfExists('email_label_pivots');
    }
};
