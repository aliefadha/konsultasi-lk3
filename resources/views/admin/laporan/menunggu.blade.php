@extends('layouts.sbadmin')

@section('title', 'Laporan Menunggu Tinjauan - LK3')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-clock text-warning"></i> Laporan Menunggu Tinjauan
        </h1>
        <div>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Semua Laporan
            </a>
        </div>
    </div>

    <!-- Alert for urgent cases -->
    @if($laporan->count() > 0)
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>{{ $laporan->count() }} laporan</strong> menunggu tinjauan Anda. Harap tinjau secepatnya.
        </div>
    @endif

    <!-- Reports Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-warning">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-clock"></i> Daftar Laporan Menunggu Tinjauan ({{ $laporan->total() }} laporan)
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Priority</th>
                            <th>ID</th>
                            <th>Klien</th>
                            <th>Jenis Kekerasan</th>
                            <th>Hubungan Pelaku</th>
                            <th>Tanggal Kejadian</th>
                            <th>Waktu Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $report)
                            <tr class="{{ now()->diffInDays($report->created_at) > 3 ? 'table-warning' : '' }}">
                                <td class="text-center">
                                    @if(now()->diffInDays($report->created_at) > 7)
                                        <span class="badge badge-danger">URGENT</span>
                                    @elseif(now()->diffInDays($report->created_at) > 3)
                                        <span class="badge badge-warning">HIGH</span>
                                    @else
                                        <span class="badge badge-info">NEW</span>
                                    @endif
                                </td>
                                <td><strong>#{{ $report->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($report->pengguna->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $report->pengguna->name ?? 'Unknown' }}</strong><br>
                                            <small class="text-muted">{{ $report->pengguna->email ?? '' }}</small><br>
                                            <small class="text-muted">{{ $report->pengguna->no_telepon ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-danger badge-lg">{{ ucfirst($report->jenis_kekerasan) }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $report->hubungan_pelaku)) }}</span>
                                </td>
                                <td>
                                    @if($report->tanggal_kejadian)
                                        {{ $report->tanggal_kejadian->format('d/m/Y') }}<br>
                                        <small class="text-muted">{{ $report->tanggal_kejadian->diffForHumans() }}</small>
                                    @else
                                        <span class="text-muted">Tidak disebutkan</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $report->created_at->format('d/m/Y') }}</strong><br>
                                    <small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.laporan.show', $report->id) }}" 
                                           class="btn btn-primary btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i> Tinjau
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="text-muted py-5">
                                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i><br>
                                        <h5>Semua laporan sudah ditinjau!</h5>
                                        <p>Tidak ada laporan yang menunggu tinjauan saat ini.</p>
                                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-primary">
                                            <i class="fas fa-list"></i> Lihat Semua Laporan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($laporan->hasPages())
                <div class="mt-4">
                    {{ $laporan->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    @if($laporan->count() > 0)
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.profesional.index') }}" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-user-md"></i> Lihat Daftar Profesional
                        </a>

                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-list"></i> Lihat Semua Laporan
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border-right">
                                    <div class="h4 mb-0 text-warning">{{ $laporan->where('jenis_kekerasan', 'fisik')->count() }}</div>
                                    <small class="text-muted">Kekerasan Fisik</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-right">
                                    <div class="h4 mb-0 text-info">{{ $laporan->where('jenis_kekerasan', 'psikis')->count() }}</div>
                                    <small class="text-muted">Kekerasan Psikis</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="h4 mb-0 text-danger">{{ $laporan->where('jenis_kekerasan', 'seksual')->count() }}</div>
                                <small class="text-muted">Kekerasan Seksual</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection