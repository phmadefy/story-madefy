<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Emitente extends Model
{
    protected $table = 'emitentes';

    protected $fillable = [
        'tipo', 'crt', 'razao', 'fantasia', 'cnpj', 'inscricao_estadual', 'inscricao_municipal', 'telefone', 'email', 'email_contabil',
        'cep', 'logradouro', 'numero', 'bairro', 'complemento', 'cidade', 'uf', 'ibge',
        'status', 'logo', 'file_pfx', 'senha_pfx', 'uuid', 'company_id', 'nfe_bloqueado', 'nfs_bloqueado', 'nfc_bloqueado',
    ];

    protected $hidden = ['id'];

    //campos virtuais
    protected $appends = ['logo_url', 'certificate_url'];

    public function getLogoUrlAttribute()
    {
        if (!isset($this->attributes['logo'])) {
            return null;
        }
        $path = $this->attributes['logo'];
        if (Storage::disk('public')->exists($path) && isset($this->attributes['logo'])) {
            return Storage::url($path);
        }
        return null;
    }

    public function getCertificateUrlAttribute()
    {
        if (!isset($this->attributes['file_pfx'])) {
            return null;
        }
        $path = $this->attributes['file_pfx'];
        if (Storage::disk('public')->exists($path) && isset($this->attributes['file_pfx'])) {
            return Storage::url($path);
        }
        return null;
    }

    public function configNF(){
        $this->hasOne(EmitenteConfig::class, 'emitente_id', 'uuid');
    }

    public function configNFS(){
        $this->hasOne(EmitenteConfigNfs::class, 'emitente_id', 'uuid');
    }

    public function aliquitas(){
        return $this->hasMany(Aliquotas::class, 'uuid', 'emitente_id');
    }
}
