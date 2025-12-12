@extends('layouts.sbadmin')

@section('title', 'Chat Konsultasi - LK3')
@section('dashboardLink', route('profesional.dashboard'))
@section('sidebarBrandLink', route('profesional.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Chat Konsultasi</h1>
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
            @if($konsultasi->status_sesi == 'aktif')
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalSelesai">
                    <i class="fas fa-check-circle"></i> Selesai Konsultasi
                </button>
            @endif
        </div>
    </div>

    <!-- Chat Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Status: 
                        @if($konsultasi->status_sesi == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Selesai</span>
                        @endif
                    </h6>
                    <small class="text-muted">
                        Mulai: {{ $konsultasi->tanggal_mulai ? $konsultasi->tanggal_mulai->setTimezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}
                        @if($konsultasi->tanggal_selesai)
                            | Selesai: {{ $konsultasi->tanggal_selesai->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}
                        @endif
                    </small>
                </div>
                <div class="card-body p-0">
                    <!-- Chat Messages Container -->
                    <div id="chat-container" style="height: 400px; overflow-y: auto; padding: 15px;">
                        @include('profesional.konsultasi.partials.chat_messages')
                    </div>

                    <!-- Message Input -->
                    @if($konsultasi->status_sesi == 'aktif')
                        <div class="message-input border-top p-3">
                            <form action="{{ route('profesional.konsultasi.pesan', $konsultasi->id) }}" method="POST" id="messageForm">
                                @csrf
                                <div class="input-group">
                                    <input type="text" 
                                           name="isi_pesan" 
                                           class="form-control" 
                                           placeholder="Ketik pesan Anda..." 
                                           maxlength="1000"
                                           required
                                           id="messageInput">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary" id="sendBtn">
                                            <i class="fas fa-paper-plane"></i> Kirim
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Maksimal 1000 karakter</small>
                            </form>
                        </div>
                    @else
                        <div class="message-input border-top p-3 bg-light">
                            <div class="text-center text-muted">
                                <i class="fas fa-lock"></i> Konsultasi telah selesai. Tidak dapat mengirim pesan lagi.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Case Information Card -->
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
                                <p><strong>Deskripsi:</strong></p>
                                <p>{{ $konsultasi->laporanKasus->deskripsi_kasus }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                            Ditambahkan pada: {{ $konsultasi->tanggal_selesai ? $konsultasi->tanggal_selesai->setTimezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

<!-- Modal Selesai Konsultasi -->
@if($konsultasi->status_sesi == 'aktif')
    <div class="modal fade" id="modalSelesai" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selesaikan Konsultasi</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('profesional.konsultasi.selesai', $konsultasi->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyelesaikan konsultasi ini?</p>
                        <p class="text-muted small">Setelah diselesaikan, klien tidak akan dapat mengirim pesan lagi.</p>
                        <div class="form-group">
                            <label for="catatan_akhir">Catatan Akhir (Opsional)</label>
                            <textarea name="catatan_akhir" 
                                      id="catatan_akhir" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Catatan tentang hasil konsultasi atau rekomendasi..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@push('scripts')
    <script>
        // Auto-scroll to bottom of chat
        function scrollToBottom() {
            var chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Fetch new messages without page reload
        function fetchMessages() {
            var chatContainer = document.getElementById('chat-container');
            // Check if user is near bottom (within 100px)
            var isNearBottom = chatContainer.scrollHeight - chatContainer.scrollTop - chatContainer.clientHeight < 100;

            $.ajax({
                url: window.location.href,
                method: 'GET',
                success: function(response) {
                    $('#chat-container').html(response);
                    if (isNearBottom) {
                        scrollToBottom();
                    }
                }
            });
        }

        // Initialize scroll position
        $(document).ready(function() {
            scrollToBottom();
        });

        // Form submission with AJAX for better UX
        $('#messageForm').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var submitBtn = $('#sendBtn');
            var messageInput = $('#messageInput');
            
            // Disable button and show loading
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
            
            // Submit form
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Clear input
                    messageInput.val('');
                    
                    // Fetch new messages immediately
                    // Since we just sent a message, we definitely want to see it, so scroll to bottom
                    $.ajax({
                        url: window.location.href,
                        method: 'GET',
                        success: function(response) {
                            $('#chat-container').html(response);
                            scrollToBottom();
                        }
                    });
                },
                error: function(xhr) {
                    alert('Gagal mengirim pesan. Silakan coba lagi.');
                    console.error(xhr.responseText);
                },
                complete: function() {
                    // Re-enable button
                    submitBtn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Kirim');
                    messageInput.focus();
                }
            });
        });

        // Auto-refresh chat every 10 seconds to check for new messages
        setInterval(function() {
            // Only fetch if tab is active
            if (document.hasFocus()) {
                fetchMessages();
            }
        }, 10000);

        // Submit form on Enter key
        $('#messageInput').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#messageForm').submit();
            }
        });
    </script>
@endpush