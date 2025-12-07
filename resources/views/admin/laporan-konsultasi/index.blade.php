@extends('layouts.sbadmin')

@section('title', 'Laporan Konsultasi - LK3')



@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Konsultasi</h1>
        <div>
            <a href="{{ route('admin.laporan.menunggu') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-clock fa-sm text-white-50"></i> Laporan Menunggu
            </a>
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
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan-konsultasi.index') }}">
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
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.laporan-konsultasi.index') }}" class="btn btn-secondary">
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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Konsultasi</h6>
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
                            <th>Status</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($konsultasi as $index => $item)
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
                                    @if($item->tanggal_selesai)
                                        {{ $item->tanggal_selesai->diffForHumans($item->tanggal_mulai, true) }}
                                    @else
                                        {{ $item->tanggal_mulai->diffForHumans(null, true) }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.konsultasi.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                        Belum ada data konsultasi
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
                "order": [[ 5, "desc" ]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });
    </script>
@endsection