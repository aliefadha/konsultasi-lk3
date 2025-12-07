@extends('layouts.sbadmin')

@section('title', 'Daftar Konsultasi - LK3')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Sesi Konsultasi</h1>
        <div>
            <a href="{{ route('admin.laporan-konsultasi.aktif') }}" class="btn btn-success btn-sm">
                <i class="fas fa-clock"></i> Konsultasi Aktif
            </a>
            <a href="{{ route('admin.laporan-konsultasi.selesai') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-check"></i> Konsultasi Selesai
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Konsultasi</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.konsultasi.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="status">Filter berdasarkan Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Consultations Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Sesi Konsultasi ({{ $konsultasi->total() }} sesi)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Klien</th>
                            <th>Profesional</th>
                            <th>Laporan Kasus</th>
                            <th>Status</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($konsultasi as $sesi)
                            <tr>
                                <td>{{ $sesi->id }}</td>
                                <td>
                                    <strong>{{ $sesi->klien->name ?? 'Unknown' }}</strong><br>
                                    <small class="text-muted">{{ $sesi->klien->email ?? '' }}</small>
                                </td>
                                <td>
                                    @if($sesi->profesional)
                                        <strong>{{ $sesi->profesional->name }}</strong><br>
                                        <small class="text-muted">{{ $sesi->profesional->spesialisasi ?? '' }}</small>
                                    @else
                                        <span class="text-muted">Belum ditugaskan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sesi->laporanKasus)
                                        <span class="badge badge-info">Laporan #{{ $sesi->laporanKasus->id }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $sesi->status_sesi == 'aktif' ? 'success' : 
                                        ($sesi->status_sesi == 'selesai' ? 'primary' : 'danger') 
                                    }} badge-pill">
                                        @switch($sesi->status_sesi)
                                            @case('aktif')
                                                Aktif
                                                @break
                                            @case('selesai')
                                                Selesai
                                                @break
                                            @case('dibatalkan')
                                                Dibatalkan
                                                @break
                                            @default
                                                {{ ucfirst($sesi->status_sesi) }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>{{ $sesi->tanggal_mulai ? $sesi->tanggal_mulai->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $sesi->tanggal_selesai ? $sesi->tanggal_selesai->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.konsultasi.show', $sesi->id) }}" 
                                       class="btn btn-primary btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                    Belum ada sesi konsultasi{{ request('status') ? ' dengan status ini' : '' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($konsultasi->hasPages())
                <div class="mt-4">
                    {{ $konsultasi->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection