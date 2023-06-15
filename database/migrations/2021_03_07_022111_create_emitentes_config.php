<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmitentesConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emitentes_config', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('modelo')->default(55);
            $table->integer('sequencia')->default(1);
            $table->integer('sequencia_homolog')->default(1);
            $table->integer('serie')->default(1);
            $table->integer('serie_homolog')->default(1);
            $table->integer('tipo_nota')->default(1);
            $table->integer('tipo_emissao')->default(1);
            $table->integer('tipo_impressao')->default(1);
            $table->integer('tipo_ambiente')->default(2);

            $table->string('csc')->nullable();
            $table->string('csc_id')->nullable();

            $table->string('csc_homolog')->nullable();
            $table->string('csc_id_homolog')->nullable();

            $table->uuid('uuid')->unique();

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
        Schema::dropIfExists('emitentes_config');
    }
}
