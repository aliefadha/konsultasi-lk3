@extends('layouts.sbadmin')

@section('title', 'Daftar Laporan - LK3')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Laporan Kasus</h1>
        <div>
            <a href="{{ route('admin.laporan.menunggu') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-clock"></i> Laporan Menunggu
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="status">Filter berdasarkan Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="menunggu_tinjauan" {{ request('status') == 'menunggu_tinjauan' ? 'selected' : '' }}>
                                Menunggu Tinjauan
                            </option>
                            <option value="sedang_ditangani" {{ request('status') == 'sedang_ditangani' ? 'selected' : '' }}>
                                Sedang Ditangani
                            </option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                Ditolak
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
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan ({{ $laporan->total() }} laporan)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Klien</th>
                            <th>Jenis Kekerasan</th>
                            <th>Hubungan Pelaku</th>
                            <th>Status</th>
                            <th>Lampiran</th>
                            <th>Tanggal Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>
                                    <strong>{{ $report->pengguna->name ?? 'Unknown' }}</strong><br>
                                    <small class="text-muted">{{ $report->pengguna->email ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst($report->jenis_kekerasan) }}</span>
                                </td>
                                <td>{{ ucfirst(str_replace('_', ' ', $report->hubungan_pelaku)) }}</td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $report->status_laporan == 'menunggu_tinjauan' ? 'warning' : 
                                        ($report->status_laporan == 'sedang_ditangani' ? 'success' : 
                                        ($report->status_laporan == 'selesai' ? 'primary' : 'danger')) 
                                    }} badge-pill">
                                        @switch($report->status_laporan)
                                            @case('menunggu_tinjauan')
                                                Menunggu Tinjauan
                                                @break
                                            @case('sedang_ditangani')
                                                Sedang Ditangani
                                                @break
                                            @case('selesai')
                                                Selesai
                                                @break
                                            @case('ditolak')
                                                Ditolak
                                                @break
                                            @default
                                                {{ ucfirst(str_replace('_', ' ', $report->status_laporan)) }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    @if($report->lampiranLaporan && $report->lampiranLaporan->count() > 0)
                                        <span class="badge badge-info">
                                            <i class="fas fa-paperclip"></i> {{ $report->lampiranLaporan->count() }}
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            @foreach($report->lampiranLaporan->take(2) as $lampiran)
                                                <i class="fas fa-file{{ $lampiran->isImage() ? '-image' : ($lampiran->isPdf() ? '-pdf' : '') }}"></i>
                                                {{ Str::limit($lampiran->nama_file, 8) }}
                                                @if(!$loop->last)
                                                    <br>
                                                @endif
                                            @endforeach
                                            @if($report->lampiranLaporan->count() > 2)
                                                <br>
                                                <small class="text-muted">+{{ $report->lampiranLaporan->count() - 2 }}</small>
                                            @endif
                                        </small>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-times"></i> 0
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.laporan.show', $report->id) }}" 
                                       class="btn btn-primary btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                    Belum ada laporan{{ request('status') ? ' dengan status ini' : '' }}
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
@endsection