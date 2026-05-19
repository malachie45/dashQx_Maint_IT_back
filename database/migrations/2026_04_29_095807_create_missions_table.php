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

        if(!Schema::hasTable('missions')){
             Schema::create('missions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('objet_mission');
            $table->string('observation');
            $table->date('dat_deb');
            $table->date('dat_fin');

            $table->integer('id_site')->unsigned()->index()->nullable();
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');

            $table->integer('id_tech')->unsigned()->index()->nullable();
            $table->foreign('id_tech')->references('id')->on('techniciens')->onDelete('cascade');

            $table->timestamps();
        });
        }

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
