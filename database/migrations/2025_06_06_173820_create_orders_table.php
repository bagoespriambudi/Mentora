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
            Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('service_id')->constrained()->onDelete('cascade');
        $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
        $table->string('status')->default('pending'); // pending, approved, in_progress, completed, cancelled
        $table->text('notes')->nullable();
        $table->timestamp('order_date');
        $table->decimal('total_price', 10, 2);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
