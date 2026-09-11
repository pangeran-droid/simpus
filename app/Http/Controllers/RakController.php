<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Rak::orderBy('nama_rak', 'asc')->get();
        $title = 'Data Rak Buku';
        return view('admin.rak.index', compact('data', 'title'));
    }

    public function create_rak()
    {
        $title = 'Tambah Rak Buku';
        return view('admin.rak.create', compact('title'));
    }

    public function store_rak(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:50|unique:raks,nama_rak',
            'lokasi' => 'nullable|string|max:100',
        ], [
            'nama_rak.required' => 'Nama rak wajib diisi.',
            'nama_rak.unique' => 'Nama rak tersebut sudah ada.',
        ]);

        Rak::create($request->all());

        return redirect()->route('admin.rak')->with('success', 'Rak buku berhasil ditambahkan!');
    }

    public function edit_rak(string $id)
    {
        $rak = Rak::findOrFail($id);
        $title = 'Edit Rak Buku';
        return view('admin.rak.edit', compact('rak', 'title'));
    }

    public function update_rak(Request $request, string $id)
    {
        $rak = Rak::findOrFail($id);

        $request->validate([
            'nama_rak' => 'required|string|max:50|unique:raks,nama_rak,' . $rak->id,
            'lokasi' => 'nullable|string|max:100',
        ]);

        $rak->update($request->all());

        return redirect()->route('admin.rak')->with('success', 'Rak buku berhasil diperbarui!');
    }

    public function destroy_rak(string $id)
    {
        $rak = Rak::findOrFail($id);

        if ($rak->bukus()->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Rak tidak bisa dihapus karena masih berisi buku!']);
        }

        $rak->delete();
        return redirect()->back()->with('success', 'Rak buku berhasil dihapus!');
    }
}
