@extends('layouts.sbadmin')

@section('title', 'Laporan Konsultasi Profesional - LK3')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Konsultasi - {{ $profesional->name }}</h1>
        <div>
            <a href="{{ route('admin.profesional.show', $profesional->id) }}" class="btn btn-info">
                <i class="fas fa-user-md"></i> Profil Profesional
            </a>
            <a href="{{ route('admin.laporan-konsultasi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Profesional Info Card -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Konsultasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $konsultasi->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Konsultasi - {{ $profesional->name }}</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan-konsultasi.profesional', $profesional->id) }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status Konsultasi</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.laporan-konsultasi.profesional', $profesional->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Riwayat Konsultasi - {{ $profesional->name }}
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Opsi Export:</div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-file-pdf text-danger"></i> Export PDF
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-file-excel text-success"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Klien</th>
                            <th>Jenis Kasus</th>
                            <th>Status</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($konsultasi as $index => $item)
                            @php
                                $totalMessages = $item->pesanKonsultasi()->count();
                                $duration = $item->tanggal_selesai && $item->tanggal_mulai 
                                    ? $item->tanggal_selesai->diffForHumans($item->tanggal_mulai, true) 
                                    : ($item->tanggal_mulai ? now()->diffForHumans($item->tanggal_mulai, true) : '-');
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->klien->name ?? 'Unknown' }}</strong><br>
                                    <small class="text-muted">{{ $item->klien->email ?? '' }}</small>
                                </td>
                                <td>{{ $item->laporanKasus->jenis_kekerasan ?? 'N/A' }}</td>
                                <td>
                                    @if($item->status_sesi == 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif($item->status_sesi == 'selesai')
                                        <span class="badge badge-secondary">Selesai</span>
                                    @else
                                        <span class="badge badge-warning">{{ ucfirst($item->status_sesi) }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.konsultasi.show', $item->id) }}" 
                                       class="btn btn-info btn-sm" title="Detail Konsultasi">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="text-muted">
                                        <i class="fas fa-user-md fa-3x mb-3"></i><br>
                                        Belum ada konsultasi untuk profesional ini
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Pagination -->
                @if($konsultasi instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-3">
                        {{ $konsultasi->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 25,
                "order": [[ 4, "desc" ]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });
    </script>
@endsection