<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $table = 'finance_contas';

    protected $fillable = [
        'description', 'documento', 'valor', 'vencimento', 'valor_pago', 'data_pago', 'historico', 'situacao', 'uuid',
        'company_id', 'categoria_id', 'nota_id', 'cliente_id', 'cliente',
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

    public function cliente()
    {
        return $this->hasOne('App\Models\Pessoal', 'uuid', 'cliente_id');
    }
}
