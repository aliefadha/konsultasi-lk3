@extends('layouts.sbadmin')

@section('title', 'Dashboard Klien - LK3')

@section('dashboardLink', route('klien.dashboard'))
@section('sidebarBrandLink', route('klien.dashboard'))


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Klien</h1>
        <a href="{{ route('klien.laporan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Laporan Baru
        </a>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReports ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeConsultations ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Recent Reports -->
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Terbaru</h6>
                    <a href="{{ route('klien.laporan.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Kekerasan</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentReports as $laporan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucfirst($laporan->jenis_kekerasan) }}</td>
                                        <td>{{ $laporan->created_at }}</td>
                                        <td>
                                            @if($laporan->status_laporan == 'menunggu_tinjauan')
                                                <span class="badge badge-warning">Menunggu Tinjauan</span>
                                            @elseif($laporan->status_laporan == 'sedang_ditangani')
                                                <span class="badge badge-success">Sedang Ditangani</span>
                                            @elseif($laporan->status_laporan == 'selesai')
                                                <span class="badge badge-secondary">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($laporan->status_laporan == 'sedang_ditangani')
                                                <a href="{{ route('klien.konsultasi.chat', $laporan->sesiKonsultasi->first()->id ?? '#') }}" class="btn btn-sm btn-success">Chat</a>
                                            @endif
                                            <a href="{{ route('klien.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada laporan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Active Consultation -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Konsultasi Aktif</h6>
                </div>
                <div class="card-body">
                    @if($activeConsultation)
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5>{{ $activeConsultation->profesional->name }}</h5>
                                <p class="text-muted mb-2">Profesional LK3</p>
                                <p class="mb-0">Terakhir aktif: {{ $activeConsultation->profesional->updated_at->diffForHumans() }}</p>
                                <p class="mb-0">Mulai konsultasi: {{ $activeConsultation->tanggal_mulai->diffForHumans() }}</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('klien.konsultasi.chat', $activeConsultation->id) }}" class="btn btn-success btn-lg">
                                    <i class="fas fa-comments"></i> Buka Chat
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>Tidak ada konsultasi aktif saat ini</p>
                            <a href="{{ route('klien.laporan.create') }}" class="btn btn-primary">Buat Laporan Baru</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .badge {
            font-size: 11px;
            padding: 4px 8px;
        }
        
        .alert {
            border-left: 4px solid #dc3545;
        }
        
        .card {
            border: none;
        }
        
        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }
        
        .border-left-success {
            border-left: 4px solid #1cc88a !important;
        }
        
        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }
        
        .border-left-info {
            border-left: 4px solid #36b9cc !important;
        }
    </style>
@endpush