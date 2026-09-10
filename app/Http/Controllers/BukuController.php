<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
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
        $data = Buku::with('kategori')
            ->orderBy('judul', 'asc')
            ->get();

        $title = 'Daftar Buku';

        return view('admin.buku.index', compact('data', 'title'));
    }

    public function create_buku()
    {
        $categories = Kategori::orderBy('kategori', 'asc')->get();

        return view('admin.buku.create', compact('categories'));
    }

    public function store_buku(Request $request)
    {
        $request->validate([
            'kode_buku' => [
                'required',
                'string',
                'max:20',
                'unique:bukus,kode_buku',
            ],

            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'kategori_id' => [
                'required',
                'exists:kategoris,id',
            ],

            'penulis' => [
                'required',
                'string',
                'max:100',
            ],

            'penerbit' => [
                'required',
                'string',
                'max:100',
            ],

            'tahun_terbit' => [
                'required',
                'integer',
                'digits:4',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:20',
                'unique:bukus,isbn',
            ],

            'stok' => [
                'required',
                'integer',
                'min:0',
            ],

            'rak' => [
                'nullable',
                'string',
                'max:50',
            ],

            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ], [
            'kode_buku.required' => 'Kode buku wajib diisi.',
            'kode_buku.unique' => 'Kode buku tersebut sudah digunakan.',
            'judul.required' => 'Judul buku wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'penulis.required' => 'Nama penulis wajib diisi.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits' => 'Tahun terbit harus 4 digit.',
            'isbn.unique' => 'ISBN tersebut sudah digunakan.',
            'stok.required' => 'Stok buku wajib diisi.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'cover.image' => 'File cover harus berupa gambar.',
            'cover.mimes' => 'Cover harus berformat JPG, JPEG, atau PNG.',
            'cover.max' => 'Ukuran cover maksimal 2 MB.',
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
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'stok' => $request->stok,
            'rak' => $request->rak,
            'cover' => $filename,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.buku')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit_buku(string $id)
    {
        $Buku = Buku::findOrFail($id);

        $categories = Kategori::orderBy('kategori', 'asc')->get();

        return view('admin.buku.edit', compact('Buku', 'categories'));
    }

    public function update_buku(Request $request, string $id)
    {
        $Buku = Buku::findOrFail($id);

        $request->validate([
            'kode_buku' => [
                'required',
                'string',
                'max:20',
                Rule::unique('bukus', 'kode_buku')->ignore($Buku->id),
            ],

            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'kategori_id' => [
                'required',
                'exists:kategoris,id',
            ],

            'penulis' => [
                'required',
                'string',
                'max:100',
            ],

            'penerbit' => [
                'required',
                'string',
                'max:100',
            ],

            'tahun_terbit' => [
                'required',
                'integer',
                'digits:4',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('bukus', 'isbn')->ignore($Buku->id),
            ],

            'stok' => [
                'required',
                'integer',
                'min:0',
            ],

            'rak' => [
                'nullable',
                'string',
                'max:50',
            ],

            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);

        $filename = $Buku->cover;

        if ($request->hasFile('cover')) {

            if (
                $Buku->cover &&
                file_exists(public_path('uploads/buku/' . $Buku->cover))
            ) {
                unlink(public_path('uploads/buku/' . $Buku->cover));
            }

            $file = $request->file('cover');

            $filename = time() . '_' . uniqid() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/buku'),
                $filename
            );
        }

        $Buku->update([
            'kode_buku' => $request->kode_buku,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'stok' => $request->stok,
            'rak' => $request->rak,
            'cover' => $filename,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.buku')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy_buku(string $id)
    {
        $Buku = Buku::findOrFail($id);

        if (
            $Buku->cover &&
            file_exists(public_path('uploads/buku/' . $Buku->cover))
        ) {
            unlink(public_path('uploads/buku/' . $Buku->cover));
        }

        $Buku->delete();

        return redirect()
            ->route('admin.buku')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
