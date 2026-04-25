@extends('layouts.app')

@section('title', 'Dashboard Siswa - Pengaduan Sarana Sekolah')

@section('content')
{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('siswa.dashboard') }}" class="navbar-brand">
            <div class="brand-icon">🏫</div>
            Pengaduan Sarana
        </a>

        <div class="navbar-menu">
            <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary btn-sm">
                ➕ Buat Laporan
            </a>

            <div class="navbar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ $siswa->nama }}</div>
                    <div class="user-role">{{ $siswa->kelas }}</div>
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
        <h1>📋 Histori Aspirasi</h1>
        <p>Halo {{ $siswa->nama }}, berikut adalah daftar aspirasi yang telah kamu kirimkan.</p>
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

    {{-- Aspirasi List --}}
    @if(count($dataAspirasi) > 0)
        <div class="aspirasi-list">
            @foreach($dataAspirasi as $item)
                <div class="aspirasi-card">
                    <div class="aspirasi-header">
                        <div class="aspirasi-meta">
                            <span class="detail-tag">📂 {{ $item['kategori'] }}</span>
                            <span class="detail-tag">📍 {{ $item['lokasi'] }}</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">🕐 {{ $item['tanggal'] }}</span>
                        </div>
                        <span class="badge badge-{{ strtolower($item['status']) }}">
                            {{ $item['status'] }}
                        </span>
                    </div>

                    <div class="aspirasi-body">
                        {{ $item['keterangan'] }}
                    </div>

                    <div class="aspirasi-footer">
                        <div class="feedback-box">
                            <div class="feedback-label">💬 Feedback Admin</div>
                            <div>{{ $item['feedback'] }}</div>
                            @if($item['admin_nama'] !== '-')
                                <div style="margin-top: 4px; font-size: 0.7rem; color: var(--text-muted);">
                                    Ditangani oleh: {{ $item['admin_nama'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Belum Ada Aspirasi</h3>
                <p>Kamu belum mengirimkan aspirasi apapun. Klik tombol "Buat Laporan" di atas untuk mulai melaporkan sarana yang perlu diperbaiki.</p>
                <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary" style="margin-top: var(--space-md);">
                    ➕ Buat Laporan Pertamamu
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
