<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    protected $table = 'finance_receitas';

    protected $fillable = [
        'description', 'documento', 'valor', 'vencimento', 'valor_pago', 'data_pago', 'historico', 'uuid',
        'company_id', 'categoria_id', 'venda_id', 'cliente_id', 'cliente', 'vendedor_id', 'vendedor',
        'contrato_id', 'isBoleto'
    ];

    protected $hidden = ['id'];

    // protected $appends = ['sit_status'];

    public function getSituacaoAttribute()
    {
        $now = new \DateTime();
        $vencimento = new \DateTime($this->attributes['vencimento']);

        $diff = $now->diff($vencimento);

        if ($diff->invert > 0 && $diff->days > 0 && $this->attributes['situacao'] == 1) {
            return 0;
        }
        return $this->attributes['situacao'];
    }

    public function categoria()
    {
        return $this->hasOne('App\Models\ReceitaCategoria', 'uuid', 'categoria_id');
    }

    public function vendedor()
    {
        return $this->hasOne('App\Models\Pessoal', 'uuid', 'vendedor_id');
    }

    public function cliente()
    {
        return $this->hasOne('App\Models\Pessoal', 'uuid', 'cliente_id');
    }

    public function venda()
    {
        return $this->hasOne('App\Models\venda', 'uuid', 'venda_id');
    }

    public function contrato(){
        return $this->belongsTo(Contrato::class, 'contrato_id', 'uuid');
    }
}
