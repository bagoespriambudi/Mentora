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
        Schema::table('payment_transactions', function (Blueprint $table) {
            // Modify existing amount column to support higher precision
            $table->decimal('amount', 15, 6)->change();
            
            // Add new currency-related columns
            $table->string('currency', 3)->default('IDR')->after('amount');
            $table->decimal('amount_usd', 15, 6)->nullable()->after('currency');
            $table->decimal('exchange_rate', 15, 6)->default(1.000000)->after('amount_usd');
            
            // Add indexes for better performance
            $table->index(['currency', 'status']);
            $table->index('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            // Remove currency-related columns
            $table->dropIndex(['currency', 'status']);
            $table->dropIndex(['transaction_date']);
            $table->dropColumn(['currency', 'amount_usd', 'exchange_rate']);
            
            // Revert amount column to original precision
            $table->decimal('amount', 10, 2)->change();
        });
    }
};
