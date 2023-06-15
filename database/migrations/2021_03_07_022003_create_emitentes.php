<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmitentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emitentes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('ultNSU')->default(0);
            $table->integer('tipo')->default(1);
            $table->integer('crt')->default(1); // 1 - Simples nacional
            $table->string('razao');
            $table->string('fantasia')->nullable();
            $table->string('cnpj', 20)->nullable();
            $table->string('inscricao_estadual', 25)->nullable();
            $table->string('inscricao_municipal', 25)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('email_contabil')->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('ibge', 10)->nullable();
            $table->integer('status')->default(1);
            $table->text('logo')->nullable();
            $table->text('file_pfx')->nullable();
            $table->string('senha_pfx', 50)->nullable();
            $table->uuid('uuid')->unique();

            $table->uuid('company_id');
            $table->foreign('company_id')->references('uuid')->on('company')->onDelete('cascade')->onUpdate('no action');

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
        Schema::dropIfExists('emitentes');
    }
}
