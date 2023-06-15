<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDemoCfg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boletos_cfg', function (Blueprint $table) {
            $table->text('demonstrativo1')->nullable();
            $table->text('demonstrativo2')->nullable();
            $table->text('demonstrativo3')->nullable();
            $table->text('instrucao1')->nullable();
            $table->text('instrucao2')->nullable();
            $table->text('instrucao3')->nullable();
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
            $table->dropColumn('demonstrativo1');
            $table->dropColumn('demonstrativo2');
            $table->dropColumn('demonstrativo3');
            $table->dropColumn('instrucao1');
            $table->dropColumn('instrucao2');
            $table->dropColumn('instrucao3');
        });
    }
}
