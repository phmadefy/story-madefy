<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalNfce extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_nfce', function (Blueprint $table) {
            $table->integerIncrements('id');

            //destinatário
            $table->string('nome')->nullable();
            $table->string('fantasia')->nullable();
            $table->string('cnpj', 20)->nullable();

            $table->string('inscricao_estadual', 20)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('ibge', 20)->nullable();

            //totais
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('desconto', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->integer('serie');
            $table->integer('sequencia');
            $table->integer('tipo_ambiente');
            $table->integer('cstatus')->default(1);
            $table->string('status')->default('Aberta');
            $table->string('chave', 44);
            $table->string('recibo', 50)->nullable();
            $table->string('protocolo', 50)->nullable();
            $table->text('xjust')->nullable();
            $table->date('data_emissao')->nullable();

            $table->uuid('uuid')->unique();

            //emitente
            $table->uuid('emitente_id')->nullable();
            $table->foreign('emitente_id')->references('uuid')->on('emitentes');

            //cliente
            $table->uuid('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('uuid')->on('pessoal');

            //venda
            $table->uuid('venda_id')->nullable();
            $table->foreign('venda_id')->references('uuid')->on('vendas');

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
        Schema::dropIfExists('fiscal_nfce');
    }
}
