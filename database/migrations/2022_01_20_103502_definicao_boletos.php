<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefinicaoBoletos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletos_definicao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('banco_id');
            $table->string('field');
            $table->text('description');
            $table->text('options')->nullable();
            $table->text('information')->nullable();
            $table->boolean('required')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletos_definicao');
    }
}
