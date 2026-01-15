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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Nombre del autor');
            $table->string('tagline')->nullable()->default('Una frase breve y evocadora');
            // Texto principal del héroe (en portada). En el panel lo llamamos "Título principal".
            $table->text('hero_text')->nullable()->default('Historias escritas en la sombra, para leerse en silencio.');
            $table->string('hero_image')->nullable();
            $table->string('contact_email')->nullable()->default('admin@example.com');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
