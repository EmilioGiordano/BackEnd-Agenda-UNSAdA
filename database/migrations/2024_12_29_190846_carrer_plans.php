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
        Schema::create('carrer_plans', function (Blueprint $table) {
            $table->id();
            $table->string('carrer_name');
            $table->string('proposal_code');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('carrer_plans');
    }
};