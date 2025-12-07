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
        Schema::create('pesan_konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_konsultasi_id')->constrained('sesi_konsultasi')->onDelete('cascade');
            $table->foreignId('pengirim_id')->constrained('pengguna')->onDelete('cascade');
            $table->text('isi_pesan');
            $table->enum('jenis_pengirim', ['klien', 'profesional']);
            $table->timestamp('waktu_kirim')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_konsultasi');
    }
};
