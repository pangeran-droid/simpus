<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Buku::with('kategori', 'rak')
            ->orderBy('judul', 'asc')
            ->get();

        $title = 'Daftar Buku';

        return view('admin.buku.index', compact('data', 'title'));
    }

    public function create_buku()
    {
        $categories = Kategori::orderBy('kategori', 'asc')->get();
        $raks = Rak::orderBy('nama_rak', 'asc')->get();

        $title = 'Tambah Buku';

        return view('admin.buku.create', compact('categories', 'raks', 'title'));
    }

    public function store_buku(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|string|max:20|unique:bukus,kode_buku',
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'rak_id' => 'required|exists:raks,id',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|digits:4',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $filename = null;

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');

            $filename = time() . '_' . uniqid() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/buku'),
                $filename
            );
        }

        Buku::create([
            'kode_buku' => $request->kode_buku,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'rak_id' => $request->rak_id,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'cover' => $filename,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.buku')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit_buku(string $id)
    {
        $buku = Buku::findOrFail($id);

        $categories = Kategori::orderBy('kategori', 'asc')->get();
        $raks = Rak::orderBy('nama_rak', 'asc')->get();

        $title = 'Edit Buku';

        return view('admin.buku.edit', compact('buku', 'categories', 'raks', 'title'));
    }

    public function update_buku(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'kode_buku' => ['required', 'string', 'max:20',
                Rule::unique('bukus', 'kode_buku')->ignore($buku->id),
            ],
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|digits:4',
            'stok' => 'required|integer|min:0',
            'rak_id' => 'required|exists:raks,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $filename = $buku->cover;

        if ($request->hasFile('cover')) {

            if (
                $buku->cover &&
                file_exists(public_path('uploads/buku/' . $buku->cover))
            ) {
                unlink(public_path('uploads/buku/' . $buku->cover));
            }

            $file = $request->file('cover');

            $filename = time() . '_' . uniqid() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/buku'),
                $filename
            );
        }

        $buku->update([
            'kode_buku' => $request->kode_buku,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'rak_id' => $request->rak_id,
            'cover' => $filename,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.buku')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy_buku(string $id)
    {
        $buku = Buku::findOrFail($id);

        if (
            $buku->cover &&
            file_exists(public_path('uploads/buku/' . $buku->cover))
        ) {
            unlink(public_path('uploads/buku/' . $buku->cover));
        }

        $buku->delete();

        return redirect()
            ->route('admin.buku')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
