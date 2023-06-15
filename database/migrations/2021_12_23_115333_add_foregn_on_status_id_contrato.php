<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForegnOnStatusIdContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        \App\Models\Contrato::where('status_id', '<>', 1)->update(['status_id' => 1]);

        Schema::table('contratos', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->default(1)->change();
            $table->dropColumn('status');

            $table->foreign('status_id')
                ->references('id')
                ->on('statusContrato')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
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
            $table->string('status');
        });
    }
}
