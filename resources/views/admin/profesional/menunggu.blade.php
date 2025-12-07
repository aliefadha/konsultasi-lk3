@extends('layouts.sbadmin')

@section('title', 'Profesional Menunggu Tinjauan')

@section('dashboardLink', route('admin.dashboard'))
@section('sidebarBrandLink', route('admin.dashboard'))

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profesional Menunggu Tinjauan</h1>
        <div>
            <a href="{{ route('admin.profesional.index') }}" class="btn btn-info">
                <i class="fas fa-list"></i> Semua Profesional
            </a>
            <a href="{{ route('admin.profesional.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Profesional
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Information Alert -->
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Informasi:</strong> Berikut adalah daftar profesional yang sedang menunggu persetujuan untuk bergabung dengan sistem.
    </div>

    <!-- Pending Professionals List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Profesional Menunggu Tinjauan 
                <span class="badge badge-warning">{{ $profesional->total() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($profesional->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Spesialisasi</th>
                                <th>No. Telepon</th>
                                <th>Waktu Pendaftaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profesional as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-warning text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $item->name }}</h6>
                                                @if($item->jenis_kelamin)
                                                    <small class="text-muted">
                                                        <i class="fas fa-{{ $item->jenis_kelamin == 'laki-laki' ? 'mars text-primary' : 'venus text-danger' }}"></i>
                                                        {{ ucfirst($item->jenis_kelamin) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @if($item->spesialisasi)
                                            <span class="badge badge-info">{{ $item->spesialisasi }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->no_telepon ?? '-' }}</td>
                                    <td>
                                        <small>{{ $item->created_at->format('d/m/Y H:i') }}</small><br>
                                        <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.profesional.show', $item->id) }}" 
                                               class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.profesional.edit', $item->id) }}" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.profesional.update-status', $item->id) }}" 
                                                  style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="aktif">
                                                <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.profesional.update-status', $item->id) }}" 
                                                  style="display: inline;" onsubmit="return confirm('Yakin ingin menolak profesional ini?')">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="ditolak">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $profesional->links() }}
                </div>
            @else
                <div class="text-center">
                    <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada profesional yang menunggu tinjauan.</p>
                    <a href="{{ route('admin.profesional.index') }}" class="btn btn-info">
                        <i class="fas fa-list"></i> Lihat Semua Profesional
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Persetujuan Cepat</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Setujui semua profesional yang menunggu</p>
                    <button class="btn btn-success btn-block" disabled title="Fitur akan segera tersedia">
                        <i class="fas fa-check-double"></i> Setujui Semua
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-warning font-weight-bold">{{ $profesional->total() }}</h5>
                            <small class="text-muted">Menunggu</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success font-weight-bold">
                                {{ \App\Models\User::where('role', \App\Models\User::ROLE_PROFESIONAL)->where('status', 'aktif')->count() }}
                            </h5>
                            <small class="text-muted">Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection