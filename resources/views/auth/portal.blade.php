<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Cara Masuk - LK3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hover-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-danger">LK3 - Layanan Konsultasi</h1>
            <p class="lead text-secondary">Silakan pilih jenis akun Anda untuk masuk</p>
        </div>

        <div class="row justify-content-center g-4">
            <!-- Klien Card -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                              <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                            </svg>
                        </div>
                        <h3 class="card-title mb-3">Masyarakat / Klien</h3>
                        <p class="card-text text-secondary mb-4">Untuk pelapor atau pemohon layanan konsultasi.</p>
                        <a href="/masuk/klien" class="btn btn-primary w-100 py-2">Masuk Sebagai Klien</a>
                    </div>
                </div>
            </div>

            <!-- Profesional Card -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4 text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                              <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                              <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                            </svg>
                        </div>
                        <h3 class="card-title mb-3">Profesional</h3>
                        <p class="card-text text-secondary mb-4">Untuk konselor, psikolog, dan tenaga ahli lainnya.</p>
                        <a href="/masuk/profesional" class="btn btn-success w-100 py-2">Masuk Profesional</a>
                    </div>
                </div>
            </div>

            <!-- Admin Card -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4 text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.425-2.54 1.01-.868.733-2.326.79-2.933.376-.597-.406-2.037-.582-2.352 1.393-.11.688.196 1.157.196 1.157C.28 4.605 0 5.234 0 5.568c0 .248.067.433.1.533C.43 7.822 5.068 12.185 8 16c2.932-3.815 7.57-8.178 7.9-9.899.033-.1.1-.285.1-.533 0-.334-.28-.962-.492-1.636 0 0 .305-.47.197-1.157-.315-1.975-1.755-1.8-2.353-1.393-.607.414-2.065.357-2.933-.376C9.843.426 8.69 0 8 0zm.013 7.595a.85.85 0 0 1-.013 1.706.85.85 0 0 1-.013-1.706"/>
                            </svg>
                        </div>
                        <h3 class="card-title mb-3">Admin</h3>
                        <p class="card-text text-secondary mb-4">Untuk administrator sistem dan manajemen.</p>
                        <a href="/masuk/admin" class="btn btn-dark w-100 py-2">Masuk Admin</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="/" class="text-decoration-none text-muted">&larr; Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
