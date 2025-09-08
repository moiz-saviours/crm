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
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'agent_type')) {
                $table->string('agent_type')->nullable()->default('App\Models\User')->after('agent_id');
            }
            $table->dropForeign(['agent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'agent_type')) {
                $table->dropColumn('agent_type');
            }
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('NO ACTION');
        });
    }
};
