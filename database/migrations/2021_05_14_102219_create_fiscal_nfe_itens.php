<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalNfeItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_nfe_itens', function (Blueprint $table) {
            $table->increments('id');

            $table->string('produto');

            $table->string('cEAN', 20)->nullable();

            $table->decimal('quantidade', 15, 4);
            $table->decimal('valor_custo', 15, 4);
            $table->decimal('valor_unitario', 15, 4);
            $table->decimal('desconto', 15, 4);
            $table->decimal('total', 15, 4);

            $table->string('unidade', 3)->nullable();
            $table->string('cfop', 5)->nullable();
            $table->string('ncm', 20)->nullable();

            $table->string('cst_icms', 4)->nullable();
            $table->decimal('p_icms', 15, 2)->default(0);

            $table->string('cst_ipi', 2)->nullable();
            $table->decimal('p_ipi', 15, 2)->default(0);

            $table->string('cst_pis', 2)->nullable();
            $table->decimal('p_pis', 15, 2)->default(0);

            $table->string('cst_cofins', 2)->nullable();
            $table->decimal('p_cofins', 15, 2)->default(0);

            $table->uuid('uuid')->unique();

            $table->uuid('nota_id');
            $table->foreign('nota_id')->references('uuid')->on('fiscal_nfe')->onDelete('cascade')->onUpdate('no action');

            $table->uuid('produto_id')->nullable();
            $table->foreign('produto_id')->references('uuid')->on('produtos')->onDelete('set null')->onUpdate('no action');

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
        Schema::dropIfExists('fiscal_nfe_itens');
    }
}
