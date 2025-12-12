@extends('layouts.sbadmin')

@section('title', 'Daftar Konsultasi - LK3')
@section('dashboardLink', route('profesional.dashboard'))
@section('sidebarBrandLink', route('profesional.dashboard'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Konsultasi</h1>
        <div class="d-none d-sm-inline-block">
            <a href="{{ route('profesional.dashboard') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Konsultasi yang Ditugaskan</h6>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('profesional.konsultasi') }}" class="form-inline">
                                <div class="input-group">
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="">Semua Status</option>
                                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($konsultasi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Klien</th>
                                        <th>Jenis Kasus</th>
                                        <th>Deskripsi Singkat</th>
                                        <th>Mulai Konsultasi</th>
                                        <th>Status</th>
                                        <th>Total Pesan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($konsultasi as $sesi)
                                        <tr>
                                            <td>
                                                <strong>{{ $sesi->klien->name }}</strong>
                                                <br>
                                                <small class="text-muted">ID: {{ $sesi->klien->id }}</small>
                                            </td>
                                            <td>
                                                @if($sesi->laporanKasus)
                                                    <span class="badge badge-info">{{ $sesi->laporanKasus->jenis_kekerasan }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($sesi->laporanKasus)
                                                    {{ Str::limit($sesi->laporanKasus->deskripsi_kasus, 50) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $sesi->tanggal_mulai ? $sesi->tanggal_mulai->setTimezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}
                                            </td>
                                            <td>
                                                @if($sesi->status_sesi == 'aktif')
                                                    <span class="badge badge-success">Aktif</span>
                                                @elseif($sesi->status_sesi == 'selesai')
                                                    <span class="badge badge-secondary">Selesai</span>
                                                @else
                                                    <span class="badge badge-warning">{{ ucfirst($sesi->status_sesi) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-light">{{ $sesi->pesanKonsultasi->count() }} pesan</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($sesi->status_sesi == 'aktif')
                                                        <a href="{{ route('profesional.konsultasi.chat', $sesi->id) }}" class="btn btn-sm btn-success">
                                                            <i class="fas fa-comments"></i> Chat
                                                        </a>
                                                    @else
                                                        <a href="{{ route('profesional.konsultasi.detail', $sesi->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-12">
                                {{ $konsultasi->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-600">Belum ada konsultasi</h5>
                            <p class="text-gray-500">Belum ada konsultasi yang ditugaskan kepada Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add any JavaScript functionality here
        $(document).ready(function() {
            // Auto-refresh page every 30 seconds to show latest status
            setTimeout(function() {
                location.reload();
            }, 30000);
        });
    </script>
@endpush