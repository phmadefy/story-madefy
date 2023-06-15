<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

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
        return $this->hasOne('App\Models\FornecedorCategories', 'uuid', 'categoria_id');
    }

    public function contatos()
    {
        return $this->hasMany(Contato::class, 'fornecedor_id', 'uuid');
    }
}
