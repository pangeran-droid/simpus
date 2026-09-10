<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Buku extends Model
{
    protected $fillable = [
        'kode_buku',
        'judul',
        'kategori_id',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'rak',
        'cover',
        'deskripsi',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
