@extends('layouts.app')

@section('title', 'Dashboard Admin - Pengaduan Sarana Sekolah')

@section('content')
{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <div class="brand-icon">🏫</div>
            Pengaduan Sarana
        </a>

        <div class="navbar-menu">
            <div class="navbar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr($admin->nama, 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ $admin->nama }}</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-logout btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

{{-- Main Content --}}
<div class="main-container">
    {{-- Page Header --}}
    <div class="page-header">
        <h1>🛡️ Dashboard Administrator</h1>
        <p>Kelola dan tanggapi seluruh aspirasi pengaduan sarana sekolah.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-icon">📊</div>
            <div class="stat-number">{{ $statistik['total'] }}</div>
            <div class="stat-label">Total Aspirasi</div>
        </div>
        <div class="stat-card stat-menunggu">
            <div class="stat-icon">⏳</div>
            <div class="stat-number">{{ $statistik['menunggu'] }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
        <div class="stat-card stat-proses">
            <div class="stat-icon">🔄</div>
            <div class="stat-number">{{ $statistik['proses'] }}</div>
            <div class="stat-label">Diproses</div>
        </div>
        <div class="stat-card stat-selesai">
            <div class="stat-icon">✅</div>
            <div class="stat-number">{{ $statistik['selesai'] }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.dashboard') }}">
        <div class="filter-bar">
            <div class="filter-group">
                <label for="filter-tanggal">Tanggal</label>
                <input type="date" id="filter-tanggal" name="tanggal" value="{{ $filters['tanggal'] }}">
            </div>

            <div class="filter-group">
                <label for="filter-bulan">Bulan</label>
                <input type="month" id="filter-bulan" name="bulan" value="{{ $filters['bulan'] }}">
            </div>

            <div class="filter-group">
                <label for="filter-siswa">Siswa</label>
                <select id="filter-siswa" name="nis">
                    <option value="">Semua Siswa</option>
                    @foreach($siswas as $sw)
                        <option value="{{ $sw->nis }}" {{ $filters['nis'] == $sw->nis ? 'selected' : '' }}>
                            {{ $sw->nama }} ({{ $sw->nis }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-kategori">Kategori</label>
                <select id="filter-kategori" name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ $filters['kategori_id'] == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-status">Status</label>
                <select id="filter-status" name="status">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ $filters['status'] == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Proses" {{ $filters['status'] == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Selesai" {{ $filters['status'] == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary btn-sm">🔍 Filter</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-sm">↻ Reset</a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">📋 Daftar Aspirasi ({{ count($dataAspirasi) }})</div>
        </div>

        @if(count($dataAspirasi) > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataAspirasi as $index => $item)
                            <tr>
                                <td style="color: var(--text-muted); font-weight: 500;">{{ $index + 1 }}</td>
                                <td style="white-space: nowrap;">{{ $item['tanggal'] }}</td>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $item['siswa_nama'] }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $item['siswa_nis'] }} &middot; {{ $item['siswa_kelas'] }}</div>
                                </td>
                                <td>
                                    <span class="detail-tag">{{ $item['kategori'] }}</span>
                                </td>
                                <td>{{ $item['lokasi'] }}</td>
                                <td style="max-width: 250px;">
                                    <div style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $item['keterangan'] }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ strtolower($item['status']) }}">
                                        {{ $item['status'] }}
                                    </span>
                                </td>
                                <td style="max-width: 200px;">
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                                        {{ \Illuminate\Support\Str::limit($item['feedback'], 60) }}
                                    </div>
                                    @if($item['admin_nama'] !== 'Belum ditangani')
                                        <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 2px;">
                                            oleh: {{ $item['admin_nama'] }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.aspirasi.edit', $item['id']) }}" class="btn btn-primary btn-sm">
                                        ✏️ Tanggapi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Tidak Ada Data</h3>
                <p>Tidak ditemukan aspirasi yang sesuai dengan filter yang dipilih.</p>
            </div>
        @endif
    </div>
</div>
@endsection
