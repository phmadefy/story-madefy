<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCfgBoletos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletos_cfg', function (Blueprint $table) {
            $table->id();

            $table->uuid('emitente_id');
            $table->unsignedBigInteger('banco_id');
            $table->text('app_key')->nullable();
            $table->text('app_client')->nullable();
            $table->text('app_secret')->nullable();
            $table->string('convenio')->nullable();
            $table->string('carteira')->nullable();
            $table->string('variacao')->nullable();
            $table->string('modalidade')->nullable();
            $table->text('msgBoleto')->nullable();
            $table->integer('diasProtesto')->nullable();
            $table->boolean('recebeTituloVencido')->nullable();
            $table->integer('diasLimiteRecebimento')->nullable();
            $table->boolean('codigoAceite')->nullable();
            $table->string('codigoTipoTitulo')->nullable();
            $table->string('descricaoTipoTitulo')->nullable();
            $table->boolean('RecebimentoParcial')->nullable();
            $table->string('tipoJurosMora')->nullable();
            $table->decimal('porcentagemJurosMora')->nullable();
            $table->decimal('valorJurosMora')->nullable();
            $table->string('tipoMulta')->nullable();
            $table->integer('diasInicioMulta')->nullable();
            $table->decimal('porcentagemMulta')->nullable();
            $table->decimal('valorMulta')->nullable();
            $table->integer('quantidadeDiasNegativacao')->nullable();
            $table->string('orgaoNegativador')->nullable();
            $table->boolean('producao')->default(true);
            $table->boolean('padrao')->default(false);


            $table->uuid('uuid')->unique();
            $table->uuid('company_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')
                ->references('uuid')
                ->on('company')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('emitente_id')
                ->references('uuid')
                ->on('emitentes')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('banco_id')
                ->references('codigo')
                ->on('bancos')
                ->onDelete('no action')
                ->onUpdate('no action');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletos_cfg');
    }
}
