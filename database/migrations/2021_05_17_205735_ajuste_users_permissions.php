<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjusteUsersPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_permissions', function (Blueprint $table) {

            $table->integer('pay_sale')->after('update_sale')->default(0);
            $table->integer('desconto_sale')->after('pay_sale')->default(0);

            $table->integer('pay_contas')->after('update_contas')->default(0);
            // $table->integer('cancel_contas')->after('pay_contas')->default(0);

            $table->integer('pay_receitas')->after('update_receitas')->default(0);
            // $table->integer('cancel_receitas')->after('pay_receitas')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
