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

        Schema::create('siblings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orphan_id')->constrained()->onDelete('cascade');
            $table->string('brother_name');
            $table->string('brother_gender');
            $table->integer('brother_age');
            $table->enum('brother_marital_status' , ['أعزب','متزوج','أرمل','مطلق','مهجورة']);
            $table->string('brother_jop');
            $table->string('brother_id_number'); // هنا ممكن تعمل unique
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siblings');
    }
};
