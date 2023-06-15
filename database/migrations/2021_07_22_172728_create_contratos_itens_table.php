<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos_itens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_produto');
            $table->string('produto');

            $table->decimal('quantidade', 15, 4);
            $table->decimal('valor_custo', 15, 4);
            $table->decimal('valor_unitario', 15, 4);
            $table->decimal('desconto', 15, 4);
            $table->decimal('total', 15, 4);

            $table->uuid('uuid')->unique();

            $table->uuid('contrato_id');
            $table->foreign('contrato_id')->references('uuid')->on('contratos')->onDelete('cascade')->onUpdate('no action');

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
        Schema::dropIfExists('contratos_itens');
    }
}
