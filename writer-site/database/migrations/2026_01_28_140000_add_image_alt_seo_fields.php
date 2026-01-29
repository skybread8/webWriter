<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('hero_image_alt', 255)->nullable()->after('hero_image');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->string('cover_image_alt', 255)->nullable()->after('cover_image');
        });

        Schema::table('book_images', function (Blueprint $table) {
            $table->string('alt', 255)->nullable()->after('image_path');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('photo_alt', 255)->nullable()->after('photo');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('featured_image_alt', 255)->nullable()->after('featured_image');
        });

        Schema::table('reader_photos', function (Blueprint $table) {
            $table->string('photo_alt', 255)->nullable()->after('photo');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('image_alt', 255)->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', fn (Blueprint $t) => $t->dropColumn('hero_image_alt'));
        Schema::table('books', fn (Blueprint $t) => $t->dropColumn('cover_image_alt'));
        Schema::table('book_images', fn (Blueprint $t) => $t->dropColumn('alt'));
        Schema::table('testimonials', fn (Blueprint $t) => $t->dropColumn('photo_alt'));
        Schema::table('blog_posts', fn (Blueprint $t) => $t->dropColumn('featured_image_alt'));
        Schema::table('reader_photos', fn (Blueprint $t) => $t->dropColumn('photo_alt'));
        Schema::table('pages', fn (Blueprint $t) => $t->dropColumn('image_alt'));
    }
};
