<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_kasus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('judul');
            $table->enum('jenis_kekerasan', ['fisik', 'psikis', 'seksual', 'ekonomi', 'penelantaran', 'lainnya']);
            $table->enum('hubungan_pelaku', ['pasangan', 'mantan_pasangan', 'keluarga', 'teman', 'atasan', 'lainnya']);
            $table->text('deskripsi_kasus');
            $table->date('tanggal_kejadian');
            $table->enum('status_laporan', ['menunggu_tinjauan', 'sedang_ditangani', 'selesai'])->default('menunggu_tinjauan');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_tinjauan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kasus');
    }
};
