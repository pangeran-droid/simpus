<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rak extends Model
{
    protected $fillable = [
        'nama_rak',
        'lokasi',
    ];

    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class, 'rak_id');
    }
}
