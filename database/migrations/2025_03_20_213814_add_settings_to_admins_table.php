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
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'settings')) {
                $table->json('settings')->default(
                    json_encode([
                        'layouts' => [
                            'fluidLayout' => true,
                            'boxedLayout' => false,
                            'centeredLayout' => false
                        ],
                        'transitions' => [
                            'transitionTiming' => 'out-quart'
                        ],
                        'header' => [
                            'stickyHeader' => true
                        ],
                        'navigation' => [
                            'stickyNav' => true,
                            'profileWidget' => true,
                            'miniNav' => false,
                            'maxiNav' => true,
                            'pushNav' => false,
                            'slideNav' => false,
                            'revealNav' => false
                        ],
                        'sidebar' => [
                            'disableBackdrop' => false,
                            'staticPosition' => false,
                            'stuckSidebar' => false,
                            'uniteSidebar' => false,
                            'pinnedSidebar' => false
                        ],
                        'colors' => [
                            'themeColor' => false,
                            'colorScheme' => 'navy',
                            'colorSchemeMode' => 'tm--primary-mn'
                        ],
                        'font' => [
                            'fontSize' => 16
                        ],
                        'scrollbars' => [
                            'bodyScrollbar' => false,
                            'sidebarScrollbar' => false
                        ]
                    ])

                )->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'settings')) {
                $table->dropColumn('settings');
            }
        });
    }
};
