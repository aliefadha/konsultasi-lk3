<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKasus extends Model
{
    // Status constants
    const STATUS_MENUNGGU_TINJAUAN = 'menunggu_tinjauan';
    const STATUS_SEDANG_DITANGANI = 'sedang_ditangani';
    const STATUS_SELESAI = 'selesai';

    // Jenis kekerasan constants
    const JENIS_FISIK = 'fisik';
    const JENIS_PSIKIS = 'psikis';
    const JENIS_SEKSUAL = 'seksual';
    const JENIS_EKONOMI = 'ekonomi';
    const JENIS_PENELANTARAN = 'penelantaran';
    const JENIS_LAINNYA = 'lainnya';

    // Hubungan pelaku constants
    const HUBUNGAN_PASANGAN = 'pasangan';
    const HUBUNGAN_MANTAN_PASANGAN = 'mantan_pasangan';
    const HUBUNGAN_KELUARGA = 'keluarga';
    const HUBUNGAN_TEMAN = 'teman';
    const HUBUNGAN_ATASAN = 'atasan';
    const HUBUNGAN_LAINNYA = 'lainnya';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laporan_kasus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pengguna_id', 'judul', 'jenis_kekerasan', 'hubungan_pelaku', 
        'deskripsi_kasus', 'tanggal_kejadian', 'status_laporan', 
        'catatan_admin', 'tanggal_tinjauan'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_kejadian' => 'date',
        'tanggal_tinjauan' => 'datetime',
    ];

    /**
     * Get the user who created this laporan.
     */
    public function pengguna()
    {
        return $this->belongsTo(\App\Models\User::class, 'pengguna_id');
    }

    /**
     * Get the sesi konsultasi for this laporan.
     */
    public function sesiKonsultasi()
    {
        return $this->hasOne(\App\Models\SesiKonsultasi::class, 'laporan_kasus_id');
    }

    /**
     * Get all lampiran for this laporan.
     */
    public function lampiran()
    {
        return $this->hasMany(\App\Models\LampiranLaporan::class, 'laporan_kasus_id');
    }

    /**
     * Alias for lampiran relation used across views/controllers.
     */
    public function lampiranLaporan()
    {
        return $this->hasMany(\App\Models\LampiranLaporan::class, 'laporan_kasus_id');
    }

    /**
     * Check if laporan is waiting for review.
     */
    public function isWaitingForReview()
    {
        return $this->status_laporan === self::STATUS_MENUNGGU_TINJAUAN;
    }

    /**
     * Check if laporan is being handled.
     */
    public function isBeingHandled()
    {
        return $this->status_laporan === self::STATUS_SEDANG_DITANGANI;
    }

    /**
     * Check if laporan is completed.
     */
    public function isCompleted()
    {
        return $this->status_laporan === self::STATUS_SELESAI;
    }

    /**
     * Get human readable status.
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_MENUNGGU_TINJAUAN => 'Menunggu Tinjauan',
            self::STATUS_SEDANG_DITANGANI => 'Sedang Ditangani',
            self::STATUS_SELESAI => 'Selesai',
        ];

        return $statuses[$this->status_laporan] ?? $this->status_laporan;
    }
}
