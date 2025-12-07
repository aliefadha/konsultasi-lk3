<!-- Nav Item - Daftar Konsultasi -->
<li class="nav-item @if(request()->routeIs('profesional.konsultasi')) active @endif">
    <a class="nav-link" href="{{ route('profesional.konsultasi') }}">
        <i class="fas fa-fw fa-comments"></i>
        <span>Daftar Konsultasi</span>
    </a>
</li>
