@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">
    {{ __('Edit Kategori') }}
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
                Edit Data Kategori
            </h6>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.kategori.update', $category->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <!-- Kategori -->
                <div class="form-group mb-4">

                    <label for="kategori">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        id="kategori"
                        name="kategori"
                        class="form-control"
                        value="{{ old('kategori', $category->kategori) }}"
                        placeholder="Masukkan nama kategori"
                        maxlength="100"
                        required
                    >

                    <small class="form-text text-muted">
                        Masukkan nama kategori buku.
                    </small>

                </div>

                <!-- Button -->
                <div class="mt-4">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save"></i>
                        Simpan Perubahan

                    </button>

                    <a href="{{ route('admin.kategori') }}"
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
