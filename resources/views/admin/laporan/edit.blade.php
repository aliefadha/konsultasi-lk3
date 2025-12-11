@extends('layouts.sbadmin')

@section('title', 'Edit Laporan #' . $laporan->id . ' - LK3')

@section('description', 'Edit data laporan kasus')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-primary"></i> Edit Laporan #{{ $laporan->id }}
        </h1>
        <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Detail
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Laporan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="judul">Judul Laporan</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                        id="judul" name="judul" value="{{ old('judul', $laporan->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_kekerasan">Jenis Kekerasan</label>
                            <select class="form-control @error('jenis_kekerasan') is-invalid @enderror" 
                                id="jenis_kekerasan" name="jenis_kekerasan" required>
                                <option value="">-- Pilih Jenis Kekerasan --</option>
                                <option value="fisik" {{ old('jenis_kekerasan', $laporan->jenis_kekerasan) == 'fisik' ? 'selected' : '' }}>Fisik</option>
                                <option value="psikis" {{ old('jenis_kekerasan', $laporan->jenis_kekerasan) == 'psikis' ? 'selected' : '' }}>Psikis</option>
                                <option value="seksual" {{ old('jenis_kekerasan', $laporan->jenis_kekerasan) == 'seksual' ? 'selected' : '' }}>Seksual</option>
                                <option value="ekonomi" {{ old('jenis_kekerasan', $laporan->jenis_kekerasan) == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                <option value="penelantaran" {{ old('jenis_kekerasan', $laporan->jenis_kekerasan) == 'penelantaran' ? 'selected' : '' }}>Penelantaran</option>
                                <option value="lainnya" {{ old('jenis_kekerasan', $laporan->jenis_kekerasan) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_kekerasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="hubungan_pelaku">Hubungan dengan Pelaku</label>
                            <select class="form-control @error('hubungan_pelaku') is-invalid @enderror" 
                                id="hubungan_pelaku" name="hubungan_pelaku" required>
                                <option value="">-- Pilih Hubungan --</option>
                                <option value="pasangan" {{ old('hubungan_pelaku', $laporan->hubungan_pelaku) == 'pasangan' ? 'selected' : '' }}>Pasangan</option>
                                <option value="mantan_pasangan" {{ old('hubungan_pelaku', $laporan->hubungan_pelaku) == 'mantan_pasangan' ? 'selected' : '' }}>Mantan Pasangan</option>
                                <option value="keluarga" {{ old('hubungan_pelaku', $laporan->hubungan_pelaku) == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                                <option value="teman" {{ old('hubungan_pelaku', $laporan->hubungan_pelaku) == 'teman' ? 'selected' : '' }}>Teman</option>
                                <option value="atasan" {{ old('hubungan_pelaku', $laporan->hubungan_pelaku) == 'atasan' ? 'selected' : '' }}>Atasan</option>
                                <option value="lainnya" {{ old('hubungan_pelaku', $laporan->hubungan_pelaku) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('hubungan_pelaku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tanggal_kejadian">Tanggal Kejadian</label>
                    <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" 
                        id="tanggal_kejadian" name="tanggal_kejadian" 
                        value="{{ old('tanggal_kejadian', $laporan->tanggal_kejadian ? $laporan->tanggal_kejadian->format('Y-m-d') : '') }}">
                    @error('tanggal_kejadian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi_kasus">Deskripsi Kasus</label>
                    <textarea class="form-control @error('deskripsi_kasus') is-invalid @enderror" 
                        id="deskripsi_kasus" name="deskripsi_kasus" rows="6" required>{{ old('deskripsi_kasus', $laporan->deskripsi_kasus) }}</textarea>
                    @error('deskripsi_kasus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
@endsection
