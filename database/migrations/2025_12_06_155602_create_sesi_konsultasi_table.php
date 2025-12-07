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
        Schema::create('sesi_konsultasi', function (Blueprint $table) {
             $table->id();
            $table->foreignId('laporan_kasus_id')->constrained('laporan_kasus')->onDelete('cascade');
            $table->foreignId('klien_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('profesional_id')->constrained('pengguna')->onDelete('cascade');
            $table->enum('status_sesi', ['aktif', 'selesai'])->default('aktif');
            $table->timestamp('tanggal_mulai')->useCurrent();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->text('catatan_akhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_konsultasi');
    }
};
