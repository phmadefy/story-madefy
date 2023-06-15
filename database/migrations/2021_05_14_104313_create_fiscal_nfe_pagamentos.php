<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalNfePagamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_nfe_pagamentos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('forma');

            $table->decimal('valor_pago', 15, 4);
            $table->decimal('valor_resto', 15, 4);

            $table->string('observacao')->nullable();

            $table->uuid('uuid')->unique();
            $table->uuid('forma_id');

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
        Schema::dropIfExists('fiscal_nfe_pagamentos');
    }
}
