<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjusteNfeColumContratoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiscal_nfe', function (Blueprint $table) {
            //contrato
            $table->uuid('contrato_id')->nullable()->after('venda_id');
            $table->foreign('contrato_id')->references('uuid')->on('contratos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiscal_nfce', function (Blueprint $table) {
            //
        });
    }
}
