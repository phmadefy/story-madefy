<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportadora extends Model
{
    protected $table = 'transportadoras';

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
        'categoria_id',
    ];

    protected $hidden = ['id'];

    public function categoria()
    {
        return $this->hasOne('App\Models\TransportadoraCategories', 'uuid', 'categoria_id');
    }

    public function contatos()
    {
        return $this->hasMany(Contato::class, 'transportadora_id', 'uuid');
    }
}
