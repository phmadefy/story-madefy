<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposCategoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiposCategoria', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->string('codigo');
            $table->string('endPoint');
            $table->timestamps();
        });

        \App\Models\TiposCategoria::create([
           'descricao' => 'Clientes',
            'codigo' => 'cat_clientes',
            'endPoint' => 'cliente/categoria'
        ]);

        \App\Models\TiposCategoria::create([
            'descricao' => 'Contas',
            'codigo' => 'cat_contas',
            'endPoint' => 'finance/conta/categoria'
        ]);

        \App\Models\TiposCategoria::create([
            'descricao' => 'Receitas',
            'codigo' => 'cat_receitas',
            'endPoint' => 'finance/receita/categoria'
        ]);

        \App\Models\TiposCategoria::create([
            'descricao' => 'Fornecedores',
            'codigo' => 'cat_fornecedores',
            'endPoint' => 'fornecedor/categoria'
        ]);

        \App\Models\TiposCategoria::create([
            'descricao' => 'Pessoal',
            'codigo' => 'cat_pessoal',
            'endPoint' => 'pessoal/categoria'
        ]);

        \App\Models\TiposCategoria::create([
            'descricao' => 'Produtos',
            'codigo' => 'cat_produtos',
            'endPoint' => 'product/categoria'
        ]);

        \App\Models\TiposCategoria::create([
            'descricao' => 'Transportadoras',
            'codigo' => 'cat_transportadoras',
            'endPoint' => 'transportadora/categoria'
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiposCategoria');
    }
}
