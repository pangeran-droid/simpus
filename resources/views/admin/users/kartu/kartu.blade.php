@extends('layouts.admin')

@section('main-content')

<div class="container-fluid px-0">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800">Kartu Anggota</h1>
        <p class="mb-0 text-muted">
            Daftar kartu anggota perpustakaan
        </p>
    </div>

    <button onclick="window.print()" class="btn btn-primary">
        <i class="fas fa-print"></i>
        Cetak Kartu
    </button>
</div>

<div class="row">

    @forelse ($user as $anggota)

        <div class="col-md-6 col-lg-4 mb-4">

            <a href="{{ route('admin.users.kartu.detail-kartu', $anggota->id) }}"
            class="text-decoration-none">

                <div class="card shadow border-0 kartu-anggota">

                    <!-- Header kartu -->
                    <div class="kartu-header">
                        <div class="d-flex align-items-center">

                            <div class="logo-perpus">
                                <i class="fas fa-book"></i>
                            </div>

                            <div>
                                <h5 class="mb-0 font-weight-bold">
                                    PERPUSTAKAAN
                                </h5>

                                <small>
                                    KARTU ANGGOTA
                                </small>
                            </div>

                        </div>
                    </div>

                    <!-- Isi kartu -->
                    <div class="card-body">

                        <div class="row align-items-center">

                            <!-- Foto -->
                            <div class="col-4 text-center">

                                @if ($anggota->foto_profile)

                                    <img
                                        src="{{ asset('uploads/profile/' . $anggota->foto_profile) }}"
                                        alt="{{ $anggota->name }}"
                                        class="foto-anggota"
                                    >

                                @else

                                    <div class="foto-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>

                                @endif

                            </div>

                            <!-- Data anggota -->
                            <div class="col-8">

                                <h5 class="font-weight-bold text-gray-800 mb-2">
                                    {{ $anggota->name }}
                                </h5>

                                <div class="mb-2">
                                    <small class="text-muted d-block">
                                        Kode Anggota
                                    </small>

                                    <strong class="text-primary">
                                        {{ $anggota->user_code ?? '-' }}
                                    </strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted d-block">
                                        No. Telepon
                                    </small>

                                    <span>
                                        {{ $anggota->phone ?? '-' }}
                                    </span>
                                </div>

                                <div>
                                    <small class="text-muted d-block">
                                        Email
                                    </small>

                                    <span class="small">
                                        {{ $anggota->email }}
                                    </span>
                                </div>

                            </div>

                        </div>

                        <hr>

                        <div class="text-center">
                            <small class="text-muted">
                                Kartu ini merupakan identitas resmi anggota
                                perpustakaan.
                            </small>
                        </div>

                    </div>

                </div>

            </a>

        </div>


    @empty

        <div class="col-12">

            <div class="card shadow">

                <div class="card-body text-center py-5">

                    <i class="fas fa-id-card fa-3x text-muted mb-3"></i>

                    <h5 class="text-muted">
                        Belum ada anggota
                    </h5>

                    <p class="text-muted mb-0">
                        Data anggota yang terdaftar akan muncul di sini.
                    </p>

                </div>

            </div>

        </div>

    @endforelse

</div>

</div> <style> .kartu-anggota { overflow: hidden; border-radius: 12px; } .kartu-anggota-link { text-decoration: none !important; color: inherit; } .kartu-anggota-link:hover { text-decoration: none !important; color: inherit; } .kartu-anggota { transition: 0.2s; } .kartu-anggota:hover { transform: translateY(-3px); } .kartu-header { background: linear-gradient( 135deg, #4e73df, #224abe ); color: white; padding: 18px 20px; } .logo-perpus { width: 45px; height: 45px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 20px; } .kartu-header h5 { font-size: 16px; } .kartu-header small { opacity: 0.9; } .foto-anggota { width: 90px; height: 110px; object-fit: cover; border-radius: 8px; border: 3px solid #e3e6f0; } .foto-placeholder { width: 90px; height: 110px; background: #eaecf4; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #858796; font-size: 35px; border: 3px solid #e3e6f0; } .kartu-anggota .card-body { padding: 20px; } @media print { body * { visibility: hidden; } .kartu-anggota, .kartu-anggota * { visibility: visible; } .kartu-anggota { position: relative; page-break-inside: avoid; box-shadow: none !important; border: 1px solid #ddd !important; } .btn, .navbar, .sidebar, .topbar, footer { display: none !important; } } </style>

@endsection
