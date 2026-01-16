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
        Schema::create('reader_photos', function (Blueprint $table) {
            $table->id();
            $table->string('photo'); // Ruta de la imagen
            $table->string('reader_name')->nullable(); // Nombre del lector (opcional)
            $table->text('caption')->nullable(); // Descripción o comentario (opcional)
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reader_photos');
    }
};
