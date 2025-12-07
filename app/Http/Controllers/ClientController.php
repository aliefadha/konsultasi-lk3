<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasus;
use App\Models\SesiKonsultasi;
use App\Models\LampiranLaporan;
use App\Http\Requests\LaporanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:klien');
    }

    /**
     * Display the client dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's reports with statistics
        $totalReports = LaporanKasus::where('pengguna_id', $user->id)->count();
        $pendingReports = LaporanKasus::where('pengguna_id', $user->id)
            ->where('status_laporan', 'menunggu_tinjauan')->count();
        $activeConsultations = SesiKonsultasi::where('klien_id', $user->id)
            ->where('status_sesi', 'aktif')->count();
        $completedConsultations = SesiKonsultasi::where('klien_id', $user->id)
            ->where('status_sesi', 'selesai')->count();

        // Get recent reports
        $recentReports = LaporanKasus::where('pengguna_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        // Get active consultation if any
        $activeConsultation = SesiKonsultasi::where('klien_id', $user->id)
            ->where('status_sesi', 'aktif')
            ->with('profesional')
            ->first();

        return view('klien.dashboard', compact(
            'totalReports', 
            'pendingReports', 
            'activeConsultations', 
            'completedConsultations',
            'recentReports',
            'activeConsultation'
        ));
    }

    /**
     * Display a listing of user's reports
     */
    public function laporanIndex()
    {
        $user = Auth::user();
        $laporans = LaporanKasus::where('pengguna_id', $user->id)
            ->with('lampiranLaporan')
            ->latest()
            ->paginate(10);

        return view('klien.laporan.index', compact('laporans'));
    }

    /**
     * Show the form for creating a new report
     */
    public function laporanCreate()
    {
        return view('klien.laporan.create');
    }

    /**
     * Store a newly created report
     */
    public function laporanStore(LaporanRequest $request)
    {
        $user = Auth::user();
        
        // Create the laporan record
        $laporan = LaporanKasus::create([
            'pengguna_id' => $user->id,
            'judul' => $request->judul,
            'jenis_kekerasan' => $request->jenis_kekerasan,
            'hubungan_pelaku' => $request->hubungan_pelaku,
            'deskripsi_kasus' => $request->deskripsi_kasus,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'status_laporan' => 'menunggu_tinjauan',
        ]);

        // Handle file uploads for lampiran
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                // Store the file in the public storage
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('lampiran-laporan', $fileName, 'public');
                
                // Create lampiran record
                LampiranLaporan::create([
                    'laporan_kasus_id' => $laporan->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $filePath,
                    'tipe_file' => $file->getMimeType(),
                    'ukuran_file' => $file->getSize(),
                ]);
            }
        }

        $successMessage = 'Laporan berhasil dibuat dan sedang menunggu tinjauan dari tim LK3.';
        
        // Add information about lampiran if any were uploaded
        if ($request->hasFile('lampiran')) {
            $fileCount = count($request->file('lampiran'));
            $successMessage .= " {$fileCount} file lampiran berhasil diupload.";
        }

        return redirect('/klien/laporan-saya')
            ->with('success', $successMessage);
    }

    /**
     * Display the specified report
     */
    public function laporanShow($id)
    {
        $user = Auth::user();
        $laporan = LaporanKasus::where('pengguna_id', $user->id)
            ->with(['sesiKonsultasi.profesional', 'lampiranLaporan'])
            ->findOrFail($id);

        return view('klien.laporan.show', compact('laporan'));
    }

    /**
     * Display user's consultations
     */
    public function konsultasiIndex()
    {
        $user = Auth::user();
        $konsultasis = SesiKonsultasi::where('klien_id', $user->id)
            ->with('profesional')
            ->latest()
            ->paginate(10);

        return view('klien.konsultasi.index', compact('konsultasis'));
    }

    /**
     * Show the consultation chat interface
     */
    public function konsultasiChat($id)
    {
        $user = Auth::user();
        $konsultasi = SesiKonsultasi::where('klien_id', $user->id)
            ->with([
                'profesional',
                'laporanKasus',
                'pesanKonsultasi' => function($query) {
                    $query->with('pengirim')
                        ->orderBy('created_at', 'asc');
                }
            ])
            ->findOrFail($id);

        return view('klien.konsultasi.chat', compact('konsultasi'));
    }

    /**
     * Send a message in the consultation
     */
    public function konsultasiSendMessage(Request $request, $id)
    {
        $request->validate([
            'isi_pesan' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $konsultasi = SesiKonsultasi::where('klien_id', $user->id)->findOrFail($id);

        $konsultasi->pesanKonsultasi()->create([
            'pengirim_id' => $user->id,
            'isi_pesan' => $request->isi_pesan,
            'jenis_pengirim' => 'klien'
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}
