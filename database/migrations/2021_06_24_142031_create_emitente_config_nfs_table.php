<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmitenteConfigNfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emitentes_config_nfs', function (Blueprint $table) {
            $table->id('id');

            $table->uuid('uuid')->unique();
            
            $table->integer('tipo')->default(1);
            $table->integer('tipo_ambiente')->default(1);
            $table->integer('sequencia')->default(1);
            $table->integer('sequencia_homolog')->default(1);
            $table->string('serie')->default(1);
            $table->string('serie_homolog')->default(1);
            
            $table->uuid('emitente_id'); 
            $table->foreign('emitente_id')->references('uuid')->on('emitentes')->onDelete('cascade')->onUpdate('no action');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emitente_config_nfs');
    }
}
