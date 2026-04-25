<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Siswa;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login (unified login page).
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard masing-masing
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login (prosedur reusable untuk validasi credential).
     * Fungsi ini menangani multi-auth: mendeteksi tipe user dari input.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password'  => 'required|string',
            'role'      => 'required|in:admin,siswa',
        ]);

        $loginId  = $request->input('login_id');
        $password = $request->input('password');
        $role     = $request->input('role');

        // Gunakan prosedur/fungsi terpisah untuk autentikasi
        $result = $this->attemptLogin($role, $loginId, $password);

        if ($result['success']) {
            $request->session()->regenerate();
            return redirect()->intended($result['redirect']);
        }

        return back()->with('error', $result['message'])->withInput($request->except('password'));
    }

    /**
     * Prosedur/Fungsi reusable untuk mencoba login berdasarkan role.
     * Mengembalikan array hasil autentikasi.
     *
     * @param string $role
     * @param string $loginId
     * @param string $password
     * @return array
     */
    private function attemptLogin(string $role, string $loginId, string $password): array
    {
        if ($role === 'admin') {
            return $this->authenticateAdmin($loginId, $password);
        }

        return $this->authenticateSiswa($loginId, $password);
    }

    /**
     * Prosedur autentikasi khusus Admin (menggunakan username).
     */
    private function authenticateAdmin(string $username, string $password): array
    {
        $admin = Admin::where('username', $username)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return [
                'success'  => true,
                'redirect' => route('admin.dashboard'),
                'message'  => '',
            ];
        }

        return [
            'success'  => false,
            'redirect' => '',
            'message'  => 'Username atau password Admin salah.',
        ];
    }

    /**
     * Prosedur autentikasi khusus Siswa (menggunakan NIS).
     */
    private function authenticateSiswa(string $nis, string $password): array
    {
        $siswa = Siswa::where('nis', $nis)->first();

        if ($siswa && Hash::check($password, $siswa->password)) {
            Auth::guard('siswa')->login($siswa);
            return [
                'success'  => true,
                'redirect' => route('siswa.dashboard'),
                'message'  => '',
            ];
        }

        return [
            'success'  => false,
            'redirect' => '',
            'message'  => 'NIS atau password Siswa salah.',
        ];
    }

    /**
     * Logout (prosedur reusable untuk kedua role).
     */
    public function logout(Request $request)
    {
        // Logout dari semua guard yang aktif
        $guards = ['admin', 'siswa'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
