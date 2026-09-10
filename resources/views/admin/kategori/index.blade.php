@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Daftar Kategori') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

<div class="container-fluid px-0">

    <!-- Tombol Tambah -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.kategori.create') }}"
           class="btn btn-primary">

            <i class="fas fa-plus"></i>
            Tambah Kategori

        </a>
    </div>

    <!-- Card -->
    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th class="text-center" width="80">
                                No
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th class="text-center" width="150">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($data as $category)

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $category->kategori }}
                                    </strong>
                                </td>

                                <td class="text-center">

                                    <!-- Edit -->
                                    <a href="{{ route('admin.kategori.edit', $category->id) }}"
                                       class="btn btn-info btn-sm"
                                       title="Edit">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('destroy_kategori', $category->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Delete">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3"
                                    class="text-center text-muted py-4">

                                    <i class="fas fa-tags fa-2x mb-2"></i>

                                    <br>

                                    Belum ada kategori.

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
