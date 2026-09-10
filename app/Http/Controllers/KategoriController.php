<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Kategori::orderBy('kategori', 'asc')->get();

        $title = 'Daftar Category';

        return view('admin.kategori.index', compact('data', 'title'));
    }

    public function create_kategori()
    {
        return view('admin.kategori.create');
    }

    public function store_kategori(Request $request)
    {
        $request->validate([
            'kategori' => [
                'required',
                'string',
                'max:100',
                'unique:kategoris,kategori',
            ],
        ], [
            'kategori.required' => 'Nama kategori wajib diisi.',
            'kategori.string' => 'Nama kategori harus berupa teks.',
            'kategori.max' => 'Nama kategori maksimal 100 karakter.',
            'kategori.unique' => 'Kategori tersebut sudah tersedia.',
        ]);

        Kategori::create([
            'kategori' => $request->kategori,
        ]);

        return redirect()
            ->route('admin.kategori')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit_kategori(string $id)
    {
        $category = Kategori::findOrFail($id);

        return view('admin.kategori.edit', compact('category'));
    }

    public function update_kategori(Request $request, string $id)
    {
        $category = Kategori::findOrFail($id);

        $request->validate([
            'kategori' => [
                'required',
                'string',
                'max:100',
                'unique:kategoris,kategori,' . $category->id,
            ],
        ], [
            'kategori.required' => 'Nama kategori wajib diisi.',
            'kategori.string' => 'Nama kategori harus berupa teks.',
            'kategori.max' => 'Nama kategori maksimal 100 karakter.',
            'kategori.unique' => 'Kategori tersebut sudah tersedia.',
        ]);

        $category->update([
            'kategori' => $request->kategori,
        ]);

        return redirect()
            ->route('admin.kategori')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy_kategori(string $id)
    {
        $category = Kategori::findOrFail($id);

        $category->delete();

        return redirect()
            ->route('admin.kategori')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
