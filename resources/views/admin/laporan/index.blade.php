@extends('layouts.admin')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800"> {{ __('Laporan Transaksi') }} </h1>

{{-- Statistik --}}
<div class="row">

{{-- Total Transaksi --}}
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Total Transaksi
            </div>

            <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $totalTransaksi }}
            </div>
        </div>
    </div>
</div>

{{-- Sedang Dipinjam --}}
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                Sedang Dipinjam
            </div>

            <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $totalDipinjam }}
            </div>
        </div>
    </div>
</div>

{{-- Sudah Kembali --}}
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Sudah Kembali
            </div>

            <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $totalKembali }}
            </div>
        </div>
    </div>
</div>

{{-- Terlambat --}}
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                Terlambat
            </div>

            <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $totalTerlambat }}
            </div>
        </div>
    </div>
</div>

</div>

{{-- Total Denda --}}
<div class="row mb-4"> <div class="col-md-4"> <div class="card border-left-danger shadow"> <div class="card-body">

            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                Total Denda
            </div>

            <div class="h5 mb-0 font-weight-bold text-gray-800">
                Rp {{ number_format($totalDenda, 0, ',', '.') }}
            </div>

        </div>
    </div>
</div>

</div>

{{-- Filter --}}
<div class="card shadow mb-4">

<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
        Filter Laporan
    </h6>
</div>

<div class="card-body">

    <form method="GET" action="{{ route('admin.laporan') }}">

        <div class="row">

            {{-- Tanggal Mulai --}}
            <div class="col-md-3">
                <div class="form-group">

                    <label for="tanggal_mulai">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        name="tanggal_mulai"
                        id="tanggal_mulai"
                        class="form-control"
                        value="{{ $tanggalMulai }}"
                    >

                </div>
            </div>


            {{-- Tanggal Selesai --}}
            <div class="col-md-3">
                <div class="form-group">

                    <label for="tanggal_selesai">
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        id="tanggal_selesai"
                        class="form-control"
                        value="{{ $tanggalSelesai }}"
                    >

                </div>
            </div>


            {{-- Status --}}
            <div class="col-md-2">
                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-control"
                    >

                        <option value="">
                            Semua
                        </option>

                        <option value="dipinjam"
                            {{ $status === 'dipinjam' ? 'selected' : '' }}>
                            Dipinjam
                        </option>

                        <option value="kembali"
                            {{ $status === 'kembali' ? 'selected' : '' }}>
                            Kembali
                        </option>

                        <option value="terlambat"
                            {{ $status === 'terlambat' ? 'selected' : '' }}>
                            Terlambat
                        </option>

                    </select>

                </div>
            </div>


            {{-- Peminjam --}}
            <div class="col-md-4">
                <div class="form-group">

                    <label for="user_id">
                        Peminjam
                    </label>

                    <select
                        name="user_id"
                        id="user_id"
                        class="form-control"
                    >

                        <option value="">
                            Semua Peminjam
                        </option>

                        @foreach ($users as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ $userId == $user->id ? 'selected' : '' }}
                            >
                                {{ $user->name }}
                                @if ($user->email)
                                    - {{ $user->email }}
                                @endif
                            </option>

                        @endforeach

                    </select>

                </div>
            </div>

        </div>


        <div class="row">

            {{-- Buku --}}
            <div class="col-md-8">

                <div class="form-group">

                    <label for="buku_id">
                        Buku
                    </label>

                    <select
                        name="buku_id"
                        id="buku_id"
                        class="form-control"
                    >

                        <option value="">
                            Semua Buku
                        </option>

                        @foreach ($bukus as $buku)

                            <option
                                value="{{ $buku->id }}"
                                {{ $bukuId == $buku->id ? 'selected' : '' }}
                            >
                                {{ $buku->kode_buku }}
                                - {{ $buku->judul }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- Tombol --}}
            <div class="col-md-4">

                <div class="form-group">

                    <label>&nbsp;</label>

                    <div>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-search"></i>
                            Tampilkan
                        </button>

                        <a
                            href="{{ route('admin.laporan') }}"
                            class="btn btn-secondary"
                        >
                            <i class="fas fa-sync"></i>
                            Reset
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

</div>

{{-- Tabel laporan --}}
<div class="card shadow">

<div class="card-header py-3 d-flex justify-content-between align-items-center">

    <h6 class="m-0 font-weight-bold text-primary">
        Data Transaksi
    </h6>

    <button
        type="button"
        class="btn btn-success btn-sm"
        onclick="window.print()"
    >
        <i class="fas fa-print"></i>
        Cetak
    </button>

</div>

<div class="card-body">

    <div class="table-responsive">

        <table class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th class="text-center" width="50">
                        No
                    </th>

                    <th>
                        Kode Transaksi
                    </th>

                    <th>
                        Peminjam
                    </th>

                    <th>
                        Buku
                    </th>

                    <th>
                        Kategori
                    </th>

                    <th class="text-center">
                        Tanggal Pinjam
                    </th>

                    <th class="text-center">
                        Batas Kembali
                    </th>

                    <th class="text-center">
                        Realisasi
                    </th>

                    <th class="text-center">
                        Status
                    </th>

                    <th class="text-center">
                        Denda
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse ($data as $peminjaman)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <strong>
                                {{ $peminjaman->kode_transaksi }}
                            </strong>
                        </td>

                        <td>

                            @if ($peminjaman->user)

                                {{ $peminjaman->user->name }}

                                @if ($peminjaman->user->email)
                                    <br>
                                    <small class="text-muted">
                                        {{ $peminjaman->user->email }}
                                    </small>
                                @endif

                            @else

                                -

                            @endif

                        </td>

                        <td>

                            @if ($peminjaman->buku)

                                <strong>
                                    {{ $peminjaman->buku->judul }}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    {{ $peminjaman->buku->kode_buku }}
                                </small>

                            @else

                                -

                            @endif

                        </td>

                        <td>

                            @if (
                                $peminjaman->buku &&
                                $peminjaman->buku->kategori
                            )

                                <span class="badge badge-primary">
                                    {{ $peminjaman->buku->kategori->kategori }}
                                </span>

                            @else

                                -

                            @endif

                        </td>

                        <td class="text-center">

                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}

                        </td>

                        <td class="text-center">

                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}

                        </td>

                        <td class="text-center">

                            @if ($peminjaman->tanggal_realisasi_kembali)

                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_realisasi_kembali)->format('d-m-Y') }}

                            @else

                                <span class="text-muted">
                                    -
                                </span>

                            @endif

                        </td>

                        <td class="text-center">

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

                        </td>

                        <td class="text-center">

                            @if ($peminjaman->denda > 0)

                                <span class="text-danger font-weight-bold">
                                    Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                </span>

                            @else

                                <span class="text-muted">
                                    Rp 0
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="10"
                            class="text-center text-muted py-4"
                        >

                            <i class="fas fa-file-alt fa-2x mb-2"></i>

                            <br>

                            Tidak ada data transaksi.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

@endsection

@push('styles')
<style> @media print { body { background: white !important; } #accordionSidebar, .navbar, .sidebar, .btn, form, .alert { display: none !important; } .card { border: none !important; box-shadow: none !important; } .card-header { border: none !important; } table { font-size: 11px; } } </style>

@endpush