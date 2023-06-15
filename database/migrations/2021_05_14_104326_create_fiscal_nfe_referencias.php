<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalNfeReferencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_nfe_referencias', function (Blueprint $table) {
            $table->increments('id');

            $table->string('numero_nota');
            $table->string('chave');
            $table->integer('tipo')->default(1); //entradas

            $table->uuid('nota_id');
            $table->foreign('nota_id')->references('uuid')->on('fiscal_nfe')->onDelete('cascade')->onUpdate('no action');

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
        Schema::dropIfExists('fiscal_nfe_referencias');
    }
}
