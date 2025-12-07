@extends('layouts.sbadmin')

@section('title', 'Detail Laporan - LK3')

@section('dashboardLink', route('klien.dashboard'))
@section('sidebarBrandLink', route('klien.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Laporan</h1>
            <p class="text-muted mb-0">LPR-{{ str_pad($laporan->id, 3, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div>
            <a href="{{ route('klien.laporan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            @if($laporan->sesiKonsultasi && $laporan->sesiKonsultasi->status_sesi === 'aktif')
                <a href="{{ route('klien.konsultasi.chat', $laporan->sesiKonsultasi->id) }}" class="btn btn-success">
                    <i class="fas fa-comments"></i> Buka Chat
                </a>
            @endif
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

    <div class="row">
        <!-- Report Details -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt"></i> Informasi Laporan
                    </h6>
                    <div>
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
                                @break
                            @case('selesai')
                                <span class="badge badge-info">
                                    <i class="fas fa-check"></i> Selesai
                                </span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-primary">Judul Laporan</label>
                                <div class="p-2 bg-light rounded">{{ $laporan->judul }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-primary">ID Laporan</label>
                                <div class="p-2 bg-light rounded">
                                    <strong>LPR-{{ str_pad($laporan->id, 3, '0', STR_PAD_LEFT) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-primary">Jenis Kekerasan</label>
                                <div class="p-2 bg-light rounded">
                                    @switch($laporan->jenis_kekerasan)
                                        @case('fisik')
                                            <span class="badge badge-danger">Kekerasan Fisik</span>
                                            @break
                                        @case('psikis')
                                            <span class="badge badge-warning">Kekerasan Psikologis</span>
                                            @break
                                        @case('seksual')
                                            <span class="badge badge-dark">Kekerasan Seksual</span>
                                            @break
                                        @case('ekonomi')
                                            <span class="badge badge-info">Kekerasan Ekonomi</span>
                                            @break
                                        @case('penelantaran')
                                            <span class="badge badge-secondary">Penelantaran</span>
                                            @break
                                        @default
                                            <span class="badge badge-light">Lainnya</span>
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-primary">Hubungan dengan Pelaku</label>
                                <div class="p-2 bg-light rounded">
                                    {{ ucwords(str_replace('_', ' ', $laporan->hubungan_pelaku)) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-primary">Tanggal Kejadian</label>
                                <div class="p-2 bg-light rounded">
                                    <i class="fas fa-calendar"></i> 
                                    {{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('d F Y') }}
                                    <br>
                                    <small class="text-muted">
                                        ({{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->diffForHumans() }})
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-primary">Tanggal Dibuat</label>
                                <div class="p-2 bg-light rounded">
                                    <i class="fas fa-clock"></i> 
                                    {{ \Carbon\Carbon::parse($laporan->created_at)->format('d F Y, H:i') }}
                                    <br>
                                    <small class="text-muted">
                                        ({{ \Carbon\Carbon::parse($laporan->created_at)->diffForHumans() }})
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-primary">Deskripsi Kasus</label>
                        <div class="p-3 bg-light rounded" style="min-height: 120px;">
                            {!! nl2br(e($laporan->deskripsi_kasus)) !!}
                        </div>
                    </div>

                    @if($laporan->catatan_admin)
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-primary">
                                <i class="fas fa-sticky-note"></i> Catatan dari Admin
                            </label>
                            <div class="p-3 bg-info text-white rounded">
                                {!! nl2br(e($laporan->catatan_admin)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Lampiran Section -->
                    @if($laporan->lampiranLaporan && $laporan->lampiranLaporan->count() > 0)
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-primary">
                                <i class="fas fa-paperclip"></i> Lampiran ({{ $laporan->lampiranLaporan->count() }} file)
                            </label>
                            <div class="row">
                                @foreach($laporan->lampiranLaporan as $lampiran)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card border">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="mr-3">
                                                        @if($lampiran->isImage())
                                                            <i class="fas fa-file-image fa-2x text-success"></i>
                                                        @elseif($lampiran->isPdf())
                                                            <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                                        @elseif($lampiran->isDocument())
                                                            <i class="fas fa-file-word fa-2x text-primary"></i>
                                                        @else
                                                            <i class="fas fa-file fa-2x text-secondary"></i>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 font-weight-bold">{{ $lampiran->nama_file }}</h6>
                                                        <p class="mb-1 text-muted small">
                                                            <i class="fas fa-hdd"></i> {{ $lampiran->formatted_size }}<br>
                                                            <i class="fas fa-calendar"></i> {{ $lampiran->created_at->format('d/m/Y H:i') }}
                                                        </p>
                                                        <a href="{{ $lampiran->url }}" target="_blank" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                        @if($lampiran->isImage())
                                                            <a href="{{ $lampiran->url }}" target="_blank" 
                                                               class="btn btn-sm btn-outline-success ml-1">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-primary">
                                <i class="fas fa-paperclip"></i> Lampiran
                            </label>
                            <div class="p-3 bg-light rounded text-muted">
                                <i class="fas fa-info-circle"></i> Tidak ada lampiran untuk laporan ini.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 30px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 8px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #e0e0e0;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e0e0e0;
        }
        
        .timeline-item.active::before {
            background: #4e73df;
            box-shadow: 0 0 0 2px #4e73df;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            left: -17px;
            top: 20px;
            width: 2px;
            height: calc(100% - 10px);
            background: #e0e0e0;
        }
        
        .timeline-item:last-child::after {
            display: none;
        }
        
        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e0e0e0;
        }
        
        .timeline-item.active .timeline-marker {
            color: #4e73df;
        }
        
        .timeline-content h6 {
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .timeline-content p {
            font-size: 12px;
            margin: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto refresh for consultation status
        @if($laporan->sesiKonsultasi && $laporan->sesiKonsultasi->status_sesi === 'aktif')
            setInterval(function() {
                // You can implement auto-refresh here if needed
                console.log('Consultation is active');
            }, 30000); // Check every 30 seconds
        @endif
    </script>
@endpush