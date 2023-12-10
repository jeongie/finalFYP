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
        Schema::create('extraction', function (Blueprint $table) {
            $table->id();
            $table->string('PID');
            $table->string('Date');
            $table->decimal('BMI', 8, 2);
            $table->string('Resting_BP');
            $table->string('Peak_BP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extraction');
    }
};
