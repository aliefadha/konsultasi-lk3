@extends('layouts.sbadmin')

@section('title', 'Konsultasi Aktif - LK3')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Konsultasi Aktif</h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export PDF
            </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Konsultasi Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $konsultasiAktif->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pesan Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $todayMessages = 0;
                                    foreach($konsultasiAktif as $konsultasi) {
                                        $todayMessages += $konsultasi->pesanKonsultasi()
                                            ->whereDate('waktu_kirim', today())
                                            ->count();
                                    }
                                    echo $todayMessages;
                                @endphp
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comment-dots fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Rata-rata Durasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $avgDuration = 0;
                                    if($konsultasiAktif->count() > 0) {
                                        $totalMinutes = 0;
                                        foreach($konsultasiAktif as $konsultasi) {
                                            $duration = now()->diffInMinutes($konsultasi->tanggal_mulai);
                                            $totalMinutes += $duration;
                                        }
                                        $avgDuration = round($totalMinutes / $konsultasiAktif->count(), 1);
                                    }
                                    echo $avgDuration . ' menit';
                                @endphp
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Konsultasi Aktif</h6>
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
                            <th>Profesional</th>
                            <th>Jenis Kasus</th>
                            <th>Mulai Konsultasi</th>
                            <th>Durasi</th>
                            <th>Total Pesan</th>
                            <th>Pesan Hari Ini</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($konsultasiAktif as $index => $item)
                            @php
                                $totalMessages = $item->pesanKonsultasi()->count();
                                $todayMessages = $item->pesanKonsultasi()->whereDate('waktu_kirim', today())->count();
                                $duration = now()->diffForHumans($item->tanggal_mulai, true);
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->klien->name ?? 'Unknown' }}</strong><br>
                                    <small class="text-muted">{{ $item->klien->email ?? '' }}</small>
                                </td>
                                <td>
                                    <strong>{{ $item->profesional->name ?? 'Belum ditugaskan' }}</strong><br>
                                    <small class="text-muted">{{ $item->profesional->spesialisasi ?? '' }}</small>
                                </td>
                                <td>{{ $item->laporanKasus->jenis_kekerasan ?? 'N/A' }}</td>
                                <td>{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $duration }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $totalMessages }}</span>
                                </td>
                                <td>
                                    @if($todayMessages > 0)
                                        <span class="badge badge-success">{{ $todayMessages }}</span>
                                    @else
                                        <span class="badge badge-light">0</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        <i class="fas fa-circle" style="font-size: 8px;"></i> Aktif
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.konsultasi.show', $item->id) }}" 
                                           class="btn btn-info btn-sm" title="Detail Konsultasi">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($item->profesional)
                                            <a href="{{ route('admin.laporan-konsultasi.profesional', $item->profesional->id) }}" 
                                               class="btn btn-secondary btn-sm" title="Lihat Profesional">
                                                <i class="fas fa-user-md"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="text-muted">
                                        <i class="fas fa-comments fa-3x mb-3"></i><br>
                                        Tidak ada konsultasi aktif saat ini
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Pagination -->
                @if($konsultasiAktif instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-3">
                        {{ $konsultasiAktif->appends(request()->query())->links() }}
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