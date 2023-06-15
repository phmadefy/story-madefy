<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceReceitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_receitas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('description')->nullable();
            $table->string('documento')->nullable();

            $table->float('valor', 10, 2)->default(0);
            $table->date('vencimento');

            $table->float('valor_pago', 10, 2)->default(0);
            $table->date('data_pago')->nullable();

            $table->text('historico')->nullable();

            $table->integer('situacao')->default(1);

            $table->uuid('uuid')->unique();

            $table->uuid('company_id');
            $table->foreign('company_id')->references('uuid')->on('company')->onDelete('cascade')->onUpdate('no action');

            $table->uuid('categoria_id')->nullable();

            $table->uuid('venda_id')->nullable();
            $table->foreign('venda_id')->references('uuid')->on('vendas')->onDelete('cascade')->onUpdate('no action');

            $table->uuid('cliente_id');
            $table->string('cliente')->nullable();

            $table->uuid('vendedor_id');
            $table->string('vendedor')->nullable();

            $table->timestamps();
        });

        Schema::table('caixa', function (Blueprint $table) {
            $table->foreign('receita_id')->references('uuid')->on('finance_receitas')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finan_receitas');
    }
}
