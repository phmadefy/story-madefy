<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceContas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_contas', function (Blueprint $table) {
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

            $table->uuid('nota_id')->nullable();
            $table->foreign('nota_id')->references('uuid')->on('nfe_imports')->onDelete('cascade')->onUpdate('no action');

            $table->uuid('cliente_id');
            $table->string('cliente')->nullable();

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
        Schema::dropIfExists('finance_contas');
    }
}
