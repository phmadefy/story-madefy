<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'tipo', 'razao', 'fantasia', 'cnpj', 'inscricao_estadual', 'telefone', 'email',
        'cep', 'logradouro', 'numero', 'bairro', 'complemento', 'cidade', 'uf', 'ibge', 'status',
        'uuid', 'modelo_negocio', 'logo_full', 'logo_min', 'data_expire', 'layout'
    ];

    protected $hidden = ['id'];

    public function getLogoFullAttribute()
    {
        if (!isset($this->attributes['logo_full'])) {
            return null;
        }
        $path = $this->attributes['logo_full'];
        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }
        return null;
    }

    public function getLogoMinAttribute()
    {
        if (!isset($this->attributes['logo_min'])) {
            return null;
        }
        $path = $this->attributes['logo_min'];
        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }
        return null;
    }
}
