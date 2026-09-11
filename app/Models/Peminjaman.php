<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    
    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_realisasi_kembali',
        'status',
        'denda',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
