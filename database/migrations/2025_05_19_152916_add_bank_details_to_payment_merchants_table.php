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
        Schema::table('payment_merchants', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_merchants', 'bank_details')) {
                $table->longText('bank_details')->nullable()->default(null)->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_merchants', function (Blueprint $table) {
            if (Schema::hasColumn('payment_merchants', 'bank_details')) {
                $table->dropColumn('bank_details');
            }
        });
    }
};
