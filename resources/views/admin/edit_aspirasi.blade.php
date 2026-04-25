@extends('layouts.app')

@section('title', 'Edit Aspirasi - Pengaduan Sarana Sekolah')

@section('styles')
<style>
    .edit-container {
        max-width: 720px;
        margin: 0 auto;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-md);
        margin-bottom: var(--space-lg);
    }

    .detail-item {
        background: var(--bg-input);
        border-radius: var(--radius-sm);
        padding: var(--space-md);
        border: 1px solid var(--border-color);
    }

    .detail-item .detail-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: var(--space-xs);
    }

    .detail-item .detail-value {
        font-size: 0.9rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .keterangan-box {
        background: var(--bg-input);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: var(--space-lg);
        margin-bottom: var(--space-xl);
        line-height: 1.8;
        color: var(--text-secondary);
    }

    .keterangan-box .keterangan-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: var(--space-sm);
    }

    .section-divider {
        border: none;
        border-top: 1px solid var(--border-color);
        margin: var(--space-xl) 0;
    }

    .status-options {
        display: flex;
        gap: var(--space-md);
        margin-top: var(--space-sm);
    }

    .status-option {
        flex: 1;
        position: relative;
    }

    .status-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .status-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-xs);
        padding: var(--space-md);
        border-radius: var(--radius-md);
        border: 2px solid var(--border-color);
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
    }

    .status-option label:hover {
        border-color: var(--primary);
    }

    .status-option label .status-icon {
        font-size: 1.5rem;
    }

    .status-option label .status-text {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .status-option input[type="radio"]:checked + label {
        border-color: var(--primary);
        background: var(--primary-bg);
    }

    .status-option.option-menunggu input[type="radio"]:checked + label {
        border-color: var(--warning);
        background: var(--warning-bg);
    }

    .status-option.option-proses input[type="radio"]:checked + label {
        border-color: var(--info);
        background: var(--info-bg);
    }

    .status-option.option-selesai input[type="radio"]:checked + label {
        border-color: var(--success);
        background: var(--success-bg);
    }

    .form-actions {
        display: flex;
        gap: var(--space-md);
        margin-top: var(--space-xl);
    }

    @media (max-width: 600px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .status-options {
            flex-direction: column;
        }
    }
</style>
@endsection

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
    <div class="edit-container">
        {{-- Page Header --}}
        <div class="page-header">
            <h1>✏️ Tanggapi Aspirasi #{{ $aspirasi->id }}</h1>
            <p>Berikan feedback dan perbarui status penyelesaian aspirasi ini.</p>
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

        {{-- Detail Aspirasi --}}
        <div class="card" style="margin-bottom: var(--space-xl);">
            <div class="card-header">
                <div class="card-title">📋 Detail Laporan</div>
                <span class="badge badge-{{ strtolower($aspirasi->status) }}">
                    {{ $aspirasi->status }}
                </span>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">👤 Nama Siswa</div>
                    <div class="detail-value">{{ $aspirasi->siswa->nama ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">🆔 NIS</div>
                    <div class="detail-value">{{ $aspirasi->nis }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">🎓 Kelas</div>
                    <div class="detail-value">{{ $aspirasi->siswa->kelas ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">📂 Kategori</div>
                    <div class="detail-value">{{ $aspirasi->kategori->nama_kategori ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">📍 Lokasi</div>
                    <div class="detail-value">{{ $aspirasi->lokasi }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">🕐 Tanggal Lapor</div>
                    <div class="detail-value">{{ $aspirasi->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>

            <div class="keterangan-box">
                <div class="keterangan-label">📝 Keterangan</div>
                {{ $aspirasi->keterangan }}
            </div>
        </div>

        {{-- Form Tanggapi --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">🔧 Form Tanggapan</div>
            </div>

            <form method="POST" action="{{ route('admin.aspirasi.update', $aspirasi->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Status Penyelesaian</label>
                    <div class="status-options">
                        <div class="status-option option-menunggu">
                            <input type="radio" id="status-menunggu" name="status" value="Menunggu" {{ $aspirasi->status == 'Menunggu' ? 'checked' : '' }}>
                            <label for="status-menunggu">
                                <span class="status-icon">⏳</span>
                                <span class="status-text">Menunggu</span>
                            </label>
                        </div>
                        <div class="status-option option-proses">
                            <input type="radio" id="status-proses" name="status" value="Proses" {{ $aspirasi->status == 'Proses' ? 'checked' : '' }}>
                            <label for="status-proses">
                                <span class="status-icon">🔄</span>
                                <span class="status-text">Proses</span>
                            </label>
                        </div>
                        <div class="status-option option-selesai">
                            <input type="radio" id="status-selesai" name="status" value="Selesai" {{ $aspirasi->status == 'Selesai' ? 'checked' : '' }}>
                            <label for="status-selesai">
                                <span class="status-icon">✅</span>
                                <span class="status-text">Selesai</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="feedback">Umpan Balik (Feedback)</label>
                    <textarea
                        class="form-textarea"
                        id="feedback"
                        name="feedback"
                        placeholder="Tulis feedback atau tanggapan untuk siswa..."
                    >{{ old('feedback', $aspirasi->feedback) }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="flex:1;">
                        💾 Simpan Tanggapan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
