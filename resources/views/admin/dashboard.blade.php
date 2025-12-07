@extends('layouts.sbadmin')

@section('title', 'Dashboard Admin - LK3')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))



@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Reports Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Laporan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_laporan'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Review Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Tinjauan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['menunggu_tinjauan'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Consultations Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Konsultasi Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['konsultasi_aktif'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Professionals Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Profesional Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['profesional_aktif'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Content Row -->
    <div class="row">

        <!-- Recent Reports -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($recentReports as $report)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $report->jenis_kekerasan ?? 'Laporan Kasus' }}</h6>
                                    <p class="mb-1">oleh: {{ $report->pengguna->name  }}</p>
                                </div>
                                <span class="badge badge-{{ $report->status_laporan == 'menunggu_tinjauan' ? 'warning' : ($report->status_laporan == 'sedang_ditangani' ? 'success' : 'secondary') }} badge-pill">
                                    @switch($report->status_laporan)
                                        @case('menunggu_tinjauan')
                                            Menunggu
                                            @break
                                        @case('sedang_ditangani')
                                            Ditangani
                                            @break
                                        @case('selesai')
                                            Selesai
                                            @break
                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $report->status_laporan)) }}
                                    @endswitch
                                </span>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                Belum ada laporan
                            </div>
                        @endforelse
                    </div>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-primary btn-sm mt-3">Lihat Semua Laporan</a>
                </div>
            </div>
        </div>
    </div>
@endsection