<?php

use Illuminate\Database\Seeder;

class PopulateStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\StatusContrato::create([
            'descricao' => 'Aberto',
            'codigo' =>  'st_aberto'
        ]);

        \App\Models\StatusContrato::create([
            'descricao' => 'Iniciado',
            'codigo' =>  'st_iniciado'
        ]);

        \App\Models\StatusContrato::create([
            'descricao' => 'Cancelado',
            'codigo' =>  'st_cancelado'
        ]);

        \App\Models\StatusContrato::create([
            'descricao' => 'Finalizado',
            'codigo' =>  'st_finalizado'
        ]);

        \App\Models\StatusContrato::create([
            'descricao' => 'Deletado',
            'codigo' =>  'st_deleteado'
        ]);
    }
}
