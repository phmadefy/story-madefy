<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrimeiroNumeroCfgBoleto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boletos_cfg', function (Blueprint $table) {
            $table->unsignedBigInteger('primeiroBoleto')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boletos_cfg', function (Blueprint $table) {
            $table->dropColumn('primeiroBoleto');
        });
    }
}
