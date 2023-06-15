<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'tipo',
        'nome',
        'apelido',
        'identidade',
        'cpf',
        'telefone',
        'telefone_secondary',
        'email',
        'description',
        'company_id',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'complemento',
        'cidade',
        'uf',
        'ibge',
        'status',
        'uuid',
        'id',
        'categoria_id',
    ];

    protected $hidden = [];

    public function categoria()
    {
        return $this->hasOne('App\Models\ClienteCategories', 'uuid', 'categoria_id');
    }

    public function contatos()
    {
        return $this->hasMany(Contato::class, 'cliente_id', 'uuid');
    }
}
