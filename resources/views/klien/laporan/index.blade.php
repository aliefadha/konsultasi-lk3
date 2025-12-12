@extends('layouts.sbadmin')

@section('title', 'Daftar Laporan - LK3')

@section('dashboardLink', route('klien.dashboard'))
@section('sidebarBrandLink', route('klien.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Laporan Saya</h1>
        <a href="{{ route('klien.laporan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Laporan Baru
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Laporan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $laporans->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Tinjauan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $laporans->where('status_laporan', 'menunggu_tinjauan')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sedang Ditangani
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $laporans->where('status_laporan', 'sedang_ditangani')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $laporans->where('status_laporan', 'selesai')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Reports Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Laporan</h6>
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
                    <a class="dropdown-item" href="{{ route('klien.konsultasi.index') }}">
                        <i class="fas fa-comments"></i> Lihat Konsultasi
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($laporans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Jenis Kekerasan</th>
                                <th>Tanggal Kejadian</th>
                                <th>Status</th>
                                <th>Lampiran</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporans as $laporan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ Str::limit($laporan->judul, 50) }}</div>
                                        <small class="text-muted">
                                            {{ Str::limit($laporan->deskripsi_kasus, 80) }}
                                        </small>
                                    </td>
                                    <td>
                                        @switch($laporan->jenis_kekerasan)
                                            @case('fisik')
                                                <span class="badge badge-danger">Fisik</span>
                                                @break
                                            @case('psikis')
                                                <span class="badge badge-warning">Psikologis</span>
                                                @break
                                            @case('seksual')
                                                <span class="badge badge-dark">Seksual</span>
                                                @break
                                            @case('ekonomi')
                                                <span class="badge badge-info">Ekonomi</span>
                                                @break
                                            @case('penelantaran')
                                                <span class="badge badge-secondary">Penelantaran</span>
                                                @break
                                            @default
                                                <span class="badge badge-light">Lainnya</span>
                                        @endswitch
                                        <br>
                                        <small class="text-muted">
                                            {{ ucfirst($laporan->hubungan_pelaku) }}
                                        </small>
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('d/m/Y') }}</div>
                                    </td>
                                    <td>
                                        @switch($laporan->status_laporan)
                                            @case('menunggu_tinjauan')
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock"></i> Menunggu Tinjauan
                                                </span>
                                                @break
                                            @case('sedang_ditangani')
                                                <span class="badge badge-success">
                                                    <i class="fas fa-user-md"></i> Sedang Ditangani
                                                </span>
                                                @if($laporan->sesiKonsultasi && $laporan->sesiKonsultasi->status_sesi === 'aktif')
                                                    <br>
                                                    <a href="{{ route('klien.konsultasi.chat', $laporan->sesiKonsultasi->id) }}" 
                                                       class="badge badge-primary badge-sm">
                                                        <i class="fas fa-comments"></i> Chat Aktif
                                                    </a>
                                                @endif
                                                @break
                                            @case('selesai')
                                                <span class="badge badge-info">
                                                    <i class="fas fa-check"></i> Selesai
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($laporan->lampiranLaporan && $laporan->lampiranLaporan->count() > 0)
                                            <span class="badge badge-info">
                                                <i class="fas fa-paperclip"></i> {{ $laporan->lampiranLaporan->count() }} file
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                @foreach($laporan->lampiranLaporan->take(2) as $lampiran)
                                                    <i class="fas fa-file{{ $lampiran->isImage() ? '-image' : ($lampiran->isPdf() ? '-pdf' : '') }}"></i>
                                                    {{ Str::limit($lampiran->nama_file, 10) }}
                                                    @if(!$loop->last)
                                                        <br>
                                                    @endif
                                                @endforeach
                                                @if($laporan->lampiranLaporan->count() > 2)
                                                    <br>
                                                    <small class="text-muted">... dan {{ $laporan->lampiranLaporan->count() - 2 }} lainnya</small>
                                                @endif
                                            </small>
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-times"></i> Tidak ada
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/Y') }}</div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('klien.laporan.show', $laporan->id) }}" 
                                               class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($laporan->sesiKonsultasi && $laporan->sesiKonsultasi->status === 'aktif')
                                                <a href="{{ route('klien.konsultasi.chat', $laporan->sesiKonsultasi->id) }}" 
                                                   class="btn btn-sm btn-success" title="Buka Chat">
                                                    <i class="fas fa-comments"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $laporans->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum Ada Laporan</h5>
                    <p class="text-gray-500">Anda belum membuat laporan apapun.</p>
                    <a href="{{ route('klien.laporan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Laporan Pertama
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