<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasPagamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas_pagamentos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('forma');

            $table->decimal('valor_pago', 15, 4);
            $table->decimal('valor_resto', 15, 4);

            $table->string('observacao')->nullable();

            $table->uuid('uuid')->unique();
            $table->uuid('forma_id');

            $table->uuid('venda_id');
            $table->foreign('venda_id')->references('uuid')->on('vendas')->onDelete('cascade')->onUpdate('no action');

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
        Schema::dropIfExists('vendas_pagamentos');
    }
}
