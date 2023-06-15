<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjusteNewColunsUsersPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_permissions', function (Blueprint $table) {
            //users
            $table->integer('create_contratos')->default(0)->after('delete_receitas');
            $table->integer('update_contratos')->default(0)->after('create_contratos');
            $table->integer('pay_contratos')->default(0)->after('update_contratos');
            $table->integer('delete_contratos')->default(0)->after('pay_contratos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_permissions', function (Blueprint $table) {
            //
        });
    }
}
