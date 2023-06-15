<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('tipo_contato'); // 1 - Email | 2 - Telefone
            $table->string('contato');

            $table->uuid('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('uuid')->on('clientes')->onDelete('cascade');

            $table->uuid('transportadora_id')->nullable();
            $table->foreign('transportadora_id')->references('uuid')->on('transportadoras')->onDelete('cascade');

            $table->uuid('fornecedor_id')->nullable();
            $table->foreign('fornecedor_id')->references('uuid')->on('fornecedores')->onDelete('cascade');

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
        Schema::dropIfExists('clientes_contatos');
    }
}
