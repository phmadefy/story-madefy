<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHomologCfgBoleto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bancos', function (Blueprint $table) {
            $table->text('oath_homolog_path')->nullable();
            $table->text('oath_prod_path')->nullable();
        });

        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => \Database\Seeders\BancosTableSeeder::class,
            '--force' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bancos', function (Blueprint $table) {
            $table->dropColumn('oath_homolog_path');
            $table->dropColumn('oath_prod_path');
        });
    }
}
