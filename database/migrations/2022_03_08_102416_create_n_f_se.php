<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNFSe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_nfse', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('emitente_id');
            $table->uuid('pagador_id');
            $table->uuid('contrato_id');
            $table->integer('numero');
            $table->string('serie');
            $table->string('im');
            $table->boolean('producao');
            $table->string('codigoVerificacao');
            $table->boolean('status')->default(true);

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

            $table->foreign('contrato_id')
                ->references('uuid')
                ->on('contratos')
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
        Schema::dropIfExists('fiscal_nfse');
    }
}
