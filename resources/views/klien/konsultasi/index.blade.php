@extends('layouts.sbadmin')

@section('title', 'Konsultasi - LK3')

@section('dashboardLink', route('klien.dashboard'))
@section('sidebarBrandLink', route('klien.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Konsultasi Saya</h1>
        <a href="{{ route('klien.laporan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Laporan
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Consultations Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Konsultasi</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Aksi:</div>
                    <a class="dropdown-item" href="{{ route('klien.laporan.create') }}">
                        <i class="fas fa-plus"></i> Buat Laporan Baru
                    </a>
                    <a class="dropdown-item" href="{{ route('klien.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($konsultasis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Profesional</th>
                                <th>Laporan</th>
                                <th>Status</th>
                                <th>Mulai Konsultasi</th>
                                <th>Terakhir Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($konsultasis as $konsultasi)
                                <tr>
                                    <td>
                                        <strong>{{ $loop->iteration }}</strong>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $konsultasi->profesional->nama ?? 'Belum ditugaskan' }}</div>
                                        @if($konsultasi->profesional)
                                            <small class="text-muted">{{ $konsultasi->profesional->role ?? 'Profesional' }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($konsultasi->laporanKasus)
                                            <div class="font-weight-bold">{{ Str::limit($konsultasi->laporanKasus->judul, 40) }}</div>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($konsultasi->status)
                                            @case('aktif')
                                                <span class="badge badge-success">
                                                    <i class="fas fa-comments"></i> Aktif
                                                </span>
                                                @break
                                            @case('selesai')
                                                <span class="badge badge-info">
                                                    <i class="fas fa-check"></i> Selesai
                                                </span>
                                                @break
                                            @default
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock"></i> Menunggu
                                                </span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($konsultasi->created_at)
                                            <div>{{ \Carbon\Carbon::parse($konsultasi->created_at)->setTimezone('Asia/Jakarta')->format('d/m/Y') }}</div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($konsultasi->updated_at)
                                            <div>{{ \Carbon\Carbon::parse($konsultasi->updated_at)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($konsultasi->status_sesi === 'aktif')
                                                <a href="{{ route('klien.konsultasi.chat', $konsultasi->id) }}" 
                                                   class="btn btn-sm btn-success" title="Buka Chat">
                                                    <i class="fas fa-comments"></i> Chat
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('klien.laporan.show', $konsultasi->laporanKasus->id ?? '') }}" 
                                               class="btn btn-sm btn-info" title="Lihat Laporan">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $konsultasis->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-md fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum Ada Konsultasi</h5>
                    <p class="text-gray-500">Anda belum memiliki konsultasi apapun.</p>
                    <p class="text-muted">Konsultasi akan dimulai setelah admin menugaskan profesional untuk laporan Anda.</p>
                    <a href="{{ route('klien.laporan.index') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> Lihat Laporan Saya
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <style>
        .badge {
            font-size: 11px;
            padding: 4px 8px;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .btn-group .btn {
            margin-right: 2px;
        }
    </style>
@endpush