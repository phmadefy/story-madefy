<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'produtos';
    
    protected $fillable = [
        'tipo', 
        'nome', 
        'codigo_barras', 
        'referencia', 'unidade', 
        'estoque_atual', 
        'valor_custo', 
        'margem', 
        'valor_venda',
        'origem', 
        'ncm', 
        'cfop', 
        'cst_icms', 
        'p_icms', 
        'cst_ipi', 
        'p_ipi', 
        'cst_pis', 
        'p_pis', 
        'cst_cofins', 
        'p_cofins',
        'iss_retido',
        'p_iss',
        'status', 
        'foto', 
        'uuid', 
        'company_id', 
        'categoria_id',
    ];

    // protected $hidden = ['id'];
    protected $appends = ['foto_capa'];
    
    public function categoria()
    {
        return $this->hasOne('App\Models\ProductCategorias', 'uuid', 'categoria_id');
    }

    public function movimentos()
    {
        return $this->hasMany(ProductMovimento::class, 'produto_id', 'uuid');
    }
    
    public function fotos()
    {
        return $this->hasMany(Galeria::class, 'produto_id', 'uuid');
    }
    
    public function getFotoCapaAttribute()
    {
        if (isset($this->attributes['foto'])) {
            $foto_capa = Galeria::where('id', $this->attributes['foto'])->first();
            return $foto_capa;
        }
    }
}
