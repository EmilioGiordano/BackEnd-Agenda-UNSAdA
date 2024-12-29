<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');

            // Foreign Key: id_user
            $table->foreignId('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');  
            
            // Foreign Key: id_carrer_plan
            $table->foreignId('id_carrer_plan')->nullable();
            $table->foreign('id_carrer_plan')->references('id')->on('carrer_plans')
                ->onDelete('set null')->onUpdate('cascade');  
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};