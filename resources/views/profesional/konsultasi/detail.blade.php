@extends('layouts.sbadmin')

@section('title', 'Detail Konsultasi - LK3')
@section('dashboardLink', route('profesional.dashboard'))
@section('sidebarBrandLink', route('profesional.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Konsultasi</h1>
            <small class="text-muted">
                Dengan Klien: <strong>{{ $konsultasi->klien->name }}</strong>
                @if($konsultasi->laporanKasus)
                    | Kasus: {{ $konsultasi->laporanKasus->jenis_kekerasan }}
                @endif
            </small>
        </div>
        <div>
            <a href="{{ route('profesional.konsultasi') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Case Information -->
    @if($konsultasi->laporanKasus)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Kasus</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Jenis Kekerasan:</strong> {{ $konsultasi->laporanKasus->jenis_kekerasan }}</p>
                                <p><strong>Hubungan dengan Pelaku:</strong> {{ $konsultasi->laporanKasus->hubungan_pelaku }}</p>
                                <p><strong>Waktu Kejadian:</strong> {{ $konsultasi->laporanKasus->tanggal_kejadian ? $konsultasi->laporanKasus->tanggal_kejadian->format('d M Y') : '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status Laporan:</strong> 
                                    <span class="badge badge-info">{{ $konsultasi->laporanKasus->status_laporan }}</span>
                                </p>
                                <p><strong>Tanggal Laporan:</strong> {{ $konsultasi->laporanKasus->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p><strong>Deskripsi Kasus:</strong></p>
                                <p>{{ $konsultasi->laporanKasus->deskripsi_kasus }}</p>
                            </div>
                        </div>
                        @if($konsultasi->laporanKasus->catatan_admin)
                            <div class="row">
                                <div class="col-12">
                                    <p><strong>Catatan Admin:</strong></p>
                                    <p>{{ $konsultasi->laporanKasus->catatan_admin }}</p>
                                </div>
                            </div>
                        @endif

                        @if($konsultasi->laporanKasus->lampiranLaporan && $konsultasi->laporanKasus->lampiranLaporan->count() > 0)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-paperclip"></i> Lampiran ({{ $konsultasi->laporanKasus->lampiranLaporan->count() }} file)</strong>
                                    </p>
                                    <div class="row">
                                        @foreach($konsultasi->laporanKasus->lampiranLaporan as $lampiran)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card border">
                                                    <div class="card-body p-3 d-flex">
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
                                                            <h6 class="font-weight-bold mb-1">{{ $lampiran->nama_file }}</h6>
                                                            <small class="text-muted d-block mb-2">
                                                                <i class="fas fa-hdd"></i> {{ $lampiran->formatted_size }}<br>
                                                                <i class="fas fa-calendar"></i> {{ $lampiran->created_at->format('d/m/Y H:i') }}
                                                            </small>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{ $lampiran->url }}" target="_blank" class="btn btn-outline-primary">
                                                                    <i class="fas fa-download"></i> Download
                                                                </a>
                                                                @if($lampiran->isImage())
                                                                    <a href="{{ $lampiran->url }}" target="_blank" class="btn btn-outline-success">
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
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Chat History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Pesan</h6>
                </div>
                <div class="card-body">
                    @if($konsultasi->pesanKonsultasi->count() > 0)
                        <div class="chat-history" style="max-height: 500px; overflow-y: auto;">
                            @foreach($konsultasi->pesanKonsultasi as $message)
                                <div class="message-row mb-3 {{ $message->isFromProfesional() ? 'text-right' : '' }}">
                                    <div class="message-bubble d-inline-block p-3 rounded {{ $message->isFromProfesional() ? 'bg-primary text-white' : 'bg-light' }}" 
                                         style="max-width: 70%;">
                                        <div class="message-content">
                                            <div class="message-text">{{ $message->isi_pesan }}</div>
                                            <small class="message-time {{ $message->isFromProfesional() ? 'text-light' : 'text-muted' }}">
                                                {{ $message->waktu_kirim->format('d M Y H:i') }}
                                                @if($message->isFromProfesional())
                                                    (Anda)
                                                @else
                                                    (Klien: {{ $message->pengirim->name }})
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-comments fa-2x mb-2"></i>
                            <p>Tidak ada pesan dalam konsultasi ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Final Notes -->
    @if($konsultasi->catatan_akhir)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Catatan Akhir Sesi</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $konsultasi->catatan_akhir }}</p>
                        <small class="text-muted">
                            Ditambahkan pada: {{ $konsultasi->tanggal_selesai ? $konsultasi->tanggal_selesai->format('d M Y H:i') : '-' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Client Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Klien</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $konsultasi->klien->name}}</p>
                            <p><strong>Email:</strong> {{ $konsultasi->klien->email, }}{{ substr($konsultasi->klien->email, strpos($konsultasi->klien->email, '@')) }}</p>
                            @if($konsultasi->klien->no_telepon)
                                <p><strong>Telepon:</strong> {{$konsultasi->klien->no_telepon}}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($konsultasi->klien->jenis_kelamin)
                                <p><strong>Jenis Kelamin:</strong> {{ ucfirst($konsultasi->klien->jenis_kelamin) }}</p>
                            @endif
                            @if($konsultasi->klien->alamat)
                                <p><strong>Alamat:</strong> {{ Str::limit($konsultasi->klien->alamat, 50) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-scroll chat history to bottom
        $(document).ready(function() {
            var chatHistory = document.querySelector('.chat-history');
            if (chatHistory) {
                chatHistory.scrollTop = chatHistory.scrollHeight;
            }
        });
    </script>
@endpush
