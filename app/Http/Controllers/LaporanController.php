<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $status = $request->status;
        $userId = $request->user_id;
        $bukuId = $request->buku_id;

        $query = Peminjaman::with([
            'user',
            'buku.kategori',
            'buku.rak',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter tanggal
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai) {
            $query->whereDate('tanggal_pinjam', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $query->whereDate('tanggal_pinjam', '<=', $tanggalSelesai);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        */

        if ($status) {
            $query->where('status', $status);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter peminjam
        |--------------------------------------------------------------------------
        */

        if ($userId) {
            $query->where('user_id', $userId);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter buku
        |--------------------------------------------------------------------------
        */

        if ($bukuId) {
            $query->where('buku_id', $bukuId);
        }

        $data = $query
            ->orderBy('tanggal_pinjam', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalTransaksi = $data->count();

        $totalDipinjam = $data
            ->where('status', 'dipinjam')
            ->count();

        $totalKembali = $data
            ->where('status', 'kembali')
            ->count();

        $totalTerlambat = $data
            ->where('status', 'terlambat')
            ->count();

        $totalDenda = $data->sum('denda');

        /*
        |--------------------------------------------------------------------------
        | Data filter
        |--------------------------------------------------------------------------
        */

        $users = User::where('usertype', 'user')
            ->orderBy('name', 'asc')
            ->get();

        $bukus = Buku::orderBy('judul', 'asc')
            ->get();

        $title = 'Laporan Transaksi';

        return view(
            'admin.laporan.index',
            compact(
                'data',
                'users',
                'bukus',
                'title',
                'tanggalMulai',
                'tanggalSelesai',
                'status',
                'userId',
                'bukuId',
                'totalTransaksi',
                'totalDipinjam',
                'totalKembali',
                'totalTerlambat',
                'totalDenda'
            )
        );
    }
}