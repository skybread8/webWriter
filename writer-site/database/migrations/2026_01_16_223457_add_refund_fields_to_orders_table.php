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
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('refunded')->default(false)->after('shipped_at');
            $table->timestamp('refunded_at')->nullable()->after('refunded');
            $table->decimal('refund_amount', 10, 2)->nullable()->after('refunded_at');
            $table->text('refund_reason')->nullable()->after('refund_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['refunded', 'refunded_at', 'refund_amount', 'refund_reason']);
        });
    }
};
