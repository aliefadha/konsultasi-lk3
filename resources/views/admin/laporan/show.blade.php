@extends('layouts.sbadmin')

@section('title', 'Detail Laporan #' . $laporan->id . ' - LK3')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-alt text-primary"></i> Detail Laporan #{{ $laporan->id }}
            </h1>
            <p class="text-muted mb-0">
                Dilaporkan pada {{ $laporan->created_at->format('d/m/Y H:i') }} 
                ({{ $laporan->created_at->diffForHumans() }})
            </p>
        </div>
        <div>
            <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mr-2">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
            <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="btn btn-warning mr-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Status Alert -->
    <div class="alert alert-{{ 
        $laporan->status_laporan == 'menunggu_tinjauan' ? 'warning' : 
        ($laporan->status_laporan == 'sedang_ditangani' ? 'info' : 
        ($laporan->status_laporan == 'selesai' ? 'success' : 'danger')) 
    }} d-flex align-items-center" role="alert">
        <i class="fas fa-{{ 
            $laporan->status_laporan == 'menunggu_tinjauan' ? 'clock' : 
            ($laporan->status_laporan == 'sedang_ditangani' ? 'cog' : 
            ($laporan->status_laporan == 'selesai' ? 'check-circle' : 'times-circle')) 
        }} mr-2"></i>
        <div>
            <strong>Status:</strong> 
            @switch($laporan->status_laporan)
                @case('menunggu_tinjauan')
                    Menunggu Tinjauan
                    @break
                @case('sedang_ditangani')
                    Sedang Ditangani
                    @break
                @case('selesai')
                    Selesai
                    @break
                @case('ditolak')
                    Ditolak
                    @break
                @default
                    {{ ucfirst(str_replace('_', ' ', $laporan->status_laporan)) }}
            @endswitch
        </div>
    </div>

    <div class="row">
        <!-- Report Details Column -->
        <div class="col-lg-8">
            <!-- Client Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> Informasi Pelapor
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Nama Lengkap:</label>
                            <p>{{ $laporan->pengguna->name ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Email:</label>
                            <p>{{ $laporan->pengguna->email ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Nomor Telepon:</label>
                            <p>{{ $laporan->pengguna->no_telepon ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Jenis Kelamin:</label>
                            <p>{{ ucfirst($laporan->pengguna->jenis_kelamin ?? 'Tidak tersedia') }}</p>
                        </div>
                        <div class="col-12">
                            <label class="font-weight-bold">Alamat:</label>
                            <p>{{ $laporan->pengguna->alamat ?? 'Tidak tersedia' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Case Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt"></i> Detail Kasus
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Jenis Kekerasan:</label>
                            <p>
                                <span class="badge badge-danger badge-lg">
                                    {{ ucfirst($laporan->jenis_kekerasan) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Hubungan dengan Pelaku:</label>
                            <p>
                                <span class="badge badge-secondary badge-lg">
                                    {{ ucfirst(str_replace('_', ' ', $laporan->hubungan_pelaku)) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Tanggal Kejadian:</label>
                            <p>
                                @if($laporan->tanggal_kejadian)
                                    {{ $laporan->tanggal_kejadian->format('d/m/Y') }}
                                    <small class="text-muted">({{ $laporan->tanggal_kejadian->diffForHumans() }})</small>
                                @else
                                    Tidak disebutkan
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Waktu Pelaporan:</label>
                            <p>{{ $laporan->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-12">
                            <label class="font-weight-bold">Deskripsi Kasus:</label>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($laporan->deskripsi_kasus)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lampiran Section -->
            @if($laporan->lampiranLaporan && $laporan->lampiranLaporan->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-paperclip"></i> Lampiran ({{ $laporan->lampiranLaporan->count() }} file)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($laporan->lampiranLaporan as $lampiran)
                                <div class="col-lg-6 col-xl-4 mb-3">
                                    <div class="card border-info">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-start">
                                                <div class="mr-3">
                                                    @if($lampiran->isImage())
                                                        <i class="fas fa-file-image fa-3x text-success"></i>
                                                    @elseif($lampiran->isPdf())
                                                        <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                    @elseif($lampiran->isDocument())
                                                        <i class="fas fa-file-word fa-3x text-primary"></i>
                                                    @else
                                                        <i class="fas fa-file fa-3x text-secondary"></i>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-2 font-weight-bold text-dark">{{ $lampiran->nama_file }}</h6>
                                                    <div class="mb-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-hdd"></i> {{ $lampiran->formatted_size }}<br>
                                                            <i class="fas fa-calendar"></i> {{ $lampiran->created_at->format('d/m/Y H:i') }}
                                                        </small>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ $lampiran->url }}" target="_blank" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                        @if($lampiran->isImage())
                                                            <a href="{{ $lampiran->url }}" target="_blank" 
                                                               class="btn btn-sm btn-outline-success">
                                                                <i class="fas fa-eye"></i> Preview
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-muted">
                            <i class="fas fa-paperclip"></i> Lampiran
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Tidak ada lampiran untuk laporan ini.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Consultation Session Info -->
            @if($laporan->sesiKonsultasi)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-comments"></i> Informasi Sesi Konsultasi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Status Sesi:</label>
                                <p>
                                    <span class="badge badge-{{ $laporan->sesiKonsultasi->status_sesi == 'aktif' ? 'success' : 'secondary' }} badge-pill">
                                        {{ ucfirst($laporan->sesiKonsultasi->status_sesi) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tanggal Mulai:</label>
                                <p>{{ $laporan->sesiKonsultasi->tanggal_mulai->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($laporan->sesiKonsultasi->profesional)
                                <div class="col-12">
                                    <label class="font-weight-bold">Profesional yang Ditugaskan:</label>
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px;">
                                                {{ strtoupper(substr($laporan->sesiKonsultasi->profesional->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $laporan->sesiKonsultasi->profesional->name }}</h6>
                                                <p class="mb-1 text-muted">{{ $laporan->sesiKonsultasi->profesional->email }}</p>
                                                @if($laporan->sesiKonsultasi->profesional->spesialisasi)
                                                    <span class="badge badge-info">{{ $laporan->sesiKonsultasi->profesional->spesialisasi }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Admin Actions Column -->
        <div class="col-lg-4">
            <!-- Update Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Update Status Laporan
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.laporan.update-status', $laporan->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="status_laporan">Status Baru:</label>
                            <select name="status_laporan" id="status_laporan" class="form-control" required>
                                <option value="">Pilih Status</option>
                                <option value="menunggu_tinjauan" {{ $laporan->status_laporan == 'menunggu_tinjauan' ? 'selected' : '' }}>
                                    Menunggu Tinjauan
                                </option>
                                <option value="sedang_ditangani" {{ $laporan->status_laporan == 'sedang_ditangani' ? 'selected' : '' }}>
                                    Sedang Ditangani
                                </option>
                                <option value="selesai" {{ $laporan->status_laporan == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                                <option value="ditolak" {{ $laporan->status_laporan == 'ditolak' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="catatan_admin">Catatan Admin (Opsional):</label>
                            <textarea name="catatan_admin" id="catatan_admin" class="form-control" rows="4" 
                                placeholder="Tambahkan catatan tentang perubahan status ini...">{{ old('catatan_admin', $laporan->catatan_admin) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Assign Professional -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-user-md"></i> Tugaskan Profesional
                    </h6>
                </div>
                <div class="card-body">
                    @if($laporan->sesiKonsultasi && $laporan->sesiKonsultasi->profesional)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Profesional sudah ditugaskan:</strong><br>
                            {{ $laporan->sesiKonsultasi->profesional->name }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.laporan.assign', $laporan->id) }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="profesional_id">Pilih Profesional:</label>
                            <select name="profesional_id" id="profesional_id" class="form-control" required>
                                <option value="">-- Pilih Profesional --</option>
                                @php
                                    $activeProfessionals = \App\Models\User::where('role', \App\Models\User::ROLE_PROFESIONAL)->get();
                                @endphp
                                @foreach($activeProfessionals as $profesional)
                                    <option value="{{ $profesional->id }}" 
                                        {{ ($laporan->sesiKonsultasi && $laporan->sesiKonsultasi->profesional_id == $profesional->id) ? 'selected' : '' }}>
                                        {{ $profesional->name }} 
                                        @if($profesional->spesialisasi)
                                            ({{ $profesional->spesialisasi }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @if($activeProfessionals->count() == 0)
                                <small class="text-danger">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Belum ada profesional terdaftar. 
                                    <a href="{{ route('admin.profesional.create') }}">Tambah profesional</a>
                                </small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success btn-block" 
                                {{ $activeProfessionals->count() == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-user-plus"></i> 
                            {{ $laporan->sesiKonsultasi ? 'Update Tugas' : 'Tugaskan Profesional' }}
                        </button>
                    </form>

                    @if($activeProfessionals->count() > 0)
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle"></i>
                            Tugas profesional akan membuat sesi konsultasi dan mengubah status laporan menjadi "Sedang Ditangani".
                        </small>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection