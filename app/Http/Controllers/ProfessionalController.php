<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SesiKonsultasi;
use App\Models\PesanKonsultasi;
use App\Models\LaporanKasus;

class ProfessionalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:profesional']);
    }

    /**
     * Display professional dashboard with real data.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics for dashboard
        $stats = [
            'konsultasi_aktif' => SesiKonsultasi::where('profesional_id', $user->id)
                ->where('status_sesi', SesiKonsultasi::STATUS_AKTIF)
                ->count(),
            'menunggu_respon' => SesiKonsultasi::where('profesional_id', $user->id)
                ->where('status_sesi', SesiKonsultasi::STATUS_AKTIF)
                ->whereHas('pesanKonsultasi', function($query) {
                    $query->where('jenis_pengirim', PesanKonsultasi::JENIS_PENGIRIM_KLIEN);
                })
                ->count(),
            'selesai_hari_ini' => SesiKonsultasi::where('profesional_id', $user->id)
                ->where('status_sesi', SesiKonsultasi::STATUS_SELESAI)
                ->whereDate('tanggal_selesai', today())
                ->count(),
            'total_kasus' => SesiKonsultasi::where('profesional_id', $user->id)->count(),
        ];

        // Get recent active consultations
        $recentConsultations = SesiKonsultasi::with(['klien', 'laporanKasus'])
            ->where('profesional_id', $user->id)
            ->where('status_sesi', SesiKonsultasi::STATUS_AKTIF)
            ->latest()
            ->limit(5)
            ->get();

        // Get recent messages
        $recentMessages = PesanKonsultasi::with(['sesiKonsultasi.klien'])
            ->whereHas('sesiKonsultasi', function($query) use ($user) {
                $query->where('profesional_id', $user->id);
            })
            ->where('jenis_pengirim', PesanKonsultasi::JENIS_PENGIRIM_KLIEN)
            ->latest()
            ->limit(5)
            ->get();

        return view('profesional.dashboard', compact('stats', 'recentConsultations', 'recentMessages'));
    }

    /**
     * Display list of assigned consultation sessions.
     */
    public function konsultasiIndex(Request $request)
    {
        $user = Auth::user();
        
        $query = SesiKonsultasi::with(['klien', 'laporanKasus'])
            ->where('profesional_id', $user->id);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            if ($request->status === 'aktif') {
                $query->where('status_sesi', SesiKonsultasi::STATUS_AKTIF);
            } elseif ($request->status === 'selesai') {
                $query->where('status_sesi', SesiKonsultasi::STATUS_SELESAI);
            }
        }

        $konsultasi = $query->latest()->paginate(10);

        return view('profesional.konsultasi.index', compact('konsultasi'));
    }

    /**
     * Display consultation chat room.
     */
    public function konsultasiChat(Request $request, $id)
    {
        $user = Auth::user();
        
        // Find consultation session and ensure current user is the assigned professional
        $konsultasi = SesiKonsultasi::with(['klien', 'laporanKasus', 'pesanKonsultasi.pengirim'])
            ->where('id', $id)
            ->where('profesional_id', $user->id)
            ->firstOrFail();

        // Get messages ordered by time
        $messages = $konsultasi->pesanKonsultasi()
            ->with('pengirim')
            ->ordered()
            ->get();

        if ($request->ajax()) {
            return view('profesional.konsultasi.partials.chat_messages', compact('messages'));
        }

        return view('profesional.konsultasi.chat', compact('konsultasi', 'messages'));
    }

    /**
     * Send a chat message.
     */
    public function kirimPesan(Request $request, $id)
    {
        $request->validate([
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        
        // Verify the consultation session belongs to this professional
        $konsultasi = SesiKonsultasi::where('id', $id)
            ->where('profesional_id', $user->id)
            ->firstOrFail();

        // Only allow sending messages if consultation is active
        if ($konsultasi->status_sesi !== SesiKonsultasi::STATUS_AKTIF) {
            return redirect()->back()->with('error', 'Konsultasi sudah selesai. Tidak dapat mengirim pesan.');
        }

        // Create new message
        PesanKonsultasi::create([
            'sesi_konsultasi_id' => $id,
            'pengirim_id' => $user->id,
            'isi_pesan' => $request->isi_pesan,
            'jenis_pengirim' => PesanKonsultasi::JENIS_PENGIRIM_PROFESIONAL,
            'waktu_kirim' => now(),
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
    }

    /**
     * Mark consultation as completed.
     */
    public function selesaiKonsultasi(Request $request, $id)
    {
        $request->validate([
            'catatan_akhir' => 'nullable|string|max:2000',
        ]);

        $user = Auth::user();
        
        // Verify the consultation session belongs to this professional
        $konsultasi = SesiKonsultasi::where('id', $id)
            ->where('profesional_id', $user->id)
            ->firstOrFail();

        // Check if consultation is already completed
        if ($konsultasi->status_sesi === SesiKonsultasi::STATUS_SELESAI) {
            return redirect()->back()->with('error', 'Konsultasi sudah selesai sebelumnya.');
        }

        // Mark consultation as completed
        $konsultasi->update([
            'status_sesi' => SesiKonsultasi::STATUS_SELESAI,
            'tanggal_selesai' => now(),
            'catatan_akhir' => $request->catatan_akhir,
        ]);

        // Also update the related report status
        $konsultasi->laporanKasus->update([
            'status_laporan' => 'selesai'
        ]);

        return redirect()->route('profesional.konsultasi')
            ->with('success', 'Konsultasi berhasil ditandai sebagai selesai.');
    }

    /**
     * Display consultation details (read-only view).
     */
    public function konsultasiDetail($id)
    {
        $user = Auth::user();
        
        // Find consultation session and ensure current user is the assigned professional
        $konsultasi = SesiKonsultasi::with([
                'klien',
                'laporanKasus',
                'laporanKasus.lampiranLaporan',
                'pesanKonsultasi.pengirim'
            ])
            ->where('id', $id)
            ->where('profesional_id', $user->id)
            ->firstOrFail();

        return view('profesional.konsultasi.detail', compact('konsultasi'));
    }
}
