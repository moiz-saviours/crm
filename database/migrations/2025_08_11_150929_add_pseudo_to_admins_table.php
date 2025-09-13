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
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'pseudo_name')) {
                $table->string('pseudo_name')->nullable()->default(null)->after('name');
            }
            if (!Schema::hasColumn('admins', 'pseudo_email')) {
                $table->string('pseudo_email')->nullable()->default(null)->after('email');
            }
            if (!Schema::hasColumn('admins', 'pseudo_phone')) {
                $table->string('pseudo_phone')->nullable()->default(null)->after('phone_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'pseudo_name')) {
                $table->dropColumn('pseudo_name');
            }
            if (Schema::hasColumn('admins', 'pseudo_email')) {
                $table->dropColumn('pseudo_email');
            }
            if (Schema::hasColumn('admins', 'pseudo_phone')) {
                $table->dropColumn('pseudo_phone');
            }
        });
    }
};
