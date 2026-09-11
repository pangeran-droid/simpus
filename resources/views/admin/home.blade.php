@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Buku</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($widget['total_buku']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sedang Dipinjam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($widget['dipinjam']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Terlambat</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ number_format($widget['terlambat']) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Users') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Grafik Peminjaman -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Pendapatan dari hasil Denda {{ now()->year }}
                    </h6>
                </div>

                <div class="card-body">

                    <div class="chart-area">
                        <canvas id="chartDenda"></canvas>
                    </div>

                </div>

            </div>
        </div>


        <!-- Status Transaksi -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Status Transaksi
                    </h6>
                </div>

                <div class="card-body">

                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="chartStatus"></canvas>
                    </div>

                    <div class="mt-4 text-center small">

                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i>
                            Dipinjam
                        </span>

                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i>
                            Terlambat
                        </span>

                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i>
                            Kembali
                        </span>

                    </div>

                </div>

            </div>
        </div>

    </div>

    @push('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const canvasDenda = document.getElementById('chartDenda');

        if (canvasDenda) {

            new Chart(canvasDenda, {
                type: 'line',

                data: {
                    labels: [
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'Mei',
                        'Jun',
                        'Jul',
                        'Agu',
                        'Sep',
                        'Okt',
                        'Nov',
                        'Des'
                    ],

                    datasets: [{
                        label: 'Pendapatan Denda',

                        data: @json($widget['grafik_denda']),

                        backgroundColor: 'rgba(28, 200, 138, 0.15)',

                        borderColor: '#1cc88a',

                        borderWidth: 3,

                        pointBackgroundColor: '#1cc88a',

                        pointBorderColor: '#fff',

                        pointBorderWidth: 2,

                        pointRadius: 4,

                        pointHoverRadius: 6,

                        fill: true,

                        tension: 0.3
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    scales: {
                        y: {
                            beginAtZero: true,

                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' +
                                        new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },

                    plugins: {
                        legend: {
                            display: false
                        },

                        tooltip: {
                            callbacks: {
                                label: function(context) {

                                    let value = context.raw || 0;

                                    return 'Denda: Rp ' +
                                        new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });
        }


        const canvasStatus = document.getElementById('chartStatus');

        if (canvasStatus) {

            new Chart(canvasStatus, {

                type: 'doughnut',

                data: {

                    labels: [
                        'Dipinjam',
                        'Terlambat',
                        'Kembali'
                    ],

                    datasets: [{
                        data: @json($widget['status_transaksi']),

                        backgroundColor: [
                            '#1cc88a',
                            '#e74a3b',
                            '#4e73df'
                        ],

                        hoverBackgroundColor: [
                            '#17a673',
                            '#be2617',
                            '#224abe'
                        ],

                        borderWidth: 2
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    cutout: '70%',

                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

    });
    </script>

    @endpush

@endsection
