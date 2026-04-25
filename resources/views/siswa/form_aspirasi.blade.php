@extends('layouts.app')

@section('title', 'Buat Aspirasi - Pengaduan Sarana Sekolah')

@section('styles')
<style>
    .form-card {
        max-width: 640px;
        margin: 0 auto;
    }

    .form-card .card-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: var(--space-md);
    }

    .form-actions {
        display: flex;
        gap: var(--space-md);
        margin-top: var(--space-lg);
    }

    .char-count {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-align: right;
        margin-top: var(--space-xs);
    }
</style>
@endsection

@section('content')
{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('siswa.dashboard') }}" class="navbar-brand">
            <div class="brand-icon">🏫</div>
            Pengaduan Sarana
        </a>

        <div class="navbar-menu">
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
    <div class="form-card">
        {{-- Page Header --}}
        <div class="page-header">
            <h1>📝 Buat Laporan Aspirasi</h1>
            <p>Laporkan sarana atau fasilitas sekolah yang perlu diperbaiki.</p>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-error">
                <span>⚠️</span>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Form --}}
        <div class="card">
            <div class="card-icon">📋</div>

            <form method="POST" action="{{ route('siswa.aspirasi.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="kategori_id">Kategori Laporan</label>
                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="lokasi">Lokasi</label>
                    <input
                        type="text"
                        class="form-input"
                        id="lokasi"
                        name="lokasi"
                        placeholder="Contoh: Ruang Lab 3, Lapangan Basket"
                        value="{{ old('lokasi') }}"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <textarea
                        class="form-textarea"
                        id="keterangan"
                        name="keterangan"
                        placeholder="Jelaskan detail permasalahan sarana yang ingin dilaporkan..."
                        required
                    >{{ old('keterangan') }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="flex:1;">
                        📤 Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
