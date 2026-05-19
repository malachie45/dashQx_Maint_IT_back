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

        if(!Schema::hasTable('techniciens')){
            Schema::create('techniciens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matri');
            $table->string('nom');
            $table->string('pren');
            $table->string('contact');
            $table->string('adress');
            $table->timestamps();
        });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('techniciens');
    }
};
