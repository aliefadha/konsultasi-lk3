@extends('layouts.sbadmin')

@section('title', 'Chat Konsultasi - LK3')

@section('dashboardLink', route('klien.dashboard'))
@section('sidebarBrandLink', route('klien.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Chat Konsultasi</h1>
            <p class="text-muted mb-0">
                Profesional: {{ $konsultasi->profesional->name ?? 'Belum ditugaskan' }}
            </p>
        </div>
        <div>
            <a href="{{ route('klien.konsultasi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Konsultasi
            </a>
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
        <!-- Chat Area -->
        <div class="col-lg-8">
            <div class="card shadow mb-4" style="height: 600px;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comments"></i> Chat dengan 
                        {{ $konsultasi->profesional->name ?? 'Profesional' }}
                    </h6>
                    <div>
                        <span class="badge badge-success">
                            <i class="fas fa-circle"></i> Online
                        </span>
                    </div>
                </div>
                
                <!-- Messages Container -->
                <div class="card-body chat-messages" style="overflow-y: auto; height: 400px; padding: 15px;">
                    @if($konsultasi->pesanKonsultasi && $konsultasi->pesanKonsultasi->count() > 0)
                        @foreach($konsultasi->pesanKonsultasi as $message)
                            <div class="message {{ $message->jenis_pengirim === 'klien' ? 'message-client' : 'message-professional' }}">
                                <div class="message-content">
                                    <div class="message-header">
                                        <strong>{{ $message->pengirim->name ?? 'Unknown' }}</strong>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <div class="message-body">
                                        {!! nl2br(e($message->isi_pesan)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-comments fa-2x mb-2"></i>
                            <p>Belum ada pesan. Mulai percakapan dengan profesional Anda.</p>
                        </div>
                    @endif
                </div>

                <!-- Message Input Form -->
                <div class="card-footer">
                    <form action="{{ route('klien.konsultasi.pesan', $konsultasi->id) }}" method="POST" id="chatForm">
                        @csrf
                        <div class="input-group">
                            <input type="text" 
                                   name="isi_pesan" 
                                   class="form-control @error('isi_pesan') is-invalid @enderror" 
                                   placeholder="Tulis pesan Anda..." 
                                   required
                                   autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-paper-plane"></i> Kirim
                                </button>
                            </div>
                        </div>
                        @error('isi_pesan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>

        <!-- Consultation Info Sidebar -->
        <div class="col-lg-4">
            <!-- Professional Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-md"></i> Informasi Profesional
                    </h6>
                </div>
                <div class="card-body">
                    @if($konsultasi->profesional)
                        <div class="text-center mb-3">
                            <div class="avatar mb-2" style="width: 80px; height: 80px; background: #4e73df; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                                {{ substr($konsultasi->profesional->nama, 0, 1) }}
                            </div>
                            <h6 class="font-weight-bold">{{ $konsultasi->profesional->nama }}</h6>
                            <p class="text-muted">{{ $konsultasi->profesional->role ?? 'Profesional LK3' }}</p>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Status:</strong>
                            <span class="badge badge-success">
                                <i class="fas fa-circle"></i> Online
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Mulai Konsultasi:</strong><br>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($konsultasi->created_at)->format('d F Y, H:i') }}
                            </small>
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-user-md fa-2x mb-2"></i>
                            <p>Profesional belum ditugaskan</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Report Info -->
            @if($konsultasi->laporanKasus)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-file-alt"></i> Informasi Laporan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Judul:</strong><br>
                            {{ Str::limit($konsultasi->laporanKasus->judul, 50) }}
                        </div>
                        <div class="mb-2">
                            <strong>Jenis Kekerasan:</strong><br>
                            @switch($konsultasi->laporanKasus->jenis_kekerasan)
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
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{ route('klien.laporan.show', $konsultasi->laporanKasus->id) }}" 
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Lihat Detail Laporan
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .chat-messages {
            background: #f8f9fc;
        }
        
        .message {
            margin-bottom: 15px;
        }
        
        .message-client {
            text-align: right;
        }
        
        .message-professional {
            text-align: left;
        }
        
        .message-content {
            display: inline-block;
            max-width: 80%;
            padding: 10px 15px;
            border-radius: 15px;
            word-wrap: break-word;
        }
        
        .message-client .message-content {
            background: #4e73df;
            color: white;
        }
        
        .message-professional .message-content {
            background: white;
            border: 1px solid #e3e6f0;
            color: #5a5c69;
        }
        
        .message-header {
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .message-client .message-header {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .message-professional .message-header {
            color: #858796;
        }
        
        .message-body {
            font-size: 14px;
            line-height: 1.4;
        }
        
        .avatar {
            background: #4e73df !important;
            font-weight: bold;
        }
        
        .badge {
            font-size: 11px;
            padding: 4px 8px;
        }
        
        .card {
            border: none;
        }
        
        .card-footer {
            background: white;
            border-top: 1px solid #e3e6f0;
        }
        
        #chatForm {
            margin-bottom: 0;
        }
        
        #chatForm .form-control {
            border-right: none;
        }
        
        #chatForm .btn {
            border-left: 1px solid #d1d3e2;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto scroll to bottom of messages
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.querySelector('.chat-messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });

        // Form submission handling
        document.getElementById('chatForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const inputField = this.querySelector('input[name="isi_pesan"]');
            
            if (inputField.value.trim()) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                
                // Re-enable after a delay (you might want to handle this differently)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim';
                }, 2000);
            }
        });

        // Auto refresh messages every 30 seconds
        @if($konsultasi->status_sesi === 'aktif')
            setInterval(function() {
                // You can implement auto-refresh logic here
                // For now, we'll just log that the consultation is active
                console.log('Chat is active - checking for new messages');
            }, 30000);
        @endif

        // Enter key handling for message input
        document.querySelector('input[name="isi_pesan"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('chatForm').submit();
            }
        });
    </script>
@endpush