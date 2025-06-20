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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // USD, EUR, IDR, etc.
            $table->string('name'); // US Dollar, Euro, Indonesian Rupiah
            $table->string('symbol', 10); // $, €, Rp
            $table->decimal('rate_to_usd', 15, 6)->default(1.000000); // Exchange rate to USD
            $table->boolean('is_active')->default(true);
            $table->boolean('is_base_currency')->default(false); // IDR as base
            $table->integer('decimal_places')->default(2); // Currency precision
            $table->timestamp('last_updated')->nullable(); // When rate was last updated
            $table->timestamps();
            
            $table->index(['code', 'is_active']);
            $table->index('is_base_currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
