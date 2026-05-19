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
        if (!Schema::hasTable('eqpuipements')){
           Schema::create('eqpuipements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_eqpt');
            $table->string('model');
            $table->string('cod_sit');
            $table->string('serial_num');
            

            $table->integer('id_site')->unsigned()->index()->nullable();
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');

            $table->timestamps();
        });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eqpuipements');
    }
};
