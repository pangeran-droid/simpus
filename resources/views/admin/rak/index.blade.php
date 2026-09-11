@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Daftar Rak') }}</h1>

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
            <a href="{{ route('admin.rak.create') }}"
            class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Rak
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
                                <th>Nama Rak</th>
                                <th>Lokasi / Keterangan</th>
                                <th class="text-center" width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $rak)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $rak->nama_rak }}
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $rak->lokasi }}
                                        </strong>
                                    </td>

                                    <!-- Action -->
                                    <td class="text-center">

                                        <!-- Edit -->
                                        <a href="{{ route('admin.rak.edit', $rak->id) }}"
                                        class="btn btn-info btn-sm"
                                        title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </a>


                                        <!-- Delete -->
                                        <form
                                            action="{{ route('admin.rak.destroy', $rak->id) }}"
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

                                        Belum ada rak.

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
