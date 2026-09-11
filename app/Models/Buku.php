<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $fillable = [
        'kode_buku',
        'judul',
        'kategori_id',
        'rak_id',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'cover',
        'deskripsi',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function rak(): BelongsTo
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}
