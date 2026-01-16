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
        Schema::create('sent_emails', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'contact', 'order_confirmation', 'password_reset', etc.
            $table->string('to_email');
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->boolean('sent')->default(true);
            $table->text('error')->nullable();
            $table->timestamp('sent_at');
            $table->timestamps();
            
            $table->index('type');
            $table->index('sent_at');
            $table->index('to_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};
