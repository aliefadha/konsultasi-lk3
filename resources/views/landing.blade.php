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
            <a class="navbar-brand fw-bold" href="/">Pelayanan Konsultasi KDRT</a>
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
                    <h2 class="mb-4">Apa itu KDRT?</h2>
                    <p class="text-secondary" style="font-size: 1.1rem; line-height: 1.8;">
                        Kekerasan Dalam Rumah Tangga (KDRT) adalah setiap perbuatan terhadap seseorang terutama perempuan, yang berakibat timbulnya kesengsaraan atau penderitaan secara fisik, seksual, psikologis, dan/atau penelantaran rumah tangga termasuk ancaman untuk melakukan perbuatan, pemaksaan, atau perampasan kemerdekaan secara melawan hukum dalam lingkup rumah tangga.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="card bg-danger text-white border-0 shadow">
                        <div class="card-body p-5">
                            <h3>Anda Tidak Sendirian</h3>
                            <p class="mb-4">Hukum melindungi Anda. UU No. 23 Tahun 2004 tentang Penghapusan KDRT menjamin perlindungan bagi korban.</p>
                            <a href="/daftar" class="btn btn-light text-danger fw-bold w-100">Cari Bantuan Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
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
