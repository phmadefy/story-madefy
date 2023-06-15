<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('description');

            //users
            $table->integer('create_user')->default(0);
            $table->integer('update_user')->default(0);
            $table->integer('delete_user')->default(0);

            //permissions
            $table->integer('create_permission')->default(0);
            $table->integer('update_permission')->default(0);
            $table->integer('delete_permission')->default(0);

            $table->integer('create_pessoal')->default(0);
            $table->integer('update_pessoal')->default(0);
            $table->integer('delete_pessoal')->default(0);

            $table->integer('create_product')->default(0);
            $table->integer('update_product')->default(0);
            $table->integer('delete_product')->default(0);

            $table->integer('create_emitente')->default(0);
            $table->integer('update_emitente')->default(0);
            $table->integer('delete_emitente')->default(0);

            $table->integer('create_payments')->default(0);
            $table->integer('update_payments')->default(0);
            $table->integer('delete_payments')->default(0);

            $table->integer('create_sale')->default(0);
            $table->integer('update_sale')->default(0);
            $table->integer('delete_sale')->default(0);

            $table->integer('create_monitor')->default(0);
            $table->integer('update_monitor')->default(0);
            $table->integer('delete_monitor')->default(0);

            $table->integer('create_nfe')->default(0);
            $table->integer('update_nfe')->default(0);
            $table->integer('delete_nfe')->default(0);

            $table->integer('create_caixa')->default(0);
            $table->integer('update_caixa')->default(0);
            $table->integer('delete_caixa')->default(0);

            $table->integer('create_contas')->default(0);
            $table->integer('update_contas')->default(0);
            $table->integer('delete_contas')->default(0);

            $table->integer('create_receitas')->default(0);
            $table->integer('update_receitas')->default(0);
            $table->integer('delete_receitas')->default(0);

            $table->uuid('uuid')->unique();

            $table->uuid('company_id');
            $table->foreign('company_id')->references('uuid')->on('company')->onDelete('cascade')->onUpdate('no action');

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
        Schema::dropIfExists('users_permissions');
    }
}
