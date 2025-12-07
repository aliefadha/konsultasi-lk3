<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiKonsultasi extends Model
{
     // Status constants
    const STATUS_AKTIF = 'aktif';
    const STATUS_SELESAI = 'selesai';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sesi_konsultasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'laporan_kasus_id', 'klien_id', 'profesional_id', 'status_sesi', 
        'tanggal_mulai', 'tanggal_selesai', 'catatan_akhir'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Get the laporan kasus for this sesi.
     */
    public function laporanKasus()
    {
        return $this->belongsTo(\App\Models\LaporanKasus::class, 'laporan_kasus_id');
    }

    /**
     * Get the klien user for this sesi.
     */
    public function klien()
    {
        return $this->belongsTo(\App\Models\User::class, 'klien_id');
    }

    /**
     * Get the profesional user for this sesi.
     */
    public function profesional()
    {
        return $this->belongsTo(User::class, 'profesional_id');
    }

    /**
     * Get all pesan konsultasi for this sesi.
     */
    public function pesanKonsultasi()
    {
        return $this->hasMany(PesanKonsultasi::class, 'sesi_konsultasi_id');
    }

    /**
     * Check if sesi is active.
     */
    public function isActive()
    {
        return $this->status_sesi === self::STATUS_AKTIF;
    }

    /**
     * Check if sesi is completed.
     */
    public function isCompleted()
    {
        return $this->status_sesi === self::STATUS_SELESAI;
    }

    /**
     * Mark sesi as completed.
     */
    public function markAsCompleted($catatanAkhir = null)
    {
        $this->status_sesi = self::STATUS_SELESAI;
        $this->tanggal_selesai = now();
        if ($catatanAkhir) {
            $this->catatan_akhir = $catatanAkhir;
        }
        $this->save();
    }
}
