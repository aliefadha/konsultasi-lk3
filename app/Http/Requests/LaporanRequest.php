<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->role === 'klien';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();
        
        return [
            // Personal Information
            'nama_lengkap' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:pengguna,email,' . ($user ? $user->id : 'NULL'),
            'no_telepon' => 'required|string|max:20|min:10',
            'alamat' => 'required|string|max:500|min:10',
            
            // Report Information
            'judul' => 'required|string|max:255|min:5',
            'jenis_kekerasan' => 'required|in:fisik,psikis,seksual,ekonomi,penelantaran,lainnya',
            'hubungan_pelaku' => 'required|in:pasangan,mantan_pasangan,keluarga,teman,atasan,lainnya',
            'deskripsi_kasus' => 'required|string|max:2000|min:1',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'lampiran' => 'nullable|array|max:5',
            'lampiran.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,txt,xls,xlsx|max:10240',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // Personal Information Messages
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string' => 'Nama lengkap harus berupa teks.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter.',
            'nama_lengkap.min' => 'Nama lengkap minimal 2 karakter.',
            
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.string' => 'Nomor telepon harus berupa teks.',
            'no_telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'no_telepon.min' => 'Nomor telepon minimal 10 karakter.',
            
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            
            // Report Information Messages
            'judul.required' => 'Judul laporan wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'judul.min' => 'Judul minimal 5 karakter.',
            
            'jenis_kekerasan.required' => 'Jenis kekerasan wajib dipilih.',
            'jenis_kekerasan.in' => 'Jenis kekerasan yang dipilih tidak valid.',
            
            'hubungan_pelaku.required' => 'Hubungan dengan pelaku wajib dipilih.',
            'hubungan_pelaku.in' => 'Hubungan dengan pelaku yang dipilih tidak valid.',
            
            'deskripsi_kasus.required' => 'Deskripsi kasus wajib diisi.',
            'deskripsi_kasus.string' => 'Deskripsi harus berupa teks.',
            'deskripsi_kasus.max' => 'Deskripsi maksimal 2000 karakter.',
            'deskripsi_kasus.min' => 'Deskripsi minimal 1 karakter.',
            
            'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi.',
            'tanggal_kejadian.date' => 'Tanggal kejadian harus berupa tanggal yang valid.',
            'tanggal_kejadian.before_or_equal' => 'Tanggal kejadian tidak boleh lebih dari hari ini.',
            
            'lampiran.array' => 'Lampiran harus berupa daftar file.',
            'lampiran.max' => 'Maksimal 5 file lampiran yang dapat diupload.',
            'lampiran.*.file' => 'Lampiran harus berupa file.',
            'lampiran.*.mimes' => 'Lampiran harus berformat PDF, DOC, DOCX, JPG, JPEG, PNG, GIF, WEBP, TXT, XLS, atau XLSX.',
            'lampiran.*.max' => 'Ukuran lampiran maksimal 10MB.',
        ];
    }

    /**
     * Get the custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            // Personal Information
            'nama_lengkap' => 'Nama Lengkap',
            'email' => 'Email',
            'no_telepon' => 'Nomor Telepon',
            'alamat' => 'Alamat',
            
            // Report Information
            'judul' => 'Judul',
            'jenis_kekerasan' => 'Jenis Kekerasan',
            'hubungan_pelaku' => 'Hubungan dengan Pelaku',
            'deskripsi_kasus' => 'Deskripsi Kasus',
            'tanggal_kejadian' => 'Tanggal Kejadian',
            'lampiran' => 'Lampiran',
            'lampiran.*' => 'File Lampiran',
        ];
    }
}