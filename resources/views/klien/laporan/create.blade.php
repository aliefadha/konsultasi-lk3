@extends('layouts.sbadmin')

@section('title', 'Buat Laporan Baru - LK3')

@section('dashboardLink', route('klien.dashboard'))
@section('sidebarBrandLink', route('klien.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Laporan Kasus Baru</h1>
        <a href="{{ route('klien.laporan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Laporan Kasus</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('klien.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Personal Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                   id="nama_lengkap" 
                                   name="nama_lengkap"
                                   value="{{ old('nama_lengkap', auth()->user()->name) }}" 
                                   placeholder="Masukkan nama lengkap Anda">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_telepon">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('no_telepon') is-invalid @enderror" 
                                   id="no_telepon" 
                                   name="no_telepon"
                                   value="{{ old('no_telepon', auth()->user()->no_telepon ?? '') }}" 
                                   placeholder="Masukkan nomor telepon Anda">
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', auth()->user()->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   placeholder="Masukkan email Anda">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Case Information -->
                <h5 class="mb-3">Informasi Kasus</h5>

                <div class="form-group">
                    <label for="judul">Judul Laporan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul') }}" 
                           placeholder="Contoh: Kekerasan fisik dari pasangan" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Berikan judul singkat yang menggambarkan kasus Anda</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_kekerasan">Jenis Kekerasan <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenis_kekerasan') is-invalid @enderror" 
                                    id="jenis_kekerasan" name="jenis_kekerasan" required>
                                <option value="">Pilih Jenis Kekerasan</option>
                                <option value="fisik" {{ old('jenis_kekerasan') == 'fisik' ? 'selected' : '' }}>
                                    Kekerasan Fisik (pukulan, tamparan, dll)
                                </option>
                                <option value="psikis" {{ old('jenis_kekerasan') == 'psikis' ? 'selected' : '' }}>
                                    Kekerasan Psikologis ( Ancaman, penghinaan, dll)
                                </option>
                                <option value="seksual" {{ old('jenis_kekerasan') == 'seksual' ? 'selected' : '' }}>
                                    Kekerasan Seksual
                                </option>
                                <option value="ekonomi" {{ old('jenis_kekerasan') == 'ekonomi' ? 'selected' : '' }}>
                                    Kekerasan Ekonomi (pengendalian finansial)
                                </option>
                                <option value="penelantaran" {{ old('jenis_kekerasan') == 'penelantaran' ? 'selected' : '' }}>
                                    Penelantaran
                                </option>
                                <option value="lainnya" {{ old('jenis_kekerasan') == 'lainnya' ? 'selected' : '' }}>
                                    Lainnya
                                </option>
                            </select>
                            @error('jenis_kekerasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hubungan_pelaku">Hubungan dengan Pelaku <span class="text-danger">*</span></label>
                            <select class="form-control @error('hubungan_pelaku') is-invalid @enderror" 
                                    id="hubungan_pelaku" name="hubungan_pelaku" required>
                                <option value="">Pilih Hubungan</option>
                                <option value="pasangan" {{ old('hubungan_pelaku') == 'pasangan' ? 'selected' : '' }}>
                                    Pasangan/Suami/Istri
                                </option>
                                <option value="mantan_pasangan" {{ old('hubungan_pelaku') == 'mantan_pasangan' ? 'selected' : '' }}>
                                    Mantan Pasangan
                                </option>
                                <option value="keluarga" {{ old('hubungan_pelaku') == 'keluarga' ? 'selected' : '' }}>
                                    Anggota Keluarga
                                </option>
                                <option value="teman" {{ old('hubungan_pelaku') == 'teman' ? 'selected' : '' }}>
                                    Teman
                                </option>
                                <option value="atasan" {{ old('hubungan_pelaku') == 'atasan' ? 'selected' : '' }}>
                                    Atasan/Rekan Kerja
                                </option>
                                <option value="lainnya" {{ old('hubungan_pelaku') == 'lainnya' ? 'selected' : '' }}>
                                    Lainnya
                                </option>
                            </select>
                            @error('hubungan_pelaku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_kejadian">Tanggal Kejadian <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" 
                                   id="tanggal_kejadian" name="tanggal_kejadian" 
                                   value="{{ old('tanggal_kejadian') }}" required>
                            @error('tanggal_kejadian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Tanggal ketika kekerasan terakhir terjadi</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi_kasus">Deskripsi Kasus <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi_kasus') is-invalid @enderror" 
                              id="deskripsi_kasus" name="deskripsi_kasus" rows="6" 
                              placeholder="Ceritakan secara detail tentang kejadian yang Anda alami. Jelaskan kronologi, saksi yang ada, dan dampak yang Anda rasakan..." required>{{ old('deskripsi_kasus') }}</textarea>
                    @error('deskripsi_kasus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Deskripsikan kejadian secara detail. Informasi ini akan membantu tim LK3 dalam memberikan bantuan yang tepat.</small>
                </div>

                <!-- Lampiran File Upload -->
                <div class="form-group">
                    <label for="lampiran">Lampiran (Opsional)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('lampiran') is-invalid @enderror" 
                               id="lampiran" name="lampiran[]" multiple 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.txt,.xls,.xlsx">
                        <label class="custom-file-label" for="lampiran">Pilih file...</label>
                        @error('lampiran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('lampiran.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        Anda dapat mengupload maksimal 5 file dengan format: PDF, DOC, DOCX, JPG, JPEG, PNG, GIF, WEBP, TXT, XLS, XLSX. 
                        Ukuran maksimal per file: 10MB
                    </small>
                    <div id="selectedFiles" class="mt-2"></div>
                </div>

                <hr class="my-4">


                <div class="d-flex justify-content-between">
                    <a href="{{ route('klien.laporan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Set max date to today
        document.getElementById('tanggal_kejadian').max = new Date().toISOString().split('T')[0];
        
        // File input enhancement
        document.getElementById('lampiran').addEventListener('change', function(e) {
            const files = e.target.files;
            const selectedFilesDiv = document.getElementById('selectedFiles');
            
            if (files.length > 0) {
                let fileList = '<div class="alert alert-info"><strong>File yang dipilih:</strong><ul class="mb-0">';
                for (let i = 0; i < Math.min(files.length, 5); i++) {
                    const file = files[i];
                    const sizeInMB = (file.size / 1024 / 1024).toFixed(2);
                    fileList += `<li>${file.name} (${sizeInMB} MB)</li>`;
                }
                if (files.length > 5) {
                    fileList += `<li>... dan ${files.length - 5} file lainnya</li>`;
                }
                fileList += '</ul></div>';
                selectedFilesDiv.innerHTML = fileList;
            } else {
                selectedFilesDiv.innerHTML = '';
            }
        });
        
        // Form validation enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        });
        
        // Custom file input label update
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            const fileName = e.target.files.length > 1 
                ? `${e.target.files.length} file dipilih` 
                : e.target.files[0].name;
            const label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    </script>
@endpush