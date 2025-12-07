<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LaporanKasus;
use App\Models\User;

class LaporanKasusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@email.com')->first();

        LaporanKasus::create([
            'pengguna_id' => $user->id,
            'judul' => 'Kekerasan psikis dari pasangan',
            'jenis_kekerasan' => LaporanKasus::JENIS_PSIKIS,
            'hubungan_pelaku' => LaporanKasus::HUBUNGAN_PASANGAN,
            'deskripsi_kasus' => 'Pasangan saya sering menghina dan merendahkan saya di depan anak-anak. Terbaru, dia mengatakan saya bodoh dan tidak becus mengurus rumah tangga. Saya merasa tertekan dan tidak berdaya.',
            'tanggal_kejadian' => '2024-11-15',
            'status_laporan' => LaporanKasus::STATUS_MENUNGGU_TINJAUAN,
        ]);
    }
}
