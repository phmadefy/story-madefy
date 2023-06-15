<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

    protected $fillable = [
        'id',
        'sequencia', 
        'cliente', 
        'cpf', 
        'subtotal', 
        'desconto', 
        'descontos', 
        'total', 
        'total_custo',
        'description', 
        'status', 
        'status_id', 
        'uuid', 
        'company_id', 
        'cliente_id', 
        'user_id',
    ];

    protected $hidden = [];

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'uuid', 'company_id');
    }
    public function vendedor()
    {
        return $this->hasOne('App\Models\User', 'uuid', 'user_id');
    }
    public function itens()
    {
        return $this->hasMany(VendaItem::class, 'venda_id', 'uuid');
    }
    public function pagamentos()
    {
        return $this->hasMany(VendaPagamento::class, 'venda_id', 'uuid');
    }
    public function nfce()
    {
        return $this->hasOne('App\Models\FiscalNFCe', 'venda_id', 'uuid');
    }
}
