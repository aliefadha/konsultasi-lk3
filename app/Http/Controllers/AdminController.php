<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanKasus;
use App\Models\SesiKonsultasi;
use App\Models\User;

class AdminController extends Controller
{
     public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        // Get statistics for dashboard
        $stats = [
            'total_laporan' => LaporanKasus::count(),
            'menunggu_tinjauan' => LaporanKasus::where('status_laporan', 'menunggu_tinjauan')->count(),
            'konsultasi_aktif' => SesiKonsultasi::where('status_sesi', SesiKonsultasi::STATUS_AKTIF)->count(),
            'profesional_aktif' => User::where('role', User::ROLE_PROFESIONAL)->count(),
        ];

        // Get recent reports
        $recentReports = LaporanKasus::with('pengguna')
            ->latest()
            ->limit(5)
            ->get();

        // Get recent consultations
        $recentConsultations = SesiKonsultasi::with(['klien', 'profesional'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'recentConsultations'));
    }

    /**
     * Display list of all reports.
     */
    public function laporanIndex(Request $request)
    {
        $query = LaporanKasus::with(['pengguna', 'lampiranLaporan']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status_laporan', $request->status);
        }

        $laporan = $query->latest()->paginate(10);

        return view('admin.laporan.index', compact('laporan'));
    }


    /**
     * Display details of a specific report.
     */
    public function laporanShow($id)
    {
        $laporan = LaporanKasus::with(['pengguna', 'sesiKonsultasi.profesional', 'lampiranLaporan'])
            ->findOrFail($id);

        return view('admin.laporan.show', compact('laporan'));
    }

    /**
     * Show form to edit report.
     */
    public function laporanEdit($id)
    {
        $laporan = LaporanKasus::findOrFail($id);
        return view('admin.laporan.edit', compact('laporan'));
    }

    /**
     * Update report information.
     */
    public function laporanUpdate(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_kekerasan' => 'required|in:fisik,psikis,seksual,ekonomi,penelantaran,lainnya',
            'hubungan_pelaku' => 'required|string',
            'tanggal_kejadian' => 'nullable|date',
            'deskripsi_kasus' => 'required|string',
        ]);

        $laporan = LaporanKasus::findOrFail($id);
        
        $laporan->update([
            'judul' => $request->judul,
            'jenis_kekerasan' => $request->jenis_kekerasan,
            'hubungan_pelaku' => $request->hubungan_pelaku,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'deskripsi_kasus' => $request->deskripsi_kasus,
        ]);

        return redirect()->route('admin.laporan.show', $id)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Delete report.
     */
    public function laporanDestroy($id)
    {
        $laporan = LaporanKasus::findOrFail($id);
        
        // Delete related consultation session and attachments if handled by foreign key cascade in DB or manually here.
        // Assuming standard Laravel cascade or manual manual deletion if needed.
        // For safety, let's delete them if they exist and are not cascade:
        if ($laporan->sesiKonsultasi) {
            $laporan->sesiKonsultasi->delete();
        }
        
        // Delete attachments files from storage would be good but for now just record deletion
        foreach ($laporan->lampiranLaporan as $lampiran) {
             // Ideally we should delete file from storage: Storage::delete($lampiran->path);
             $lampiran->delete();
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Update report status.
     */
    public function laporanUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status_laporan' => 'required|in:menunggu_tinjauan,sedang_ditangani,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $laporan = LaporanKasus::findOrFail($id);
        $laporan->update([
            'status_laporan' => $request->status_laporan,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.laporan.show', $id)
            ->with('success', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Display list of all consultations.
     */
    public function konsultasiIndex(Request $request)
    {
        $query = SesiKonsultasi::with(['klien', 'profesional', 'laporanKasus']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status_sesi', $request->status);
        }

        $konsultasi = $query->latest()->paginate(10);

        return view('admin.konsultasi.index', compact('konsultasi'));
    }

    /**
     * Display consultation details.
     */
    public function konsultasiShow($id)
    {
        $konsultasi = SesiKonsultasi::with(['klien', 'profesional', 'laporanKasus', 'pesanKonsultasi'])
            ->findOrFail($id);

        return view('admin.konsultasi.show', compact('konsultasi'));
    }

    /**
     * Display list of all professionals.
     */
    public function profesionalIndex()
    {
        $profesional = User::where('role', User::ROLE_PROFESIONAL)
            ->withCount(['sesiKonsultasiAsProfesional as total_konsultasi'])
            ->latest()
            ->paginate(10);

        return view('admin.profesional.index', compact('profesional'));
    }

    /**
     * Show form to create new professional.
     */
    public function profesionalCreate()
    {
        return view('admin.profesional.create');
    }

    /**
     * Store new professional.
     */
    public function profesionalStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'password' => 'required|string|min:6|confirmed',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
        ]);

        $profesional = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => User::ROLE_PROFESIONAL,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.profesional.index')
            ->with('success', 'Profesional berhasil ditambahkan.');
    }

    /**
     * Display professional details.
     */
    public function profesionalShow($id)
    {
        $profesional = User::where('role', User::ROLE_PROFESIONAL)
            ->withCount(['sesiKonsultasiAsProfesional as total_konsultasi'])
            ->findOrFail($id);

        // Get active consultations count separately
        $profesional->konsultasi_aktif = SesiKonsultasi::where('profesional_id', $id)
            ->where('status_sesi', SesiKonsultasi::STATUS_AKTIF)
            ->count();

        return view('admin.profesional.show', compact('profesional'));
    }

    /**
     * Update professional status.
     */
    public function profesionalUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $profesional = User::where('role', User::ROLE_PROFESIONAL)->findOrFail($id);
        $profesional->update(['status' => $request->status]);

        return redirect()->route('admin.profesional.show', $id)
            ->with('success', 'Status profesional berhasil diperbarui.');
    }

    /**
     * Display list of professionals waiting for approval.
     */
    public function profesionalMenunggu()
    {
        $profesional = User::where('role', User::ROLE_PROFESIONAL)
            ->where('status', 'menunggu_tinjauan')
            ->latest()
            ->paginate(10);

        return view('admin.profesional.menunggu', compact('profesional'));
    }

    /**
     * Show form to edit professional.
     */
    public function profesionalEdit($id)
    {
        $profesional = User::where('role', User::ROLE_PROFESIONAL)->findOrFail($id);
        
        return view('admin.profesional.edit', compact('profesional'));
    }

    /**
     * Update professional information.
     */
    public function profesionalUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna,email,' . $id,
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
        ]);

        $profesional = User::where('role', User::ROLE_PROFESIONAL)->findOrFail($id);
        
        $profesional->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('admin.profesional.show', $id)
            ->with('success', 'Data profesional berhasil diperbarui.');
    }

    /**
     * Delete professional.
     */
    public function profesionalDestroy($id)
    {
        $profesional = User::where('role', User::ROLE_PROFESIONAL)->findOrFail($id);
        
        // Check if professional has active consultations
        $activeConsultations = SesiKonsultasi::where('profesional_id', $id)
            ->where('status_sesi', SesiKonsultasi::STATUS_AKTIF)
            ->count();
        
        if ($activeConsultations > 0) {
            return redirect()->route('admin.profesional.index')
                ->with('error', 'Tidak dapat menghapus profesional yang memiliki konsultasi aktif.');
        }
        
        $profesional->delete();
        
        return redirect()->route('admin.profesional.index')
            ->with('success', 'Profesional berhasil dihapus.');
    }

    /**
     * Display pending reports for assignment.
     */
    public function laporanMenunggu()
    {
        $laporan = LaporanKasus::with('pengguna')
            ->where('status_laporan', 'menunggu_tinjauan')
            ->latest()
            ->paginate(10);

        return view('admin.laporan.menunggu', compact('laporan'));
    }

    /**
     * Assign professional to a report.
     */
    public function assignProfesional(Request $request, $laporanId)
    {
        $request->validate([
            'profesional_id' => 'required|exists:pengguna,id,role,' . User::ROLE_PROFESIONAL,
        ]);

        $laporan = LaporanKasus::findOrFail($laporanId);
        
        // Check if consultation session already exists
        $sesiKonsultasi = SesiKonsultasi::where('laporan_kasus_id', $laporanId)->first();
        
        if (!$sesiKonsultasi) {
            // Create new consultation session
            $sesiKonsultasi = SesiKonsultasi::create([
                'laporan_kasus_id' => $laporanId,
                'klien_id' => $laporan->pengguna_id,
                'profesional_id' => $request->profesional_id,
                'status_sesi' => SesiKonsultasi::STATUS_AKTIF,
                'tanggal_mulai' => now(),
            ]);
        } else {
            // Update existing session
            $sesiKonsultasi->update([
                'profesional_id' => $request->profesional_id,
                'status_sesi' => SesiKonsultasi::STATUS_AKTIF,
            ]);
        }

        // Update report status
        $laporan->update(['status_laporan' => 'sedang_ditangani']);

        return redirect()->route('admin.laporan.show', $laporanId)
            ->with('success', 'Profesional berhasil ditugaskan ke laporan ini.');
    }

    /**
     * Display list of consultation reports.
     */
    public function laporanKonsultasiIndex(Request $request)
    {
        $query = SesiKonsultasi::with(['klien', 'profesional', 'laporanKasus']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status_sesi', $request->status);
        }

        $konsultasi = $query->latest()->paginate(10);

        return view('admin.laporan-konsultasi.index', compact('konsultasi'));
    }

    /**
     * Display active consultation reports.
     */
    public function laporanKonsultasiAktif(Request $request)
    {
        $query = SesiKonsultasi::with(['klien', 'profesional', 'laporanKasus'])
            ->where('status_sesi', SesiKonsultasi::STATUS_AKTIF);
        
        // Filter by professional if provided
        if ($request->has('profesional_id') && $request->profesional_id) {
            $query->where('profesional_id', $request->profesional_id);
        }

        $konsultasi = $query->latest()->paginate(10);

        return view('admin.laporan-konsultasi.aktif', compact('konsultasi'));
    }

    /**
     * Display completed consultation reports.
     */
    public function laporanKonsultasiSelesai(Request $request)
    {
        $query = SesiKonsultasi::with(['klien', 'profesional', 'laporanKasus'])
            ->where('status_sesi', SesiKonsultasi::STATUS_SELESAI);
        
        // Filter by professional if provided
        if ($request->has('profesional_id') && $request->profesional_id) {
            $query->where('profesional_id', $request->profesional_id);
        }

        $konsultasi = $query->latest()->paginate(10);

        return view('admin.laporan-konsultasi.selesai', compact('konsultasi'));
    }

    /**
     * Display consultation reports for a specific professional.
     */
    public function laporanKonsultasiProfesional(Request $request, $id)
    {
        $profesional = User::where('role', User::ROLE_PROFESIONAL)->findOrFail($id);
        
        $query = SesiKonsultasi::with(['klien', 'profesional', 'laporanKasus'])
            ->where('profesional_id', $id);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status_sesi', $request->status);
        }

        $konsultasi = $query->latest()->paginate(10);

        return view('admin.laporan-konsultasi.profesional', compact('profesional', 'konsultasi'));
    }
}
