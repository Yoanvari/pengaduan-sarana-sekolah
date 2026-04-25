@extends('layouts.app')

@section('title', 'Login - Pengaduan Sarana Sekolah')

@section('styles')
<style>
    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--space-lg);
        position: relative;
        z-index: 1;
    }

    .login-container {
        width: 100%;
        max-width: 440px;
    }

    .login-brand {
        text-align: center;
        margin-bottom: var(--space-xl);
    }

    .login-brand .brand-logo {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: var(--radius-lg);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: var(--space-md);
        box-shadow: 0 8px 30px rgba(99, 102, 241, 0.3);
    }

    .login-brand h1 {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: var(--space-xs);
        color: var(--text-primary);
    }

    .login-brand p {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .login-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        padding: var(--space-xl);
        box-shadow: var(--shadow-lg);
    }

    /* Role Tabs */
    .role-tabs {
        display: flex;
        background: var(--bg-input);
        border-radius: var(--radius-sm);
        padding: 4px;
        margin-bottom: var(--space-xl);
        border: 1px solid var(--border-color);
    }

    .role-tab {
        flex: 1;
        padding: 10px 16px;
        text-align: center;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        border-radius: 6px;
        transition: var(--transition);
        border: none;
        background: transparent;
        font-family: 'Inter', sans-serif;
    }

    .role-tab:hover {
        color: var(--text-secondary);
    }

    .role-tab.active {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }

    .login-card .form-group:last-of-type {
        margin-bottom: var(--space-xl);
    }

    .login-footer {
        text-align: center;
        margin-top: var(--space-lg);
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    #label-login-id {
        transition: var(--transition);
    }

    /* Input icon prefix */
    .input-with-icon {
        position: relative;
    }

    .input-with-icon .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1rem;
        color: var(--text-muted);
        pointer-events: none;
    }

    .input-with-icon .form-input {
        padding-left: 42px;
    }
</style>
@endsection

@section('content')
<div class="login-wrapper">
    <div class="login-container">
        {{-- Brand --}}
        <div class="login-brand">
            <div class="brand-logo">🏫</div>
            <h1>Pengaduan Sarana</h1>
            <p>Sistem Aspirasi & Pelaporan Fasilitas Sekolah</p>
        </div>

        {{-- Alert Messages --}}
        @if(session('error'))
            <div class="alert alert-error">
                <span>⚠️</span> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <span>⚠️</span>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        {{-- Login Card --}}
        <div class="login-card">
            {{-- Role Tabs --}}
            <div class="role-tabs">
                <button type="button" class="role-tab active" id="tab-siswa" onclick="switchRole('siswa')">
                    🎓 Siswa
                </button>
                <button type="button" class="role-tab" id="tab-admin" onclick="switchRole('admin')">
                    🛡️ Admin
                </button>
            </div>

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.process') }}" id="login-form">
                @csrf
                <input type="hidden" name="role" id="role-input" value="siswa">

                <div class="form-group">
                    <label class="form-label" id="label-login-id" for="login_id">NIS (Nomor Induk Siswa)</label>
                    <div class="input-with-icon">
                        <span class="input-icon" id="icon-login-id">🎓</span>
                        <input
                            type="text"
                            class="form-input"
                            id="login_id"
                            name="login_id"
                            placeholder="Masukkan NIS"
                            value="{{ old('login_id') }}"
                            required
                            autocomplete="off"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-with-icon">
                        <span class="input-icon">🔒</span>
                        <input
                            type="password"
                            class="form-input"
                            id="password"
                            name="password"
                            placeholder="Masukkan Password"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Masuk
                </button>
            </form>

            <div class="login-footer">
                <p>© {{ date('Y') }} Pengaduan Sarana Sekolah &middot; UKK 2025/2026</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchRole(role) {
        const roleInput = document.getElementById('role-input');
        const label     = document.getElementById('label-login-id');
        const icon      = document.getElementById('icon-login-id');
        const input     = document.getElementById('login_id');
        const tabSiswa  = document.getElementById('tab-siswa');
        const tabAdmin  = document.getElementById('tab-admin');

        roleInput.value = role;

        if (role === 'admin') {
            label.textContent    = 'Username';
            icon.textContent     = '🛡️';
            input.placeholder    = 'Masukkan Username';
            tabAdmin.classList.add('active');
            tabSiswa.classList.remove('active');
        } else {
            label.textContent    = 'NIS (Nomor Induk Siswa)';
            icon.textContent     = '🎓';
            input.placeholder    = 'Masukkan NIS';
            tabSiswa.classList.add('active');
            tabAdmin.classList.remove('active');
        }

        input.value = '';
        input.focus();
    }

    // Restore role tab from old input
    @if(old('role', 'siswa') === 'admin')
        switchRole('admin');
    @endif
</script>
@endsection
