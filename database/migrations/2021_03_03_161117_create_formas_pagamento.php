<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormasPagamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formas_pagamento', function (Blueprint $table) {

            $table->increments('id');
            $table->string('forma');
            $table->string('id_sefaz', 2)->default('99');
            $table->integer('parcelamento')->default(0);
            $table->integer('max_parcelas')->default(0);
            $table->integer('cliente_required')->default(0);
            $table->integer('extend')->default(0);

            $table->string('observacao')->nullable();
            $table->integer('status')->default(1);

            $table->uuid('uuid')->unique();
            $table->uuid('company_id');

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
        Schema::dropIfExists('formas_pagamento');
    }
}
