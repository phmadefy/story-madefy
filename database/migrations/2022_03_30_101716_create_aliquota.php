<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAliquota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aliquotas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->date('referencia');
            $table->uuid('emitente_id');
            $table->uuid('company_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')
                ->references('uuid')
                ->on('company')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('emitente_id')
                ->references('uuid')
                ->on('emitentes')
                ->onDelete('cascade')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aliquotas');
    }
}
