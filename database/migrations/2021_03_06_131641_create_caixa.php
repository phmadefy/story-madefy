<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaixa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caixa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo')->default(1); // 1 - entrada | 2 - saída

            $table->text('description');
            $table->decimal('valor', 10, 4)->default(0);

            $table->uuid('uuid')->unique();

            $table->uuid('forma_id')->nullable();
            $table->foreign('forma_id')->references('uuid')->on('formas_pagamento');
            $table->string('forma', 50);

            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('uuid')->on('users');

            $table->uuid('conta_id')->nullable();
            $table->uuid('receita_id')->nullable();

            $table->uuid('venda_id')->nullable();
            $table->foreign('venda_id')->references('uuid')->on('vendas')->onDelete('cascade')->onUpdate('no action');

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
        Schema::dropIfExists('caixa');
    }
}
