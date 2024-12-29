<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prerequisites', function (Blueprint $table) {
            $table->id();
            
            // Foreign key: plan_course relationship
            $table->foreignId('id_plan_course')->nullable();
            $table->foreign('id_plan_course')->references('id')->on('plan_course')
            ->onDelete('set null')->onUpdate('cascade');

            // Foreign key: correlative_course relationship
            $table->foreignId('id_prerequisite_course')->nullable();
            $table->foreign('id_prerequisite_course')->references('id')->on('courses')
            ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prerequisites');
    }
};