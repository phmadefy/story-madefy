<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceReceitasCategorias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_receitas_categorias', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome');
            $table->integer('status')->default(1);

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
        Schema::dropIfExists('finance_receitas_categorias');
    }
}
