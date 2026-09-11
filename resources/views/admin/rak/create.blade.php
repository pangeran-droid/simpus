@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">
    {{ __('Tambah Rak') }}
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
                Tambah Data Rak
            </h6>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.rak.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <!-- Kode Buku -->
                <div class="form-group mb-3">
                    <label for="nama_rak">Nama Rak</label>

                    <input
                        type="text"
                        id="nama_rak"
                        name="nama_rak"
                        class="form-control"
                        value="{{ old('nama_rak') }}"
                        placeholder="Contoh: BK001"
                        required
                    >

                    <small class="form-text text-muted">
                        Kode buku harus unik.
                    </small>
                </div>

                <!-- Lokasi Rak -->
                <div class="form-group mb-3">
                    <label for="rak">Lokasi Rak</label>

                    <input
                        type="text"
                        id="lokasi"
                        name="lokasi"
                        class="form-control"
                        value="{{ old('lokasi') }}"
                        placeholder="Contoh: Rak A-01"
                    >
                </div>

                <hr>

                <!-- Button -->
                <div class="mt-4">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Buku
                    </button>

                    <a href="{{ route('admin.rak') }}"
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
