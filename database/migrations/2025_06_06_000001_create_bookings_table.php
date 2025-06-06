<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('tutor_sessions')->onDelete('cascade');
            $table->foreignId('tutee_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
}; 