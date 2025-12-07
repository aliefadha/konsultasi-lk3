<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Role constants
    const ROLE_KLIEN = 'klien';
    const ROLE_ADMIN = 'admin';
    const ROLE_PROFESIONAL = 'profesional';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengguna';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'no_telepon', 'alamat', 'tanggal_lahir', 'jenis_kelamin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get all laporan kasus created by this user (as klien).
     */
    public function laporanKasus()
    {
        return $this->hasMany(LaporanKasus::class, 'pengguna_id');
    }

    /**
     * Get all sesi konsultasi where this user is the klien.
     */
    public function sesiKonsultasiAsKlien()
    {
        return $this->hasMany(SesiKonsultasi::class, 'klien_id');
    }

    /**
     * Get all sesi konsultasi where this user is the profesional.
     */
    public function sesiKonsultasiAsProfesional()
    {
        return $this->hasMany(SesiKonsultasi::class, 'profesional_id');
    }

    /**
     * Get all pesan konsultasi sent by this user.
     */
    public function pesanKonsultasi()
    {
        return $this->hasMany(PesanKonsultasi::class, 'pengirim_id');
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is profesional.
     */
    public function isProfesional()
    {
        return $this->role === self::ROLE_PROFESIONAL;
    }

    /**
     * Check if user is klien.
     */
    public function isKlien()
    {
        return $this->role === self::ROLE_KLIEN;
    }
}
