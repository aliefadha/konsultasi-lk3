@extends('layouts.sbadmin')

@section('title', 'Konsultasi Selesai - LK3')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Konsultasi Selesai</h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export PDF
            </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan Selesai</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan-konsultasi.selesai') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Selesai Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.laporan-konsultasi.selesai') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $konsultasiSelesai->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pesan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $totalMessages = 0;
                                    foreach($konsultasiSelesai as $konsultasi) {
                                        $totalMessages += $konsultasi->pesanKonsultasi()->count();
                                    }
                                    echo $totalMessages;
                                @endphp
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Rata-rata Durasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $avgDuration = 0;
                                    if($konsultasiSelesai->count() > 0) {
                                        $totalMinutes = 0;
                                        foreach($konsultasiSelesai as $konsultasi) {
                                            if($konsultasi->tanggal_selesai && $konsultasi->tanggal_mulai) {
                                                $duration = $konsultasi->tanggal_selesai->diffInMinutes($konsultasi->tanggal_mulai);
                                                $totalMinutes += $duration;
                                            }
                                        }
                                        $avgDuration = round($totalMinutes / $konsultasiSelesai->count(), 1);
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

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Dengan Catatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $withNotes = $konsultasiSelesai->whereNotNull('catatan_akhir')->count();
                                    echo $withNotes;
                                @endphp
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sticky-note fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Konsultasi Selesai</h6>
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
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Durasi</th>
                            <th>Total Pesan</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($konsultasiSelesai as $index => $item)
                            @php
                                $totalMessages = $item->pesanKonsultasi()->count();
                                $duration = $item->tanggal_selesai && $item->tanggal_mulai 
                                    ? $item->tanggal_selesai->diffForHumans($item->tanggal_mulai, true) 
                                    : '-';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->klien->name ?? 'Unknown' }}</strong><br>
                                    <small class="text-muted">{{ $item->klien->email ?? '' }}</small>
                                </td>
                                <td>
                                    <strong>{{ $item->profesional->name ?? 'Tidak ada' }}</strong><br>
                                    <small class="text-muted">{{ $item->profesional->spesialisasi ?? '' }}</small>
                                </td>
                                <td>{{ $item->laporanKasus->jenis_kekerasan ?? 'N/A' }}</td>
                                <td>{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $duration }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $totalMessages }}</span>
                                </td>
                                <td>
                                    @if($item->catatan_akhir)
                                        <button type="button" class="btn btn-sm btn-outline-info" 
                                                data-toggle="modal" data-target="#catatanModal{{ $item->id }}">
                                            <i class="fas fa-sticky-note"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
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

                            <!-- Catatan Modal -->
                            @if($item->catatan_akhir)
                                <div class="modal fade" id="catatanModal{{ $item->id }}" tabindex="-1" role="dialog" 
                                     aria-labelledby="catatanModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="catatanModalLabel{{ $item->id }}">
                                                    Catatan Akhir Konsultasi
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Klien:</strong> {{ $item->klien->name ?? 'Unknown' }}<br>
                                                        <strong>Profesional:</strong> {{ $item->profesional->name ?? 'Tidak ada' }}<br>
                                                        <strong>Tanggal Selesai:</strong> {{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y H:i') : '-' }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Durasi:</strong> {{ $duration }}<br>
                                                        <strong>Total Pesan:</strong> {{ $totalMessages }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <strong>Catatan Akhir:</strong>
                                                <div class="mt-2">
                                                    {{ $item->catatan_akhir }}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="text-muted">
                                        <i class="fas fa-check-circle fa-3x mb-3"></i><br>
                                        Belum ada konsultasi yang selesai
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Pagination -->
                @if($konsultasiSelesai instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-3">
                        {{ $konsultasiSelesai->appends(request()->query())->links() }}
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
                "order": [[ 5, "desc" ]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });
    </script>
@endsection