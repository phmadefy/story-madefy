<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalNfeEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_nfe_eventos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('sequencia');

            $table->string('evento');
            $table->integer('cEvento');
            $table->string('xJust')->nullable();

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
        Schema::dropIfExists('fiscal_nfe_eventos');
    }
}
