@extends('layouts.admin')

@section('main-content')

    <h1 class="h3 mb-4 text-gray-800">
        {{ __('Tambah User') }}
    </h1>

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
                    Tambah Data User
                </h6>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.users.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <!-- Nama -->
                    <div class="form-group mb-3">
                        <label for="name">Nama</label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
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
                            value="{{ old('email') }}"
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
                            value="{{ old('phone') }}"
                            placeholder="Masukkan nomor telepon"
                            required
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
                            required
                        >{{ old('address') }}</textarea>
                    </div>

                    <!-- Role -->
                    <div class="form-group mb-3">
                        <label for="usertype">Role</label>

                        <select
                            id="usertype"
                            name="usertype"
                            class="form-control"
                            required
                        >
                            <option value="">-- Pilih Role --</option>

                            <option value="user"
                                {{ old('usertype') == 'user' ? 'selected' : '' }}>
                                User
                            </option>

                            <option value="admin"
                                {{ old('usertype') == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>
                    </div>

                    <hr>

                    <h6 class="font-weight-bold text-primary mb-3">
                        Password
                    </h6>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">Password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group mb-4">
                        <label for="password_confirmation">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password"
                            required
                        >
                    </div>

                    <!-- Foto -->
                    <div class="form-group mb-4">
                        <label for="foto_profile">
                            Foto Profile
                        </label>

                        <input
                            type="file"
                            id="foto_profile"
                            name="foto_profile"
                            class="form-control-file"
                            accept=".jpg,.jpeg,.png"
                        >

                        <small class="form-text text-muted">
                            Format: JPG, JPEG, PNG. Maksimal 1 MB.
                        </small>
                    </div>

                    <!-- Button -->
                    <div class="mt-4">

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan User
                        </button>

                        <a href="{{ route('admin.users') }}"
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
