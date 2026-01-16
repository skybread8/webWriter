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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->longText('privacy_policy')->nullable()->after('tiktok_url');
            $table->longText('terms_of_service')->nullable()->after('privacy_policy');
            $table->longText('legal_notice')->nullable()->after('terms_of_service');
            $table->longText('cookie_policy')->nullable()->after('legal_notice');
            $table->boolean('cookies_enabled')->default(true)->after('cookie_policy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'privacy_policy',
                'terms_of_service',
                'legal_notice',
                'cookie_policy',
                'cookies_enabled',
            ]);
        });
    }
};
