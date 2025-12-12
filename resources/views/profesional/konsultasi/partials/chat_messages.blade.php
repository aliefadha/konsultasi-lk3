@if($messages->count() > 0)
    @foreach($messages as $message)
        <div class="message-row mb-3 {{ $message->isFromProfesional() ? 'text-right' : '' }}">
            <div class="message-bubble d-inline-block p-3 rounded {{ $message->isFromProfesional() ? 'bg-primary text-white' : 'bg-light' }}" 
                 style="max-width: 70%;">
                <div class="message-content">
                    <div class="message-text">{{ $message->isi_pesan }}</div>
                    <small class="message-time {{ $message->isFromProfesional() ? 'text-light' : 'text-muted' }}">
                        {{ $message->waktu_kirim->format('H:i') }}
                        @if($message->isFromProfesional())
                            (Saya)
                        @else
                            (Klien)
                        @endif
                    </small>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center text-muted py-5">
        <i class="fas fa-comments fa-2x mb-2"></i>
        <p>Belum ada pesan. Mulai percakapan dengan klien.</p>
    </div>
@endif
