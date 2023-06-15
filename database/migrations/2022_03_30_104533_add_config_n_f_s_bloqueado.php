<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfigNFSBloqueado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emitentes_config_nfs', function (Blueprint $table) {
            $table->boolean('bloqueado')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emitentes_config_nfs', function (Blueprint $table) {
            $table->dropColumn('bloqueado');
        });
    }
}
