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

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Edit Data User
                </h6>
            </div>

            <div class="card-body">

            <form action="{{ route('update_user', $user->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name) }}"
                        placeholder="Masukkan nama"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $user->email) }}"
                        placeholder="Masukkan email"
                        required
                    >
                </div>

                <!-- Nomor Telepon -->
                <div class="form-group mb-3">
                    <label for="phone">No. Telepon</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="Masukkan nomor telepon"
                    >
                </div>

                <!-- Alamat -->
                <div class="form-group mb-3">
                    <label for="address">Alamat</label>
                    <textarea
                        id="address"
                        name="address"
                        class="form-control"
                        rows="3"
                        placeholder="Masukkan alamat"
                    >{{ old('address', $user->address) }}</textarea>
                </div>

                <!-- User Type -->
                <div class="form-group mb-3">
                    <label for="usertype">Role</label>

                    <select
                        id="usertype"
                        name="usertype"
                        class="form-control"
                        required
                    >
                        <option value="user"
                            {{ old('usertype', $user->usertype) == 'user' ? 'selected' : '' }}>
                            User
                        </option>

                        <option value="admin"
                            {{ old('usertype', $user->usertype) == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                    </select>
                </div>

                <hr>

                <h6 class="font-weight-bold text-primary mb-3">
                    Ubah Password
                </h6>

                <p class="text-muted small">
                    Kosongkan password jika tidak ingin mengubah password.
                </p>

                <!-- Password -->
                <div class="form-group mb-3">
                    <label for="password">Password Baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password baru"
                    >
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group mb-4">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password baru"
                    >
                </div>

                <!-- Foto -->
                <div class="form-group mb-3">
                    <label for="foto_profile">Foto Profile</label>

                    @if ($user->foto_profile)
                        <div class="mb-2">
                            <img
                                src="{{ asset('uploads/profile/' . $user->foto_profile) }}"
                                width="100"
                                height="100"
                                style="object-fit: cover;"
                                class="rounded"
                                alt="Foto Profile"
                            >
                        </div>
                    @endif

                    <input
                        type="file"
                        id="foto_profile"
                        name="foto_profile"
                        class="form-control-file"
                        accept=".jpg,.jpeg,.png"
                    >
                </div>

                <!-- Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>

            </form>

            </div>
        </div>

    </div>

@endsection
