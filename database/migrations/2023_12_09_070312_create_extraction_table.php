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
            $table->unsignedBigInteger('user_id');
            $table->string('PID');
            
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->decimal('hb1ac', 5, 2)->nullable();
            $table->string('hypertension')->nullable();
            $table->decimal('cholestrol', 5, 2)->nullable();
            $table->string('smoking')->nullable();
            $table->string('alcohol')->nullable();
            $table->string('diet')->nullable();
            $table->decimal('bmi', 8, 2)->nullable();
            $table->decimal('ef', 5,2)->nullable();

            $table->float('METS')->nullable();
            $table->integer('Rest HR')->nullable();
            $table->integer('Peak HR')->nullable();
            $table->string('HR reserve')->nullable();
            $table->string('HR recovery')->nullable();
  
            $table->string('Rest BP')->nullable();
            $table->string('Peak BP')->nullable();
            
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