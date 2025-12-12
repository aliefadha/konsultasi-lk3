<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi & Pengaduan KDRT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background-color: #f8f9fa;
            padding: 5rem 0;
        }
        .hero-title {
            font-weight: 700;
            color: #dc3545;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Pelayanan LK3</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Masuk
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/masuk/klien">Sebagai Klien</a></li>
                            <li><a class="dropdown-item" href="/masuk/profesional">Sebagai Profesional</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/masuk/admin">Sebagai Admin</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-danger px-4 ms-2" href="/daftar">Daftar / Lapor</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-4">Apa itu LK3?</h2>
                    <p class="text-secondary" style="font-size: 1.1rem; line-height: 1.8;">
                        LK3 (Lembaga Konsultasi Kesejahteraan Keluarga) adalah lembaga layanan sosial yang berada di bawah Dinas Sosial yang berfungsi memberikan konsultasi, pendampingan, perlindungan, dan solusi terhadap berbagai permasalahan keluarga serta masalah sosial di masyarakat.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="card bg-danger text-white border-0 shadow">
                        <div class="card-body p-5">
                            <h3>Bantuan pelayanan</h3>
                            <p class="mb-4">Hukum melindungi Anda. UU No. 23 Tahun 2004 tentang Penghapusan KDRT menjamin perlindungan bagi korban.</p>
                            <a href="/daftar" class="btn btn-light text-danger fw-bold w-100">Lapor Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tujuan LK3 Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Tujuan LK3</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-danger mb-3">Meningkatkan Kesejahteraan</h5>
                            <p class="card-text small text-secondary">Membantu keluarga mencapai kondisi sosial, ekonomi, dan psikologis yang lebih baik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-danger mb-3">Mencegah Masalah Sosial</h5>
                            <p class="card-text small text-secondary">Menangani konflik rumah tangga, kekerasan, masalah anak, dan hubungan antar keluarga.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-danger mb-3">Dukungan Psikososial</h5>
                            <p class="card-text small text-secondary">LK3 memberikan layanan konseling dan pendampingan kepada keluarga maupun individu.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-danger mb-3">Perlindungan Kelompok Rentan</h5>
                            <p class="card-text small text-secondary">Melindungi anak terlantar, lansia, korban kekerasan, penyandang disabilitas, dll.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fungsi LK3 Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fungsi LK3</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-danger rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">1</span>
                                <h5 class="card-title mb-0">Konsultasi Keluarga</h5>
                            </div>
                            <p class="card-text text-secondary mb-3">Membantu keluarga mengatasi:</p>
                            <ul class="text-secondary small ps-3">
                                <li>Konflik rumah tangga</li>
                                <li>Masalah komunikasi</li>
                                <li>Perceraian atau perselisihan</li>
                                <li>Masalah anak atau remaja</li>
                                <li>Kesehatan mental keluarga</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-danger rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">2</span>
                                <h5 class="card-title mb-0">Layanan Pengaduan</h5>
                            </div>
                            <p class="card-text text-secondary mb-3">Menerima aduan mengenai:</p>
                            <ul class="text-secondary small ps-3">
                                <li>KDRT</li>
                                <li>Anak terlantar</li>
                                <li>Lansia terlantar</li>
                                <li>Masalah sosial lainnya</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-danger rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">3</span>
                                <h5 class="card-title mb-0">Mediasi Konflik</h5>
                            </div>
                            <p class="card-text text-secondary">LK3 dapat menjadi pihak penengah untuk menyelesaikan konflik secara damai dan kekeluargaan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-danger rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">4</span>
                                <h5 class="card-title mb-0">Pendampingan Psikososial</h5>
                            </div>
                            <p class="card-text text-secondary mb-3">Terutama untuk:</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border">Korban kekerasan</span>
                                <span class="badge bg-light text-dark border">Korban bullying</span>
                                <span class="badge bg-light text-dark border">Korban bencana sosial</span>
                                <span class="badge bg-light text-dark border">Penerima manfaat Dinsos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-danger rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">5</span>
                                <h5 class="card-title mb-0">Rujukan Layanan</h5>
                            </div>
                            <p class="card-text text-secondary mb-3">Rujukan penanganan khusus ke:</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border">Psikolog / psikiater</span>
                                <span class="badge bg-light text-dark border">Pusat layanan terpadu</span>
                                <span class="badge bg-light text-dark border">Rumah sakit</span>
                                <span class="badge bg-light text-dark border">Kepolisian</span>
                                <span class="badge bg-light text-dark border">Lembaga sosial lain</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jenis Permasalahan Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Jenis Permasalahan yang Ditangani</h2>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Kekerasan dalam rumah tangga (KDRT)</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Anak berhadapan dengan hukum</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Anak putus sekolah</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Lansia terlantar</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Konseling pra-nikah</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Konseling pasca perceraian</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Perselisihan keluarga</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Pengasuhan anak</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Masalah adiksi</span>
                        <span class="px-4 py-2 bg-white rounded-pill shadow-sm text-secondary border">Masalah sosial masyarakat</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Bentuk-Bentuk Kekerasan</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-person-x-fill" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </div>
                            <h5 class="card-title">Kekerasan Fisik</h5>
                            <p class="card-text small text-secondary">Perbuatan yang mengakibatkan rasa sakit, jatuh sakit, atau luka berat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-heartbreak-fill" viewBox="0 0 16 16">
                                  <path d="M8.931.586 7 3l1.5 4-2 3L8 15C22.534 5.396 13.757-2.21 8.931.586M7.358.77 5.5 3 7 7l-1.5 3 1.815 4.537C-6.533 4.96 2.685-2.467 7.358.77"/>
                                </svg>
                            </div>
                            <h5 class="card-title">Kekerasan Psikis</h5>
                            <p class="card-text small text-secondary">Perbuatan yang mengakibatkan ketakutan, hilangnya rasa percaya diri, atau penderitaan psikis berat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                                  <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                            </div>
                            <h5 class="card-title">Kekerasan Seksual</h5>
                            <p class="card-text small text-secondary">Pemaksaan hubungan seksual terhadap orang yang menetap dalam lingkup rumah tangga.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3 text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-house-slash-fill" viewBox="0 0 16 16">
                                  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                                  <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                                  <path d="M13.528 12.028a3.488 3.488 0 0 0 1.096-1.558l-1.575-.54a2 2 0 0 1-.72 1.026zM15 13.5a.5.5 0 0 1-1 0 .5.5 0 0 1 1 0"/>
                                  <path d="M12.441 12.871a2 2 0 0 1-1.026.72l.541 1.575a3.49 3.49 0 0 0 1.558-1.096z"/>
                                </svg>
                            </div>
                            <h5 class="card-title">Penelantaran</h5>
                            <p class="card-text small text-secondary">Tidak memberikan kehidupan, perawatan, atau pemeliharaan kepada orang yang menjadi tanggung jawabnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-2">Layanan Konsultasi & Pengaduan KDRT</p>
            <p class="small text-secondary mb-0">&copy; {{ date('Y') }}. Dilindungi Undang-Undang.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
