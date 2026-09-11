@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1 class="h3 mb-1 text-gray-800">
            Detail Kartu Anggota
        </h1>

        <p class="mb-0 text-muted">
            Informasi lengkap kartu anggota perpustakaan
        </p>
    </div>

    <div>

        <a href="{{ route('admin.users.kartu') }}"
           class="btn btn-secondary mr-2">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

        <button onclick="window.print()"
                class="btn btn-primary">

            <i class="fas fa-print"></i>
            Cetak Kartu

        </button>

    </div>

</div>


<!-- Kartu -->
<div class="d-flex justify-content-center">

    <div class="member-card">

        <!-- Header -->
        <div class="member-card-header">

            <div class="logo">

                <i class="fas fa-book"></i>

            </div>

            <div>

                <div class="library-name">
                    PERPUSTAKAAN
                </div>

                <div class="library-subtitle">
                    KARTU ANGGOTA
                </div>

            </div>

        </div>


        <!-- Body -->
        <div class="member-card-body">

            <!-- Foto -->
            <div class="member-photo-wrapper">

                @if ($user->foto_profile)

                    <img
                        src="{{ asset('uploads/profile/' . $user->foto_profile) }}"
                        alt="{{ $user->name }}"
                        class="member-photo"
                    >

                @else

                    <div class="member-photo-placeholder">

                        <i class="fas fa-user"></i>

                    </div>

                @endif

            </div>


            <!-- Informasi -->
            <div class="member-information">

                <div class="member-label">
                    Nama Anggota
                </div>

                <div class="member-name">
                    {{ $user->name }}
                </div>


                <div class="member-label">
                    Kode Anggota
                </div>

                <div class="member-code">
                    {{ $user->user_code ?? '-' }}
                </div>


                <div class="member-row">

                    <span class="member-label">
                        Telepon
                    </span>

                    <span>
                        {{ $user->phone ?? '-' }}
                    </span>

                </div>


                <div class="member-row">

                    <span class="member-label">
                        Email
                    </span>

                    <span class="email-text">
                        {{ $user->email }}
                    </span>

                </div>

            </div>

        </div>


        <!-- Footer -->
        <div class="member-card-footer">

            <span>
                Kartu Anggota Perpustakaan
            </span>

            <strong>
                {{ $user->user_code ?? '-' }}
            </strong>

        </div>

    </div>

</div>


<!-- Informasi tambahan -->
<div class="row justify-content-center mt-4">

    <div class="col-md-8">

        <div class="card shadow">

            <div class="card-header">

                <h6 class="m-0 font-weight-bold text-primary">

                    <i class="fas fa-info-circle"></i>
                    Informasi Anggota

                </h6>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <small class="text-muted">
                            Nama
                        </small>

                        <div class="font-weight-bold">
                            {{ $user->name }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted">
                            Kode Anggota
                        </small>

                        <div class="font-weight-bold text-primary">
                            {{ $user->user_code ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted">
                            Email
                        </small>

                        <div>
                            {{ $user->email }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted">
                            Nomor Telepon
                        </small>

                        <div>
                            {{ $user->phone ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-12">

                        <small class="text-muted">
                            Alamat
                        </small>

                        <div>
                            {{ $user->address ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div> <style> .member-card { width: 600px; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); border: 1px solid #e3e6f0; } .member-card-header { background: linear-gradient( 135deg, #4e73df, #224abe ); color: white; padding: 24px 30px; display: flex; align-items: center; } .member-card-header .logo { width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; font-size: 26px; margin-right: 16px; } .library-name { font-size: 21px; font-weight: 700; letter-spacing: 1px; } .library-subtitle { font-size: 13px; opacity: 0.9; margin-top: 3px; } .member-card-body { padding: 30px; display: flex; align-items: center; } .member-photo-wrapper { margin-right: 30px; } .member-photo { width: 145px; height: 175px; object-fit: cover; border-radius: 10px; border: 4px solid #e3e6f0; } .member-photo-placeholder { width: 145px; height: 175px; background: #eaecf4; color: #858796; border-radius: 10px; border: 4px solid #e3e6f0; display: flex; align-items: center; justify-content: center; font-size: 55px; } .member-information { flex: 1; } .member-label { color: #858796; font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 3px; } .member-name { font-size: 22px; font-weight: 700; color: #2e2f32; margin-bottom: 14px; } .member-code { display: inline-block; background: #eef2ff; color: #4e73df; font-weight: 700; padding: 6px 12px; border-radius: 6px; margin-bottom: 15px; } .member-row { margin-top: 9px; font-size: 13px; color: #555; } .member-row .member-label { margin-bottom: 1px; } .email-text { word-break: break-word; } .member-card-footer { background: #f8f9fc; border-top: 1px solid #e3e6f0; padding: 14px 30px; display: flex; justify-content: space-between; align-items: center; color: #858796; font-size: 12px; } .member-card-footer strong { color: #4e73df; } @media print { body * { visibility: hidden; } .member-card, .member-card * { visibility: visible; } .member-card { position: absolute; left: 50%; top: 40px; transform: translateX(-50%); box-shadow: none; border: 1px solid #ddd; } .btn, .navbar, .sidebar, .topbar, footer, .card:not(.member-card) { display: none !important; } @page { size: A4; margin: 0; } } </style>

@endsection