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
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'lead_response')) {
                $table->json('lead_response')->nullable()->after('status');
            }

            if (!Schema::hasColumn('leads', 'device_info')) {
                $table->json('device_info')->nullable()->after('lead_response');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'lead_response')) {
                $table->dropColumn('lead_response');
            }

            if (Schema::hasColumn('leads', 'device_info')) {
                $table->dropColumn('device_info');
            }
        });
    }
};
