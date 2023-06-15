<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoal extends Model
{
    protected $table = 'pessoal';

    protected $fillable = [
        'tipo', 
        'nome', 
        'apelido', 
        'identidade', 
        'cpf', 
        'telefone', 
        'telefone_secondary', 
        'email', 
        'observacao', 
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
        return $this->hasOne('App\Models\PessoalCategorias', 'uuid', 'categoria_id');
    }
}
