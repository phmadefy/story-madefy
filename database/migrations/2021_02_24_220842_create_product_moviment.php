<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMoviment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_movimentos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tipo')->default(1);
            $table->uuid('produto_id');
            $table->uuid('user_id')->nullable();
            $table->uuid('venda_id')->nullable();
            $table->decimal('quantidade', 10, 4)->default(0);
            $table->decimal('valor_custo', 10, 4)->default(0);
            $table->uuid('nota_id')->nullable();
            $table->string('numero_nota', 50)->nullable();
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
        Schema::dropIfExists('product_moviment');
    }
}
