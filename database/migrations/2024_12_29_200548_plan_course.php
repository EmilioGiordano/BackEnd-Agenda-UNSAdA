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
        Schema::create('plan_course', function (Blueprint $table) {
            $table->id();
            
            // Foreign key: plan_course relationship
            $table->foreignId('id_plan')->nullable();
            $table->foreign('id_plan')->references('id')->on('carrer_plans')
            ->onDelete('set null')->onUpdate('cascade');

            // Foreign key: course relationship
            $table->foreignId('id_course')->nullable();
            $table->foreign('id_course')->references('id')->on('courses')
            ->onDelete('set null')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_course');
    }
};