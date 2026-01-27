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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // order_created, order_paid, order_shipped, order_refunded, user_registered, password_reset
            $table->string('name'); // Nombre descriptivo
            $table->string('subject'); // Asunto del correo
            $table->text('body'); // Cuerpo del correo (puede contener variables como {{order_number}}, {{user_name}}, etc.)
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
