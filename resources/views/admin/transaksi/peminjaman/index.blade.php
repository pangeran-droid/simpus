@extends('layouts.admin')

@section('main-content')

<h1 class="h3 mb-4 text-gray-800">
    {{ __('Transaksi Peminjaman') }}
</h1>

<!-- Pesan sukses -->
@if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Pesan error -->
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

    <!-- Tombol tambah -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.transaksi.peminjaman.create') }}"
           class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Peminjaman
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>Kode Transaksi</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Kategori</th>
                            <th>Rak</th>
                            <th class="text-center">Tanggal Pinjam</th>
                            <th class="text-center">Batas Kembali</th>
                            <th class="text-center">Realisasi Kembali</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Denda</th>
                            <th class="text-center" width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($data as $peminjaman)

                            <tr>

                                <!-- No -->
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <!-- Kode transaksi -->
                                <td>
                                    <strong>
                                        {{ $peminjaman->kode_transaksi }}
                                    </strong>
                                </td>

                                <!-- Peminjam -->
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

                                <!-- Buku -->
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

                                <!-- Kategori -->
                                <td>
                                    @if ($peminjaman->buku && $peminjaman->buku->kategori)

                                        <span class="badge badge-primary">
                                            {{ $peminjaman->buku->kategori->kategori }}
                                        </span>

                                    @else
                                        <span class="text-muted">
                                            -
                                        </span>
                                    @endif
                                </td>

                                <!-- Rak -->
                                <td>
                                    @if ($peminjaman->buku && $peminjaman->buku->rak)

                                        <span class="badge badge-secondary">
                                            {{ $peminjaman->buku->rak->nama_rak }}
                                        </span>

                                    @else
                                        <span class="text-muted">
                                            -
                                        </span>
                                    @endif
                                </td>

                                <!-- Tanggal pinjam -->
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                                </td>

                                <!-- Tanggal kembali -->
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                                </td>

                                <!-- Realisasi kembali -->
                                <td class="text-center">

                                    @if ($peminjaman->tanggal_realisasi_kembali)

                                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_realisasi_kembali)->format('d-m-Y') }}

                                    @else

                                        <span class="text-muted">
                                            Belum kembali
                                        </span>

                                    @endif

                                </td>

                                <!-- Status -->
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

                                    @else

                                        <span class="badge badge-secondary">
                                            {{ ucfirst($peminjaman->status) }}
                                        </span>

                                    @endif

                                </td>

                                <!-- Denda -->
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

                                <!-- Action -->
                                <td class="text-center">

                                    <!-- Detail -->
                                    <a href="{{ route('admin.transaksi.peminjaman.detail', $peminjaman->id) }}"
                                       class="btn btn-primary btn-sm"
                                       title="Detail">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.transaksi.peminjaman.edit', $peminjaman->id) }}"
                                       class="btn btn-info btn-sm"
                                       title="Edit">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <!-- Hapus -->
                                    <form action="{{ route('admin.transaksi.peminjaman.destroy', $peminjaman->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="12"
                                    class="text-center text-muted py-4">

                                    <i class="fas fa-exchange-alt fa-2x mb-2"></i>

                                    <br>

                                    Belum ada transaksi peminjaman.

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