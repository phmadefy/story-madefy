<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataIniEVendedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->uuid('vendedor_id')->nullable();
            $table->dateTime('data_inicio_prestacao')->nullable();
            $table->text('numero_cliente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn('vendedor_id');
            $table->dropColumn('data_inicio_prestacao');
            $table->dropColumn('numero_cliente');
        });
    }
}
