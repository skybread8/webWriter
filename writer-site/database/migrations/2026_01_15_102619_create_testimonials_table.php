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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del autor del testimonio
            $table->string('photo')->nullable(); // Foto del autor
            $table->text('review'); // Texto del testimonio
            $table->integer('rating')->default(5); // Calificación 1-5
            $table->boolean('active')->default(true); // Visible en el sitio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
