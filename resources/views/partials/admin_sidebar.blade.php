
<!-- Nav Item - Daftar Laporan -->
<li class="nav-item @if(request()->routeIs('admin.laporan.*')) active @endif">
    <a class="nav-link" href="{{ route('admin.laporan.index') }}">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Daftar Laporan</span>
    </a>
</li>

<!-- Nav Item - Profesional -->
<li class="nav-item @if(request()->routeIs('admin.profesional.*')) active @endif">
    <a class="nav-link" href="{{ route('admin.profesional.index') }}">
        <i class="fas fa-fw fa-user-md"></i>
        <span>Daftar Profesional</span>
    </a>
</li>




