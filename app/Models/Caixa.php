<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    protected $table = 'caixa';

    protected $fillable = [
        'tipo', 'description', 'valor', 'uuid', 'forma_id', 'forma', 'user_id', 'venda_id', 'conta_id', 'receita_id', 'company_id',
    ];

    protected $hidden = ['id'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'uuid', 'user_id');
    }
}
