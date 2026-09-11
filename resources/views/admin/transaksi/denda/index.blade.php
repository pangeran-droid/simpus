@extends('layouts.admin')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800"> {{ __('Denda') }} </h1>

@if (session('success'))
<div class="alert alert-success border-left-success">
{{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger">

    <ul class="pl-4 my-2">

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </ul>

</div>

@endif
<div class="container-fluid px-0">

<!-- Total denda -->
<div class="row mb-4">

    <div class="col-md-4">

        <div class="card border-left-danger shadow h-100 py-2">

            <div class="card-body">

                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Total Denda
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">

                    Rp {{ number_format($totalDenda, 0, ',', '.') }}

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body">

                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Transaksi Terkena Denda
                </div>

                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $data->count() }}
                </div>

            </div>

        </div>

    </div>

</div>

<!-- Tabel -->
<div class="card shadow">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-primary">
            Riwayat Denda
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th class="text-center">
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

                        <th class="text-center">
                            Batas Kembali
                        </th>

                        <th class="text-center">
                            Dikembalikan
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

                                    <br>

                                    <small class="text-muted">
                                        {{ $peminjaman->user->email }}
                                    </small>

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

                            <td class="text-center">

                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}

                            </td>

                            <td class="text-center">

                                @if ($peminjaman->tanggal_realisasi_kembali)

                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_realisasi_kembali)->format('d-m-Y') }}

                                @else

                                    <span class="text-muted">
                                        Belum kembali
                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                <strong class="text-danger">

                                    Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}

                                </strong>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center text-muted py-4">

                                <i class="fas fa-check-circle fa-2x mb-2"></i>

                                <br>

                                Belum ada denda.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection