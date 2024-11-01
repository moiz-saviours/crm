<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Matheus Daniel Update
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('column')->nullable()->default(null);
                $table->string('column')->nullable()->default(null);
                $table->decimal('column', 8, 2)->nullable()->default(null);
                $table->integer('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('foreign_id')->references('id')->on('foreign_table')->onDelete('NO ACTION');

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
