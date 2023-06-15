<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosFaturamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos_faturamentos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('emitir_nfse')->default(0); // 0 Para não emitido | 1 -  para emitido
            $table->integer('emitir_nfe')->default(0); // 0 Para não emitido | 1 -  para emitido
            $table->integer('gerar_financeiro')->default(0); // 0 Para não emitido | 1 -  para emitido

            $table->decimal('valor_contrato', 15, 2)->default(0);

            $table->integer('tipo_faturamento')->default(0); // 0 - para automático | 1 - para manual

            $table->uuid('forma_pagamento')->nullable();
            $table->foreign('forma_pagamento')->references('uuid')->on('formas_pagamento');

            $table->uuid('user_id');
            $table->foreign('user_id')->references('uuid')->on('users');

            $table->uuid('contrato_id');
            $table->foreign('contrato_id')->references('uuid')->on('contratos')->onDelete('cascade');

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
        Schema::dropIfExists('contratos_historico');
    }
}
