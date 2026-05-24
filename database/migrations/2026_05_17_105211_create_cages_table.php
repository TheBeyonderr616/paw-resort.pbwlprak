<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. A-01, A-02
            $table->string('name');
            $table->string('type')->default('standard'); // standard, vip
            $table->enum('status', ['available', 'occupied', 'locked'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cages');
    }
};