<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sequencia');
            $table->string('cliente')->default('Consumidor Final');
            $table->string('cpf')->nullable();

            $table->decimal('subtotal', 10, 4)->default(0);
            $table->decimal('descontos', 10, 4)->default(0);
            $table->decimal('desconto', 10, 4)->default(0);
            $table->decimal('total', 10, 4)->default(0);
            $table->decimal('total_custo', 10, 4)->default(0);

            $table->text('description')->nullable();

            $table->integer('status_id')->default(1);
            $table->string('status')->default('Aberta');

            $table->uuid('uuid')->unique();
            $table->uuid('company_id');
            $table->uuid('user_id');
            $table->uuid('cliente_id')->nullable();

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
        Schema::dropIfExists('vendas');
    }
}
