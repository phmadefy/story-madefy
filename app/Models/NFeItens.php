<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NFeItens extends Model
{
    protected $table = "fiscal_nfe_itens";

    protected $fillable = [
        'produto', 'cEAN', 'quantidade', 'valor_custo', 'valor_unitario', 'desconto', 'total',
        'unidade', 'cfop', 'ncm', 'cst_icms', 'p_icms', 'cst_ipi', 'p_ipi', 'cst_pis', 'p_pis', 'cst_cofins', 'p_cofins',
        'uuid', 'nota_id', 'produto_id',
    ];

    protected $hidden = [
        'id'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'uuid', 'produto_id');
    }
}
