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

        $title = 'Daftar Kategori';

        return view('admin.kategori.index', compact('data', 'title'));
    }

    public function create_kategori()
    {
        $title = 'Tambah Kategori';

        return view('admin.kategori.create', compact('title'));
    }

    public function store_kategori(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:100|unique:kategoris,kategori',
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

        $title = 'Edit Kategori';

        return view('admin.kategori.edit', compact('category', 'title'));
    }

    public function update_kategori(Request $request, string $id)
    {
        $category = Kategori::findOrFail($id);

        $request->validate([
            'kategori' => 'required|string|max:100|unique:kategoris,kategori,' . $category->id,
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

        if ($category->bukus()->count() > 0) {
            return redirect()->back()
                ->withErrors([
                    'error' => 'Kategori tidak bisa dihapus karena masih digunakan oleh buku!'
                ]);
        }

        $category->delete();

        return redirect()
            ->route('admin.kategori')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
