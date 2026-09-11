@extends('layouts.admin')

@section('main-content')

<h1 class="h3 mb-4 text-gray-800"> {{ __('Edit Transaksi Peminjaman') }} </h1>

<!-- Error -->
@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">

    <strong>Terjadi kesalahan:</strong>

    <ul class="pl-4 my-2">

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </ul>

</div>


@endif

<div class="card shadow">
<div class="card-header py-3">

    <h6 class="m-0 font-weight-bold text-primary">
        Form Edit Peminjaman
    </h6>

</div>

<div class="card-body">

    <form
        action="{{ route('admin.transaksi.peminjaman.update', $peminjaman->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <!-- Kode Transaksi -->
        <div class="form-group">

            <label>
                Kode Transaksi
            </label>

            <input
                type="text"
                class="form-control"
                value="{{ $peminjaman->kode_transaksi }}"
                readonly
            >

            <small class="form-text text-muted">
                Kode transaksi tidak dapat diubah.
            </small>

        </div>


        <div class="row">

            <!-- Peminjam -->
            <div class="col-md-6">

                <div class="form-group">

                    <label for="user_id">
                        Peminjam
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="user_id"
                        id="user_id"
                        class="form-control @error('user_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Pilih Peminjam --
                        </option>

                        @foreach ($users as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ old('user_id', $peminjaman->user_id) == $user->id ? 'selected' : '' }}
                            >

                                {{ $user->name }}

                                @if ($user->email)
                                    - {{ $user->email }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                    @error('user_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            <!-- Buku -->
            <div class="col-md-6">

                <div class="form-group">

                    <label for="buku_id">
                        Buku
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="buku_id"
                        id="buku_id"
                        class="form-control @error('buku_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Pilih Buku --
                        </option>

                        @foreach ($bukus as $buku)

                            @php
                                $bukuDipilih = old(
                                    'buku_id',
                                    $peminjaman->buku_id
                                );

                                $stokTersedia = $buku->stok > 0;

                                $bukuSaatIni =
                                    $buku->id == $peminjaman->buku_id;
                            @endphp

                            <option
                                value="{{ $buku->id }}"
                                {{ $bukuDipilih == $buku->id ? 'selected' : '' }}

                                @if (!$stokTersedia && !$bukuSaatIni)
                                    disabled
                                @endif
                            >

                                {{ $buku->kode_buku }}
                                -
                                {{ $buku->judul }}
                                (Stok: {{ $buku->stok }})

                                @if (!$stokTersedia && !$bukuSaatIni)
                                    - HABIS
                                @endif

                            </option>

                        @endforeach

                    </select>

                    @error('buku_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                    <small class="form-text text-muted">
                        Buku dengan stok 0 tidak dapat dipilih,
                        kecuali buku yang sedang digunakan transaksi ini.
                    </small>

                </div>

            </div>

        </div>


        <div class="row">

            <!-- Tanggal Pinjam -->
            <div class="col-md-6">

                <div class="form-group">

                    <label for="tanggal_pinjam">
                        Tanggal Pinjam
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal_pinjam"
                        id="tanggal_pinjam"
                        class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                        value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}"
                        required
                    >

                    @error('tanggal_pinjam')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            <!-- Tanggal Kembali -->
            <div class="col-md-6">

                <div class="form-group">

                    <label for="tanggal_kembali">
                        Batas Tanggal Kembali
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal_kembali"
                        id="tanggal_kembali"
                        class="form-control @error('tanggal_kembali') is-invalid @enderror"
                        value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}"
                        required
                    >

                    @error('tanggal_kembali')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>


        <!-- Status -->
        <div class="alert alert-warning">

            <div class="row">

                <div class="col-md-6">

                    <strong>Status:</strong>

                    @if ($peminjaman->status === 'dipinjam')

                        <span class="badge badge-warning">
                            Dipinjam
                        </span>

                    @elseif ($peminjaman->status === 'terlambat')

                        <span class="badge badge-danger">
                            Terlambat
                        </span>

                    @elseif ($peminjaman->status === 'kembali')

                        <span class="badge badge-success">
                            Kembali
                        </span>

                    @endif

                </div>

                <div class="col-md-6">

                    <strong>Denda:</strong>

                    Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}

                </div>

            </div>

        </div>


        <!-- Informasi -->
        <div class="alert alert-info">

            <i class="fas fa-info-circle"></i>

            <strong>Perhatian:</strong>

            <ul class="mb-0 mt-2 pl-4">

                <li>
                    Kode transaksi tidak dapat diubah.
                </li>

                <li>
                    Status transaksi tidak diubah dari halaman ini.
                </li>

                <li>
                    Jika buku diganti, stok buku lama akan dikembalikan
                    dan stok buku baru akan dikurangi.
                </li>

                <li>
                    Transaksi yang sudah dikembalikan tidak dapat diedit.
                </li>

            </ul>

        </div>


        <!-- Tombol -->
        <div class="d-flex justify-content-between">

            <a
                href="{{ route('admin.transaksi.peminjaman') }}"
                class="btn btn-secondary"
            >

                <i class="fas fa-arrow-left"></i>

                Kembali

            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="fas fa-save"></i>

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

</div>

@endsection