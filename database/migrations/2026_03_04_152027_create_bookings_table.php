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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('pet_name')->nullable();
            $table->string('pet_type')->nullable();
            $table->string('breed')->nullable();
            $table->string('pet_photo')->nullable();
            $table->date('reservation_date');
            $table->enum('pawckage', ['daily', 'weekly', 'vip'])->default('daily');
            $table->enum('status', ['pending', 'confirmed', 'declined'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};