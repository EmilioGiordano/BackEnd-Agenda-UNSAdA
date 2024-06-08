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
        Schema::create('student_courses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_estudiante')->unsigned()->nullable();
            $table->foreign('id_estudiante')->references('id')->on('students')
            ->onUpdate('cascade')
            ->onDelete('set null');

            
            $table->unsignedBigInteger('id_asignatura')->unsigned()->nullable();
            $table->foreign('id_asignatura')->references('id')->on('courses')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_courses_status');
    }
};