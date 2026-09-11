@extends('layouts.admin')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800"> {{ __('Pengembalian Buku') }} </h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show">
{{ session('success') }}

    <button type="button"
            class="close"
            data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>

@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger">
<strong>Terjadi kesalahan:</strong>

    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

@endif
<div class="container-fluid px-0">

<div class="card shadow">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Buku yang Sedang Dipinjam
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th class="text-center" width="50">No</th>
                        <th>Kode Transaksi</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th class="text-center">Tanggal Pinjam</th>
                        <th class="text-center">Batas Kembali</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Denda</th>
                        <th class="text-center" width="150">Action</th>
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

                                    <strong>
                                        {{ $peminjaman->user->name }}
                                    </strong>

                                    @if ($peminjaman->user->email)
                                        <br>
                                        <small class="text-muted">
                                            {{ $peminjaman->user->email }}
                                        </small>
                                    @endif

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

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

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif
                            </td>

                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                            </td>

                            <td class="text-center">

                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}

                                @if ($peminjaman->status === 'terlambat')
                                    <br>
                                    <small class="text-danger font-weight-bold">
                                        Terlambat
                                    </small>
                                @endif

                            </td>

                            <td class="text-center">

                                @if ($peminjaman->status === 'dipinjam')

                                    <span class="badge badge-warning">
                                        Dipinjam
                                    </span>

                                @elseif ($peminjaman->status === 'terlambat')

                                    <span class="badge badge-danger">
                                        Terlambat
                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                @if ($peminjaman->status === 'terlambat')

                                    <span class="text-danger">
                                        Akan dihitung saat dikembalikan
                                    </span>

                                @else

                                    <span class="text-muted">
                                        Rp 0
                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                <form
                                    action="{{ route('admin.transaksi.pengembalian.proses', $peminjaman->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah buku ini benar-benar sudah dikembalikan?');"
                                >

                                    @csrf

                                    <button type="submit"
                                            class="btn btn-success btn-sm">

                                        <i class="fas fa-undo"></i>
                                        Kembalikan

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center text-muted py-4">

                                <i class="fas fa-check-circle fa-2x mb-2"></i>

                                <br>

                                Tidak ada buku yang sedang dipinjam.

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