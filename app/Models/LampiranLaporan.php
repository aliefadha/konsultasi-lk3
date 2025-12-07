<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranLaporan extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lampiran_laporan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'laporan_kasus_id', 'nama_file', 'path_file', 'tipe_file', 'ukuran_file'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ukuran_file' => 'integer',
    ];

    /**
     * Get the laporan kasus for this lampiran.
     */
    public function laporanKasus()
    {
        return $this->belongsTo(\App\Models\LaporanKasus::class, 'laporan_kasus_id');
    }

    /**
     * Get the file size in human readable format.
     */
    public function getFormattedSizeAttribute()
    {
        $size = $this->ukuran_file;
        
        if ($size >= 1048576) {
            return round($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return round($size / 1024, 2) . ' KB';
        }
        
        return $size . ' bytes';
    }

    /**
     * Get the full URL to the file.
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path_file);
    }

    /**
     * Check if the file is an image.
     */
    public function isImage()
    {
        return in_array($this->tipe_file, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    /**
     * Check if the file is a PDF.
     */
    public function isPdf()
    {
        return $this->tipe_file === 'application/pdf';
    }

    /**
     * Check if the file is a document.
     */
    public function isDocument()
    {
        $documentTypes = [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain'
        ];
        
        return in_array($this->tipe_file, $documentTypes);
    }

    /**
     * Scope for getting lampiran for a specific laporan.
     */
    public function scopeForLaporan($query, $laporanId)
    {
        return $query->where('laporan_kasus_id', $laporanId);
    }
}
