@extends('layouts.sbadmin')

@section('title', 'Dashboard Profesional - LK3')

@section('dashboardLink', route('profesional.dashboard'))
@section('sidebarBrandLink', route('profesional.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Profesional</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

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

        <!-- Total Cases Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kasus
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_kasus'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Active Consultations Table -->
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Konsultasi Aktif</h6>
                    <a href="{{ route('profesional.konsultasi') }}" class="btn btn-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($recentConsultations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Klien</th>
                                        <th>Jenis Kasus</th>
                                        <th>Mulai Konsultasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentConsultations as $sesi)
                                        <tr>
                                            <td>{{ $sesi->klien->name }}</td>
                                            <td>
                                                @if($sesi->laporanKasus)
                                                    <span class="badge badge-info">{{ $sesi->laporanKasus->jenis_kekerasan }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $sesi->tanggal_mulai ? $sesi->tanggal_mulai->setTimezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}</td>
                                            <td>
                                                @if($sesi->status_sesi == 'aktif')
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-secondary">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('profesional.konsultasi.chat', $sesi->id) }}" class="btn btn-sm btn-success">Chat</a>
                                                <a href="{{ route('profesional.konsultasi.detail', $sesi->id) }}" class="btn btn-sm btn-info">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-600">Belum ada konsultasi aktif</h5>
                            <p class="text-gray-500">Belum ada konsultasi aktif yang ditugaskan kepada Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <style>
        .timeline {
            position: relative;
            padding-left: 20px;
        }
        
        .timeline-item {
            position: relative;
            padding: 10px 0;
            padding-left: 30px;
        }
        
        .timeline-item:before {
            content: '';
            position: absolute;
            left: 8px;
            top: 15px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #4e73df;
        }
        
        .timeline-item:not(:last-child):after {
            content: '';
            position: absolute;
            left: 12px;
            top: 25px;
            width: 2px;
            height: calc(100% - 10px);
            background: #e3e6f0;
        }
        
        .timeline-time {
            font-weight: bold;
            color: #4e73df;
            margin-bottom: 5px;
        }
        
        .message-preview {
            background-color: #f8f9fc;
            border-left: 4px solid #4e73df;
        }
        
        .badge {
            font-size: 11px;
            padding: 4px 8px;
        }
    </style>
@endpush