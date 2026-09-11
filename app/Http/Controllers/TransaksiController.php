<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Peminjaman::with([
            'user',
            'buku.kategori',
            'buku.rak',
        ])
            ->orderBy('id', 'desc')
            ->get();

        $title = 'Transaksi Peminjaman';

        return view(
            'admin.transaksi.peminjaman.index',
            compact('data', 'title')
        );
    }

    public function create_peminjaman()
    {
        $users = User::where('usertype', 'user')
            ->orderBy('name', 'asc')
            ->get();

        $bukus = Buku::with(['kategori', 'rak'])
            ->orderBy('judul', 'asc')
            ->get();

        $title = 'Tambah Transaksi Peminjaman';

        return view(
            'admin.transaksi.peminjaman.create',
            compact('users', 'bukus', 'title')
        );
    }

    public function store_peminjaman(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'buku_id' => [
                'required',
                'exists:bukus,id',
            ],
            'tanggal_pinjam' => [
                'required',
                'date',
            ],
            'tanggal_kembali' => [
                'required',
                'date',
                'after_or_equal:tanggal_pinjam',
            ],
        ], [
            'user_id.required' => 'Peminjam wajib dipilih.',
            'user_id.exists' => 'Peminjam tidak ditemukan.',

            'buku_id.required' => 'Buku wajib dipilih.',
            'buku_id.exists' => 'Buku tidak ditemukan.',

            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.date' => 'Tanggal pinjam tidak valid.',

            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.date' => 'Tanggal kembali tidak valid.',
            'tanggal_kembali.after_or_equal' =>
                'Tanggal kembali harus sama atau setelah tanggal pinjam.',
        ]);

        try {

            DB::transaction(function () use ($request) {

                $buku = Buku::where('id', $request->buku_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($buku->stok <= 0) {
                    throw new \Exception(
                        'Buku "' . $buku->judul . '" sedang tidak tersedia karena stok habis.'
                    );
                }

                $kodeTransaksi = $this->generateKodeTransaksi();

                Peminjaman::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'user_id' => $request->user_id,
                    'buku_id' => $buku->id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'tanggal_realisasi_kembali' => null,
                    'status' => 'dipinjam',
                    'denda' => 0,
                ]);

                $buku->decrement('stok');
            });

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.transaksi.peminjaman')
            ->with(
                'success',
                'Transaksi peminjaman berhasil dibuat!'
            );
    }

    /**
     * Membuat kode transaksi otomatis.
     */
    private function generateKodeTransaksi(): string
    {
        do {
            $kode = 'TRX-' . now()->format('YmdHis') . '-' . strtoupper(
                Str::random(4)
            );
        } while (
            Peminjaman::where('kode_transaksi', $kode)->exists()
        );

        return $kode;
    }

    public function detail_peminjaman(string $id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'buku.kategori',
            'buku.rak',
        ])->findOrFail($id);

        $title = 'Detail Transaksi Peminjaman';

        return view('admin.transaksi.peminjaman.detail', compact('peminjaman', 'title'));
    }

    public function edit_peminjaman(string $id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'buku.kategori',
            'buku.rak',
        ])->findOrFail($id);

        if ($peminjaman->status === 'kembali') {
            return redirect()
                ->route('admin.transaksi.peminjaman')
                ->withErrors([
                    'error' => 'Transaksi yang sudah dikembalikan tidak dapat diedit.',
                ]);
        }

        $users = User::where('usertype', 'user')
            ->orderBy('name', 'asc')
            ->get();

        $bukus = Buku::with(['kategori', 'rak'])
            ->orderBy('judul', 'asc')
            ->get();

        $title = 'Edit Transaksi Peminjaman';

        return view(
            'admin.transaksi.peminjaman.edit',
            compact(
                'peminjaman',
                'users',
                'bukus',
                'title'
            )
        );
    }

    public function update_peminjaman(Request $request, string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'kembali') {
            return redirect()
                ->route('admin.transaksi.peminjaman')
                ->withErrors([
                    'error' => 'Transaksi yang sudah dikembalikan tidak dapat diedit.',
                ]);
        }

        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
            ],

            'buku_id' => [
                'required',
                'exists:bukus,id',
            ],

            'tanggal_pinjam' => [
                'required',
                'date',
            ],

            'tanggal_kembali' => [
                'required',
                'date',
                'after_or_equal:tanggal_pinjam',
            ],
        ], [
            'user_id.required' => 'Peminjam wajib dipilih.',
            'user_id.exists' => 'Peminjam tidak ditemukan.',

            'buku_id.required' => 'Buku wajib dipilih.',
            'buku_id.exists' => 'Buku tidak ditemukan.',

            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.date' => 'Tanggal pinjam tidak valid.',

            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.date' => 'Tanggal kembali tidak valid.',
            'tanggal_kembali.after_or_equal' =>
                'Tanggal kembali harus sama atau setelah tanggal pinjam.',
        ]);

        try {

            DB::transaction(function () use ($request, $peminjaman) {

                $transaksi = Peminjaman::where('id', $peminjaman->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $bukuLama = Buku::where('id', $transaksi->buku_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($transaksi->buku_id != $request->buku_id) {

                    $bukuLama->increment('stok');

                    $bukuBaru = Buku::where('id', $request->buku_id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    if ($bukuBaru->stok <= 0) {
                        throw new \Exception(
                            'Buku "' . $bukuBaru->judul .
                            '" tidak dapat dipilih karena stok habis.'
                        );
                    }

                    $bukuBaru->decrement('stok');
                }

                $transaksi->update([
                    'user_id' => $request->user_id,
                    'buku_id' => $request->buku_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                ]);
            });

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.transaksi.peminjaman')
            ->with(
                'success',
                'Transaksi peminjaman berhasil diperbarui!'
            );
    }

    public function destroy_peminjaman(string $id)
    {
        try {

            DB::transaction(function () use ($id) {

                $peminjaman = Peminjaman::where('id', $id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($peminjaman->status === 'kembali') {
                    throw new \Exception(
                        'Transaksi yang sudah dikembalikan tidak dapat dihapus.'
                    );
                }

                $buku = Buku::where('id', $peminjaman->buku_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $buku->increment('stok');

                $peminjaman->delete();
            });

        } catch (\Exception $e) {

            return redirect()
                ->route('admin.transaksi.peminjaman')
                ->withErrors([
                    'error' => $e->getMessage(),
                ]);
        }

        return redirect()->route('admin.transaksi.peminjaman')->with('success', 'Transaksi peminjaman berhasil dihapus dan stok buku telah dikembalikan.');
    }

    public function pengembalian()
    {
        Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', Carbon::today())
            ->update([
                'status' => 'terlambat',
            ]);

        $data = Peminjaman::with([
            'user',
            'buku.kategori',
            'buku.rak',
        ])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        $title = 'Pengembalian Buku';

        return view(
            'admin.transaksi.pengembalian.index',
            compact('data', 'title')
        );
    }

    public function proses_pengembalian(string $id)
    {
        try {

            DB::transaction(function () use ($id) {

                $peminjaman = Peminjaman::where('id', $id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($peminjaman->status === 'kembali') {
                    throw new \Exception(
                        'Buku pada transaksi ini sudah dikembalikan.'
                    );
                }

                $buku = Buku::where('id', $peminjaman->buku_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $tanggalKembali = Carbon::parse(
                    $peminjaman->tanggal_kembali
                );

                $tanggalRealisasi = Carbon::today();

                $terlambat = 0;

                if ($tanggalRealisasi->gt($tanggalKembali)) {
                    $terlambat = (int) $tanggalKembali->diffInDays($tanggalRealisasi);
                }

                /**
                 * Denda 2000 per hari
                 */
                $dendaPerHari = 2000;

                $denda = $terlambat * $dendaPerHari;

                $peminjaman->update([
                    'tanggal_realisasi_kembali' => $tanggalRealisasi,
                    'status' => 'kembali',
                    'denda' => $denda,
                ]);

                $buku->increment('stok');
            });

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withErrors([
                    'error' => $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.transaksi.pengembalian')
            ->with(
                'success',
                'Buku berhasil dikembalikan dan stok telah diperbarui.');
    }

    public function denda()
    {
        $data = Peminjaman::with([
            'user',
            'buku.kategori',
            'buku.rak',
        ])
        ->where('denda', '>', 0)
        ->orderBy('id', 'desc')
        ->get();

        $totalDenda = $data->sum('denda');

        $title = 'Daftar Denda';

        return view(
            'admin.transaksi.denda.index',
            compact('data', 'totalDenda', 'title'));
    }
}