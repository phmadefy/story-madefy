<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('emitente_id');
            $table->uuid('pagador_id');
            $table->unsignedBigInteger('banco_id');
            $table->uuid('cfgBoleto_id');
            $table->dateTime('emissao');
            $table->date('vencimento');
            $table->decimal('valor', 16, 4);
            $table->decimal('valorAbatimento', 16, 4)->nullable();
            $table->decimal('tipoDesconto1', 16, 4)->nullable();
            $table->date('dataDesconto1')->nullable();
            $table->decimal('qtdDesconto1', 16,4)->nullable();
            $table->decimal('tipoDesconto2', 16, 4)->nullable();
            $table->date('dataDesconto2')->nullable();
            $table->decimal('qtdDesconto2', 16,4)->nullable();
            $table->decimal('tipoDesconto3', 16, 4)->nullable();
            $table->date('dataDesconto3')->nullable();
            $table->decimal('qtdDesconto3', 16,4)->nullable();
            $table->string('estadoTitulo')->nullable();
            $table->text('descricaoEstadoTitulo')->nullable();


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

            $table->foreign('pagador_id')
                ->references('uuid')
                ->on('clientes')
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
        Schema::dropIfExists('boletos');
    }
}
