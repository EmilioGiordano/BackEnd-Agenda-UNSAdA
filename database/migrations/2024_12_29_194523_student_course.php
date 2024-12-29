<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
       Schema::create('student_course', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_student')->nullable();
            $table->foreign('id_student')->references('id')->on('students')
            ->onDelete('set null')->onUpdate('cascade');

            $table->foreignId('id_course')->nullable();
            $table->foreign('id_course')->references('id')->on('courses')
            ->onDelete('set null')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    
    public function down(): void
    {
       
    }
};