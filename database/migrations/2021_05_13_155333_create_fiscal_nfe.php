<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalNfe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_nfe', function (Blueprint $table) {
            $table->integerIncrements('id');

            //ide settings
            $table->string('natOpe', 1000)->default('Venda de Mercadoria');
            $table->integer('tpNF')->default(1);
            $table->integer('idDest')->default(1);
            $table->integer('finNFe')->default(1);
            $table->integer('indFinal')->default(0);
            $table->integer('indPres')->default(1);

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
            $table->string('cPais', 20)->default('1058');
            $table->string('xPais')->default('Brasil');

            //transportadora
            $table->integer('modFrete')->default(9);

            $table->string('transp_nome')->nullable();
            $table->string('transp_cnpj', 20)->nullable();
            $table->string('transp_ie', 20)->nullable();
            $table->string('transp_address')->nullable();
            $table->string('transp_cidade')->nullable();
            $table->string('transp_uf', 2)->nullable();

            //veículo
            $table->string('veiculo_placa')->nullable();
            $table->string('veiculo_uf')->nullable();
            $table->string('veiculo_rntc')->nullable();

            //volumes
            $table->string('volume_qVol')->nullable();
            $table->string('volume_esp')->nullable();
            $table->string('volume_marca')->nullable();
            $table->string('volume_nVol')->nullable();
            $table->string('volume_pesoL')->nullable();
            $table->string('volume_pesoB')->nullable();

            //outros
            $table->text('infCpl')->nullable();

            //totais
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('frete', 10, 2)->default(0);
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
            $table->uuid('company_id');
            $table->foreign('company_id')->references('uuid')->on('company');

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
        Schema::dropIfExists('fiscal_nfe');
    }
}
