<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tipo')->default(1); // 1 - Normal | 2 - Serviço
            $table->string('nome');
            $table->string('codigo_barras')->nullable();
            $table->string('referencia')->nullable();
            $table->string('unidade', 5)->default('UN');

            $table->decimal('estoque_atual', 10, 4)->default(0);
            $table->decimal('valor_custo', 10, 4)->default(0);
            $table->decimal('margem', 10, 4)->default(0);
            $table->decimal('valor_venda', 10, 4)->default(0);

            $table->integer('origem')->default(0);

            $table->string('ncm', 20)->nullable();
            $table->string('cfop', 20)->nullable();

            $table->string('cst_icms', 5)->nullable();
            $table->decimal('p_icms', 10, 4)->default(0);

            $table->string('cst_ipi', 5)->nullable();
            $table->decimal('p_ipi', 10, 4)->default(0);

            $table->string('cst_pis', 5)->nullable();
            $table->decimal('p_pis', 10, 4)->default(0);

            $table->string('cst_cofins', 5)->nullable();
            $table->decimal('p_cofins', 10, 4)->default(0);

            $table->integer('status')->default(1);

            $table->text('foto')->nullable();

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
        Schema::dropIfExists('product');
    }
}
