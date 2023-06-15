<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Galeria extends Model
{
    protected $table = 'galerias';

    protected $fillable = [
        'produto_id', 
        'foto',
    ];

    // protected $hidden = ['id'];
    
    public function getFotoAttribute()
    {
        if (!isset($this->attributes['foto'])) {
            return null;
        }
        $path = $this->attributes['foto'];
        if (Storage::disk('public')->exists($path) && isset($this->attributes['foto'])) {
            return Storage::url($path);
        }
        return null;
    }

    public function produtos()
    {
        return $this->belongsTo(Product::class, 'produto_id', 'uuid');
    }
}
