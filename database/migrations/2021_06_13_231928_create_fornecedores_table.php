<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tipo')->default(1);
            $table->string('nome');
            $table->string('apelido')->nullable();
            $table->string('identidade', 25)->nullable();
            $table->string('cpf', 16)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('telefone_secondary', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('ibge', 10)->nullable();
            $table->integer('status')->default(1);

            $table->uuid('uuid')->unique();
            $table->uuid('company_id');
            $table->uuid('categoria_id')->nullable();

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
        Schema::dropIfExists('fornecedores');
    }
}
