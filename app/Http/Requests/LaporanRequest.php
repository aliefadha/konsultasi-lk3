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
        return [
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