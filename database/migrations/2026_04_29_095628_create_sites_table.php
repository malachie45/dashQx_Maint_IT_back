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
        if (!Schema::hasTable('sites')){
           Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_site');
            $table->string('adress');
            $table->string('contact');
            $table->string('chef_agce');
            $table->timestamps();
        });  
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
