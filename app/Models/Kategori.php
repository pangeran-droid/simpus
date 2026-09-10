<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $fillable = [
        'kategori',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}
