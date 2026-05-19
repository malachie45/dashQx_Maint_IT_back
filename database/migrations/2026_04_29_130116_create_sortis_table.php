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
        if (!Schema::hasTable('sortis')){
            Schema::create('sortis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('sit');
            $table->string('eqpt');
            $table->date('date_sorti');
            $table->date('date_fin_trait');
            $table->string('cod_sit');
            $table->string('serial_num');
            $table->string('observ');
            $table->string('statut');
            $table->string('image')->nullable();
            
            $table->integer('id_site')->unsigned()->index()->nullable();
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');

            /* $table->inetger('id_eqpt')->unsigned()->index()->nullable();
            $table->foreign('id_eqpt')->references('id')->on('eqpuipements')->onDelete('cascade'); */

            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sortis');
    }
};
