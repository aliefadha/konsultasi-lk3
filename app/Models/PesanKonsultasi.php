<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanKonsultasi extends Model
{
      // Jenis pengirim constants
    const JENIS_PENGIRIM_KLIEN = 'klien';
    const JENIS_PENGIRIM_PROFESIONAL = 'profesional';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pesan_konsultasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sesi_konsultasi_id', 'pengirim_id', 'isi_pesan', 'jenis_pengirim', 'waktu_kirim'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'waktu_kirim' => 'datetime',
    ];

    /**
     * Get the sesi konsultasi for this pesan.
     */
    public function sesiKonsultasi()
    {
        return $this->belongsTo(\App\Models\SesiKonsultasi::class, 'sesi_konsultasi_id');
    }

    /**
     * Get the pengirim user for this pesan.
     */
    public function pengirim()
    {
        return $this->belongsTo(\App\Models\User::class, 'pengirim_id');
    }

    /**
     * Check if this message is from the klien.
     */
    public function isFromKlien()
    {
        return $this->jenis_pengirim === self::JENIS_PENGIRIM_KLIEN;
    }

    /**
     * Check if this message is from the profesional.
     */
    public function isFromProfesional()
    {
        return $this->jenis_pengirim === self::JENIS_PENGIRIM_PROFESIONAL;
    }

    /**
     * Scope for getting messages for a specific sesi.
     */
    public function scopeForSesi($query, $sesiId)
    {
        return $query->where('sesi_konsultasi_id', $sesiId);
    }

    /**
     * Scope for getting messages ordered by time.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('waktu_kirim', 'asc');
    }
}
