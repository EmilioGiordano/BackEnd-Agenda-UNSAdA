<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('year');
            $table->integer('semester');

            // Foreign Key: id_deparment
            $table->foreignId('id_deparment')->nullable();
            $table->foreign('id_deparment')->references('id')->on('deparment')
                ->onDelete('set null')->onUpdate('cascade');  


            

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};