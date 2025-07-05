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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('country');
            $table->string('address');
            $table->string('password');
            $table->enum('receive_report' , ['yes','no']);
            $table->enum('payment_reminder' , ['yes','no']);
            $table->enum('payment_mechanism' , ['bank','credit_card','debit_card','PALPAY','benefit_pay']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
