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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orphan_id')->constrained()->cascadeOnDelete();

            $table->string('guardian_id_number');
            $table->string('guardian_housing');
            $table->string('guardian_whats_phone');
            $table->string('guardian_first_phone');
            $table->string('guardian_secound_phone');
            $table->string('guardian_email');
            $table->enum('health_status' , ['جيد' , 'مريض']);
            $table->enum('disease_type' , ['مرض عادي' , 'مرض مزمن' , 'مرض عضال'])->nullable();
            $table->string('medical_report')->nullable();
            $table->string('not_available_medical_report')->nullable();
            $table->enum('educational_status' , ['دون سن الدراسة' , 'يدرس' , 'لا يدرس']);
            $table->enum('academic_stage' , ['ابتدائي' , 'اعدادي'])->nullable();
            $table->string('average')->nullable();

            $table->string('educational_certificate')->nullable();
            $table->string('not_available_educational_certificate')->nullable();


            $table->enum('receive_guarantee' , ['bank' , 'wallet']);
            $table->integer('account_number')->nullable();
            $table->string('bank')->nullable();
            $table->string('phone_number_linked_account')->nullable();
            $table->string('wallet_number')->nullable();
            $table->string('wallet_owner')->nullable();
            $table->string('wallet_owner_id_number')->nullable();
            $table->string('wallet_owner_id_number_image')->nullable();
            $table->string('not_available_wallet_owner_id_number_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
