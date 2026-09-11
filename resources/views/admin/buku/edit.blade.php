@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">
    {{ __('Edit Buku') }}
</h1>

@if ($errors->any())
    <div class="alert alert-danger border-left-danger" role="alert">
        <ul class="pl-4 my-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Data Buku
            </h6>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.buku.update', $buku->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- Kode Buku -->
                <div class="form-group mb-3">
                    <label for="kode_buku">Kode Buku</label>

                    <input
                        type="text"
                        id="kode_buku"
                        name="kode_buku"
                        class="form-control"
                        value="{{ old('kode_buku', $buku->kode_buku) }}"
                        placeholder="Contoh: BK001"
                        required
                    >

                    <small class="form-text text-muted">
                        Kode buku harus unik.
                    </small>
                </div>

                <!-- Judul -->
                <div class="form-group mb-3">
                    <label for="judul">Judul Buku</label>

                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        class="form-control"
                        value="{{ old('judul', $buku->judul) }}"
                        placeholder="Masukkan judul buku"
                        required
                    >
                </div>

                <!-- Kategori -->
                <div class="form-group mb-3">
                    <label for="kategori_id">Kategori</label>

                    <select
                        id="kategori_id"
                        name="kategori_id"
                        class="form-control"
                        required
                    >
                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('kategori_id', $buku->kategori_id) == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->kategori }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Penulis -->
                <div class="form-group mb-3">
                    <label for="penulis">Penulis</label>

                    <input
                        type="text"
                        id="penulis"
                        name="penulis"
                        class="form-control"
                        value="{{ old('penulis', $buku->penulis) }}"
                        placeholder="Masukkan nama penulis"
                        required
                    >
                </div>

                <!-- Penerbit -->
                <div class="form-group mb-3">
                    <label for="penerbit">Penerbit</label>

                    <input
                        type="text"
                        id="penerbit"
                        name="penerbit"
                        class="form-control"
                        value="{{ old('penerbit', $buku->penerbit) }}"
                        placeholder="Masukkan nama penerbit"
                        required
                    >
                </div>

                <!-- Tahun Terbit -->
                <div class="form-group mb-3">
                    <label for="tahun_terbit">Tahun Terbit</label>

                    <input
                        type="number"
                        id="tahun_terbit"
                        name="tahun_terbit"
                        class="form-control"
                        value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                        min="1900"
                        max="{{ date('Y') }}"
                        placeholder="Contoh: 2025"
                        required
                    >
                </div>

                <!-- Jumlah -->
                <div class="form-group mb-3">
                    <label for="stok">Jumlah Buku</label>

                    <input
                        type="number"
                        id="stok"
                        name="stok"
                        class="form-control"
                        value="{{ old('stok', $buku->stok) }}"
                        min="0"
                        placeholder="Masukkan stok buku"
                        required
                    >
                </div>

                <!-- Lokasi Rak -->
                <div class="form-group mb-3">
                    <label for="rak">Lokasi Rak</label>

                    <input
                        type="text"
                        id="rak"
                        name="rak"
                        class="form-control"
                        value="{{ old('rak', $buku->rak) }}"
                        placeholder="Contoh: Rak A-01"
                    >
                </div>

                <!-- Foto -->
                <div class="form-group mb-4">
                    <label for="cover">
                        Foto Sampul Buku
                    </label>

                    @if ($buku->cover)
                        <div class="mb-3">
                            <img
                                src="{{ asset('uploads/buku/' . $buku->cover) }}"
                                alt="{{ $buku->judul }}"
                                width="120"
                                height="160"
                                style="object-fit: cover;"
                                class="rounded border"
                            >
                        </div>
                    @endif

                    <input
                        type="file"
                        id="cover"
                        name="cover"
                        class="form-control-file"
                        accept=".jpg,.jpeg,.png"
                    >

                    <small class="form-text text-muted">
                        Kosongkan jika tidak ingin mengganti foto. Format: JPG, JPEG, PNG. Maksimal 2 MB.
                    </small>
                </div>

                <hr>

                <!-- Button -->
                <div class="mt-4">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.buku') }}"
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>


@endsection
