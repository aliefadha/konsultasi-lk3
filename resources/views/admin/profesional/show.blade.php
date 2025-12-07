@extends('layouts.sbadmin')

@section('title', 'Detail Profesional')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Profesional</h1>
        <div>
            <a href="{{ route('admin.profesional.edit', $profesional->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.profesional.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Profesional</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                            {{ strtoupper(substr($profesional->name, 0, 1)) }}
                        </div>
                        <h5 class="mb-1">{{ $profesional->name }}</h5>
                        <p class="text-muted">{{ $profesional->email }}</p>
                    
                    </div>

                    <div class="row text-center mb-4">
                        <div class="col-6">
                            <div class="border-right">
                                <h6 class="text-primary font-weight-bold">{{ $profesional->total_konsultasi ?? 0 }}</h6>
                                <small class="text-muted">Total Konsultasi</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="text-success font-weight-bold">{{ $profesional->konsultasi_aktif ?? 0 }}</h6>
                            <small class="text-muted">Konsultasi Aktif</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Detailed Information -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pribadi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-muted">Nomor Telepon</label>
                                <p>{{ $profesional->no_telepon ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-muted">Jenis Kelamin</label>
                                <p>
                                    @if($profesional->jenis_kelamin)
                                        @if($profesional->jenis_kelamin == 'laki-laki')
                                            <i class="fas fa-mars text-primary"></i> Laki-laki
                                        @else
                                            <i class="fas fa-venus text-danger"></i> Perempuan
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-muted">Tanggal Lahir</label>
                                <p>{{ $profesional->tanggal_lahir ? $profesional->tanggal_lahir->format('d/m/Y') : '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-muted">Umur</label>
                                <p>{{ $profesional->tanggal_lahir ? $profesional->tanggal_lahir->age . ' tahun' : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Consultations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Konsultasi Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Untuk melihat riwayat konsultasi lengkap, klik tombol di bawah:</p>
                        <a href="{{ route('admin.laporan-konsultasi.profesional', $profesional->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Lihat Riwayat Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection