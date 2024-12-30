<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('carrer_plans', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_carrer_name')->nullable();
            $table->foreign('id_carrer_name')->references('id')->on('carrer_name')
            ->onDelete('set null')->onUpdate('cascade');

            $table->string('proposal_code');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('carrer_plans');
    }
};