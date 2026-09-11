@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Daftar User') }}</h1>

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
    <!-- Komponen Filter Role dan Tombol Tambah -->
    <div class="card shadow mb-4">
        <div class="card-body py-3 d-flex flex-wrap align-items-center justify-content-between">

            <!-- Tab Filter untuk Mengubah Role di URL -->
            <div class="nav nav-pills mb-2 mb-md-0">
                <a class="nav-link {{ !$selectedRole || $selectedRole == 'all' ? 'active' : '' }}"
                   href="{{ route('admin.users', ['role' => 'all', 'search' => request('search')]) }}">
                    <i class="fas fa-users"></i> Semua User
                </a>

                <a class="nav-link {{ $selectedRole == 'admin' ? 'active text-white bg-primary' : '' }}"
                   href="{{ route('admin.users', ['role' => 'admin', 'search' => request('search')]) }}">
                    <i class="fas fa-user-shield"></i> Admin
                </a>

                <a class="nav-link {{ $selectedRole == 'user' ? 'active text-white bg-success' : '' }}"
                   href="{{ route('admin.users', ['role' => 'user', 'search' => request('search')]) }}">
                    <i class="fas fa-user"></i> Regular User
                </a>
            </div>

            <!-- Tambah User -->
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus"></i> Tambah User
            </a>

        </div>
    </div>


        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Foto Profile</th>
                                <th class="text-center" width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $user)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>{{ $user->address ?? '-' }}</td>

                                    <td class="text-center">
                                        @if($user->usertype == 'admin')
                                            <span class="badge badge-primary">
                                                Admin
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                {{ ucfirst($user->usertype) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($user->foto_profile)
                                            <img src="{{ asset('uploads/profile/' . $user->foto_profile) }}" alt="{{ $user->name }}" style="width: 80px; height: 60px;">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($user->usertype != 'admin')

                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-info btn-sm"
                                            title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.user.destroy', $user->id) }}"
                                                method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-lock"></i> Admin
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-users fa-2x mb-2"></i>
                                        <br>
                                        Belum ada user.
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
