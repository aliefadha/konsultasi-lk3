@extends('layouts.sbadmin')

@section('title', 'Detail Konsultasi - LK3')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-comments text-primary"></i> Detail Sesi Konsultasi
            </h1>
            <p class="text-muted mb-0">
                ID Sesi: #{{ $konsultasi->id }}
                @if($konsultasi->laporanKasus)
                    | Kasus: {{ $konsultasi->laporanKasus->jenis_kekerasan ?? 'N/A' }}
                @endif
            </p>
        </div>
        <div>
            <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Status Alert -->
    <div class="alert alert-{{ $konsultasi->status_sesi == 'aktif' ? 'success' : 'secondary' }} d-flex align-items-center" role="alert">
        <i class="fas fa-{{ $konsultasi->status_sesi == 'aktif' ? 'play-circle' : 'check-circle' }} mr-2"></i>
        <div>
            <strong>Status Sesi:</strong> 
            {{ ucfirst($konsultasi->status_sesi) }}
            @if($konsultasi->status_sesi == 'aktif')
                (Berlangsung)
            @elseif($konsultasi->status_sesi == 'selesai')
                (Selesai)
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Consultation Details Column -->
        <div class="col-lg-12">
            <!-- Participants Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users"></i> Informasi Peserta
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Client Information -->
                        <div class="col-md-6">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="font-weight-bold text-info mb-3">
                                    <i class="fas fa-user"></i> Klien
                                </h6>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px;">
                                        {{ strtoupper(substr($konsultasi->klien->name ?? 'K', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $konsultasi->klien->name ?? 'Unknown' }}</h6>
                                        <p class="mb-0 text-muted small">{{ $konsultasi->klien->email ?? '' }}</p>
                                    </div>
                                </div>
                                @if($konsultasi->klien && $konsultasi->klien->no_telepon)
                                    <p class="mb-1"><strong>Telepon:</strong> {{ $konsultasi->klien->no_telepon }}</p>
                                @endif
                                @if($konsultasi->klien && $konsultasi->klien->alamat)
                                    <p class="mb-0"><strong>Alamat:</strong> {{ $konsultasi->klien->alamat }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="col-md-6">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="font-weight-bold text-success mb-3">
                                    <i class="fas fa-user-md"></i> Profesional
                                </h6>
                                @if($konsultasi->profesional)
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar-sm bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px;">
                                            {{ strtoupper(substr($konsultasi->profesional->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $konsultasi->profesional->name }}</h6>
                                            <p class="mb-0 text-muted small">{{ $konsultasi->profesional->email }}</p>
                                        </div>
                                    </div>
                                    @if($konsultasi->profesional->spesialisasi)
                                        <p class="mb-1"><strong>Spesialisasi:</strong> {{ $konsultasi->profesional->spesialisasi }}</p>
                                    @endif
                                    @if($konsultasi->profesional->no_telepon)
                                        <p class="mb-0"><strong>Telepon:</strong> {{ $konsultasi->profesional->no_telepon }}</p>
                                    @endif
                                @else
                                    <div class="text-center py-3">
                                        <i class="fas fa-user-plus fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada profesional yang ditugaskan</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Case Information -->
            @if($konsultasi->laporanKasus)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-file-alt"></i> Informasi Kasus
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Jenis Kekerasan:</label>
                                <p>
                                    <span class="badge badge-danger badge-lg">
                                        {{ ucfirst($konsultasi->laporanKasus->jenis_kekerasan) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Hubungan dengan Pelaku:</label>
                                <p>
                                    <span class="badge badge-secondary badge-lg">
                                        {{ ucfirst(str_replace('_', ' ', $konsultasi->laporanKasus->hubungan_pelaku)) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-12">
                                <label class="font-weight-bold">Deskripsi Kasus:</label>
                                <div class="border rounded p-3 bg-light">
                                    {!! nl2br(e($konsultasi->laporanKasus->deskripsi_kasus ?? 'Tidak ada deskripsi')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Chat Messages -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comments"></i> Riwayat Pesan ({{ $konsultasi->pesanKonsultasi->count() }} pesan)
                    </h6>
                </div>
                <div class="card-body">
                    @forelse($konsultasi->pesanKonsultasi->sortBy('waktu_kirim') as $message)
                        <div class="mb-3 {{ $message->isFromKlien() ? 'text-right' : '' }}">
                            <div class="d-inline-block max-width-70 {{ $message->isFromKlien() ? 'text-right' : 'text-left' }}">
                                <div class="small text-muted mb-1">
                                    <strong>{{ $message->pengirim->name ?? 'Unknown' }}</strong>
                                    @if($message->isFromKlien())
                                        <span class="badge badge-info ml-1">Klien</span>
                                    @else
                                        <span class="badge badge-success ml-1">Profesional</span>
                                    @endif
                                    - {{ $message->waktu_kirim->format('d/m/Y H:i:s') }}
                                </div>
                                <div class="p-3 rounded {{ $message->isFromKlien() ? 'bg-primary text-white' : 'bg-light' }}">
                                    {!! nl2br(e($message->isi_pesan)) !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada pesan dalam sesi konsultasi ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection

@section('styles')
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .timeline-marker.bg-primary {
            background-color: #4e73df;
        }
        
        .timeline-marker.bg-success {
            background-color: #1cc88a;
        }
        
        .timeline-marker.bg-secondary {
            background-color: #6c757d;
        }
        
        .timeline-content {
            padding-left: 20px;
        }
        
        .timeline-title {
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .timeline-description {
            font-size: 12px;
            margin-bottom: 0;
        }
        
        .max-width-70 {
            max-width: 70%;
        }
        
        @media (max-width: 768px) {
            .max-width-70 {
                max-width: 100%;
            }
        }
    </style>
@endsection