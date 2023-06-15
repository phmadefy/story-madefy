<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOnBoletos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boletos', function (Blueprint $table) {
            $table->text('nossoNumero')->nullable();
            $table->text('linhaDigitavel')->nullable();
            $table->text('codigoBarraNumerico')->nullable();
            $table->text('numeroContratoCobranca')->nullable();
            $table->text('agencia')->nullable();
            $table->text('contaCorrente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boletos', function (Blueprint $table) {
            $table->dropColumn('nossoNumero');
            $table->dropColumn('linhaDigitavel');
            $table->dropColumn('codigoBarraNumerico');
            $table->dropColumn('numeroContratoCobranca');
            $table->dropColumn('agencia');
            $table->dropColumn('contaCorrente');
        });
    }
}
