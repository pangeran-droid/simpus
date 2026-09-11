@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Daftar Buku') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.buku.create') }}"
            class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Buku
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width="60">No</th>
                                <th class="text-center" width="100">Cover</th>
                                <th>Kode Buku</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Rak</th>
                                <th class="text-center" width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $buku)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-center">

                                        @if($buku->cover)
                                            <img
                                                src="{{ asset('uploads/buku/' . $buku->cover) }}"
                                                alt="{{ $buku->judul }}"
                                                style="
                                                    width: 60px;
                                                    height: 80px;
                                                    object-fit: cover;
                                                "
                                                class="rounded"
                                            >

                                        @else
                                            <div class="text-muted">
                                                <i class="fas fa-book fa-2x"></i>
                                                <br>
                                                <small>
                                                    Tidak ada cover
                                                </small>
                                            </div>
                                        @endif

                                    </td>
                                    <td>
                                        <strong>
                                            {{ $buku->kode_buku }}
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $buku->judul }}
                                        </strong>
                                    </td>
                                    <td>

                                        @if($buku->kategori)
                                            <span class="badge badge-primary">
                                                {{ $buku->kategori->kategori }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                -
                                            </span>
                                        @endif

                                    </td>
                                    <td>
                                        {{ $buku->penulis }}
                                    </td>
                                    <td>
                                        {{ $buku->penerbit }}
                                    </td>
                                    <td class="text-center">
                                        {{ $buku->tahun_terbit }}
                                    </td>
                                    <td class="text-center">

                                        @if($buku->stok > 0)
                                            <span class="badge badge-success">
                                                {{ $buku->stok }}
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                Habis
                                            </span>
                                        @endif

                                    </td>
                                    <td class="text-center">

                                        @if($buku->rak)
                                            <span class="badge badge-secondary">
                                                {{ $buku->rak->nama_rak }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                -
                                            </span>
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        <!-- Edit -->
                                        <a href="{{ route('admin.buku.edit', $buku->id) }}"
                                        class="btn btn-info btn-sm"
                                        title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Delete -->
                                        <form
                                            action="{{ route('admin.buku.destroy', $buku->id) }}"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Delete"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td
                                        colspan="11"
                                        class="text-center text-muted py-4"
                                    >
                                        <i class="fas fa-book fa-2x mb-2"></i>
                                        <br>
                                        Belum ada buku.
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
