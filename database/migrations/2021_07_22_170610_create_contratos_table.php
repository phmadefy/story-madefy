<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tipo_recorrencia')->default(0); // 0 - Sem recorrência | - 1 Com recorrência
            $table->integer('periodo_recorrencia')->default(1); // por mes | 1 = 1 mes

            $table->integer('dia_faturamento')->nullable(); // dia de gerar os dados
            $table->date('data_faturamento')->nullable();

            $table->integer('emitir_nfse')->default(0); // 0 Para não emitir | 1 -  para emitir
            $table->integer('emitir_nfe')->default(0); // 0 Para não emitir | 1 -  para emitir
            $table->integer('gerar_financeiro')->default(0); // 0 Para não emitir | 1 -  para emitir

            $table->integer('send_docs')->default(0); // 0 Para não enviar | 1 -  para enviar

            $table->decimal('valor_contrato', 15, 2)->default(0);

            $table->text('description')->nullable();

            $table->integer('status_id')->default(1); // 0 - Cancelado | 1 - Aberto | 2 - Confirmado | 10 - Finalizado
            $table->string('status')->default('Aberto');

            $table->uuid('uuid')->unique();

            $table->uuid('forma_pagamento')->nullable();
            $table->foreign('forma_pagamento')->references('uuid')->on('formas_pagamento');

            $table->uuid('company_id');
            $table->foreign('company_id')->references('uuid')->on('company');

            $table->uuid('user_id');
            $table->foreign('user_id')->references('uuid')->on('users');

            $table->uuid('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('uuid')->on('clientes');

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
        Schema::dropIfExists('contratos');
    }
}
