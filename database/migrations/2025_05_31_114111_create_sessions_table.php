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
        Schema::create('tutor_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->bigInteger('price'); // Price in Indonesian Rupiah (Rp)
            $table->integer('duration_days');
            $table->string('thumbnail');
            $table->json('gallery')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('schedule')->nullable(); // Session schedule
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor_sessions');
    }
};