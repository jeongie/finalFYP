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
            // $table->unsignedBigInteger('user_id');
            $table->string('PID');
            $table->string('cabg')->nullable();
            $table->string('hb1ac')->nullable();
            $table->string('Rest HR')->nullable();
            $table->string('hypertension')->nullable();
            $table->string('cholestrol')->nullable();
            $table->string('smoking')->nullable();
            $table->string('alcohol')->nullable();
            $table->decimal('bmi', 8, 2)->nullable();
            $table->string('Rest BP')->nullable();
            $table->string('Peak BP')->nullable();
            $table->string('METS')->nullable();
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