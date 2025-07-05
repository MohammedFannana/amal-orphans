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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['pending','active'])->default('pending');
            $table->foreignId('orphan_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('duration')->min(1);
            $table->integer('bail_amount')->min(1);
            $table->string('payment_received');
            $table->string('thank_letter_video')->nullable();
            $table->string('thank_letter_audio')->nullable();

            $table->string('delivery_bail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
