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
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->index(['is_admin', 'visited_at'], 'visitor_logs_admin_time_index');
            $table->index(['is_admin', 'page_type', 'visited_at'], 'visitor_logs_admin_page_time_index');
            $table->index(['is_admin', 'device_type', 'visited_at'], 'visitor_logs_admin_device_time_index');
            $table->index(['is_admin', 'browser', 'visited_at'], 'visitor_logs_admin_browser_time_index');
            $table->index(['is_admin', 'city', 'visited_at'], 'visitor_logs_admin_city_time_index');
            $table->index(['is_admin', 'referrer', 'visited_at'], 'visitor_logs_admin_referrer_time_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->dropIndex('visitor_logs_admin_time_index');
            $table->dropIndex('visitor_logs_admin_page_time_index');
            $table->dropIndex('visitor_logs_admin_device_time_index');
            $table->dropIndex('visitor_logs_admin_browser_time_index');
            $table->dropIndex('visitor_logs_admin_city_time_index');
            $table->dropIndex('visitor_logs_admin_referrer_time_index');
        });
    }
};
