<!-- Nav Item - Laporan Kasus -->
<li class="nav-item @if(request()->routeIs('klien.laporan.*')) active @endif">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporanKlien"
        aria-expanded="true" aria-controls="collapseLaporanKlien">
        <i class="fas fa-fw fa-folder-open"></i>
        <span>Laporan Kasus</span>
    </a>
    <div id="collapseLaporanKlien" class="collapse @if(request()->routeIs('klien.laporan.*')) show @endif" aria-labelledby="headingLaporanKlien" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Laporan:</h6>
            <a class="collapse-item" href="{{ route('klien.laporan.index') }}">Daftar Laporan</a>
            <a class="collapse-item" href="{{ route('klien.laporan.create') }}">Buat Laporan Baru</a>
        </div>
    </div>
</li>

<!-- Nav Item - Konsultasi -->
<li class="nav-item @if(request()->routeIs('klien.konsultasi.*')) active @endif">
    <a class="nav-link" href="{{ route('klien.konsultasi.index') }}">
        <i class="fas fa-fw fa-comments"></i>
        <span>Konsultasi</span>
    </a>
</li>