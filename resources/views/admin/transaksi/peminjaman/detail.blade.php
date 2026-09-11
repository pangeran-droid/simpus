@extends('layouts.admin')

@section('main-content')

<h1 class="h3 mb-4 text-gray-800"> {{ __('Detail Transaksi Peminjaman') }} </h1> <div class="card shadow">
<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
        Detail Peminjaman
    </h6>
</div>

<div class="card-body">

    <div class="row">

        <!-- Kode Transaksi -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">
                Kode Transaksi
            </label>

            <div>
                <span class="badge badge-primary">
                    {{ $peminjaman->kode_transaksi }}
                </span>
            </div>
        </div>

        <!-- Status -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">
                Status
            </label>

            <div>

                @if ($peminjaman->status === 'dipinjam')

                    <span class="badge badge-warning">
                        Dipinjam
                    </span>

                @elseif ($peminjaman->status === 'kembali')

                    <span class="badge badge-success">
                        Kembali
                    </span>

                @elseif ($peminjaman->status === 'terlambat')

                    <span class="badge badge-danger">
                        Terlambat
                    </span>

                @endif

            </div>
        </div>

    </div>

    <hr>

    <!-- Peminjam -->
    <h6 class="font-weight-bold text-primary mb-3">
        Data Peminjam
    </h6>

    <div class="row">

        <div class="col-md-6 mb-3">

            <label class="font-weight-bold">
                Nama
            </label>

            <div>
                {{ $peminjaman->user->name ?? '-' }}
            </div>

        </div>

        <div class="col-md-6 mb-3">

            <label class="font-weight-bold">
                Email
            </label>

            <div>
                {{ $peminjaman->user->email ?? '-' }}
            </div>

        </div>

    </div>

    <hr>

    <!-- Data Buku -->
    <h6 class="font-weight-bold text-primary mb-3">
        Data Buku
    </h6>

    <div class="row">

        <div class="col-md-6 mb-3">

            <label class="font-weight-bold">
                Kode Buku
            </label>

            <div>
                {{ $peminjaman->buku->kode_buku ?? '-' }}
            </div>

        </div>

        <div class="col-md-6 mb-3">

            <label class="font-weight-bold">
                Judul Buku
            </label>

            <div>
                {{ $peminjaman->buku->judul ?? '-' }}
            </div>

        </div>

        <div class="col-md-6 mb-3">

            <label class="font-weight-bold">
                Kategori
            </label>

            <div>

                @if ($peminjaman->buku && $peminjaman->buku->kategori)

                    <span class="badge badge-primary">
                        {{ $peminjaman->buku->kategori->kategori }}
                    </span>

                @else
                    -
                @endif

            </div>

        </div>

        <div class="col-md-6 mb-3">

            <label class="font-weight-bold">
                Rak
            </label>

            <div>

                @if ($peminjaman->buku && $peminjaman->buku->rak)

                    <span class="badge badge-secondary">
                        {{ $peminjaman->buku->rak->nama_rak }}
                    </span>

                @else
                    -
                @endif

            </div>

        </div>

    </div>

    <hr>

    <!-- Data Peminjaman -->
    <h6 class="font-weight-bold text-primary mb-3">
        Data Peminjaman
    </h6>

    <div class="row">

        <div class="col-md-4 mb-3">

            <label class="font-weight-bold">
                Tanggal Pinjam
            </label>

            <div>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
            </div>

        </div>

        <div class="col-md-4 mb-3">

            <label class="font-weight-bold">
                Batas Kembali
            </label>

            <div>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
            </div>

        </div>

        <div class="col-md-4 mb-3">

            <label class="font-weight-bold">
                Realisasi Kembali
            </label>

            <div>

                @if ($peminjaman->tanggal_realisasi_kembali)

                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_realisasi_kembali)->format('d-m-Y') }}

                @else

                    <span class="text-muted">
                        Belum kembali
                    </span>

                @endif

            </div>

        </div>

    </div>

    <hr>

    <!-- Denda -->
    <div class="row">

        <div class="col-md-6">

            <label class="font-weight-bold">
                Denda
            </label>

            <div>

                @if ($peminjaman->denda > 0)

                    <span class="text-danger font-weight-bold">
                        Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                    </span>

                @else

                    <span class="text-muted">
                        Rp 0
                    </span>

                @endif

            </div>

        </div>

    </div>

    <hr>

    <!-- Tombol -->
    <div class="d-flex justify-content-between">

        <a href="{{ route('admin.transaksi.peminjaman') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

        @if ($peminjaman->status !== 'kembali')

            <a href="{{ route('admin.transaksi.peminjaman.edit', $peminjaman->id) }}"
               class="btn btn-info">

                <i class="fas fa-edit"></i>
                Edit

            </a>

        @endif

    </div>

</div>

</div>

@endsection