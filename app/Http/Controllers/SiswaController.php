<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aspirasi;
use App\Models\Kategori;

class SiswaController extends Controller
{
    /**
     * Dashboard Siswa: menampilkan histori aspirasi milik siswa yang login.
     * Menggunakan Eager Loading untuk efisiensi query.
     */
    public function dashboard()
    {
        $siswa = Auth::guard('siswa')->user();

        // Eager Loading relasi kategori dan admin untuk menghindari N+1 query
        $aspirasis = Aspirasi::with(['kategori', 'admin'])
            ->where('nis', $siswa->nis)
            ->orderBy('created_at', 'desc')
            ->get();

        // Implementasi Array: mengolah data statistik sebelum dikirim ke View
        $statistik = $this->hitungStatistik($aspirasis);

        // Mengolah data aspirasi menjadi array terformat sebelum dikirim ke View
        $dataAspirasi = $this->formatAspirasiArray($aspirasis);

        return view('siswa.dashboard', compact('siswa', 'dataAspirasi', 'statistik'));
    }

    /**
     * Tampilkan form input aspirasi baru.
     */
    public function createAspirasi()
    {
        $siswa     = Auth::guard('siswa')->user();
        $kategoris = Kategori::all();

        return view('siswa.form_aspirasi', compact('siswa', 'kategoris'));
    }

    /**
     * Proses simpan aspirasi baru.
     */
    public function storeAspirasi(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi'      => 'required|string|max:100',
            'keterangan'  => 'required|string',
        ]);

        $siswa = Auth::guard('siswa')->user();

        Aspirasi::create([
            'nis'         => $siswa->nis,
            'kategori_id' => $request->kategori_id,
            'lokasi'      => $request->lokasi,
            'keterangan'  => $request->keterangan,
            'status'      => 'Menunggu',
        ]);

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Aspirasi berhasil dikirim! Terima kasih atas laporanmu.');
    }

    /**
     * Prosedur/Fungsi reusable: Menghitung statistik aspirasi siswa.
     * Menggunakan array untuk pengolahan data.
     *
     * @param \Illuminate\Database\Eloquent\Collection $aspirasis
     * @return array
     */
    private function hitungStatistik($aspirasis): array
    {
        $statusList = ['Menunggu', 'Proses', 'Selesai'];
        $statistik  = [
            'total'    => $aspirasis->count(),
            'menunggu' => 0,
            'proses'   => 0,
            'selesai'  => 0,
        ];

        // Menghitung jumlah per status menggunakan pengolahan array
        foreach ($statusList as $status) {
            $key = strtolower($status);
            $statistik[$key] = $aspirasis->where('status', $status)->count();
        }

        return $statistik;
    }

    /**
     * Prosedur/Fungsi reusable: Format data aspirasi menjadi array
     * sebelum dikirim ke View.
     *
     * @param \Illuminate\Database\Eloquent\Collection $aspirasis
     * @return array
     */
    private function formatAspirasiArray($aspirasis): array
    {
        $dataAspirasi = [];

        foreach ($aspirasis as $aspirasi) {
            $dataAspirasi[] = [
                'id'          => $aspirasi->id,
                'kategori'    => $aspirasi->kategori->nama_kategori ?? '-',
                'lokasi'      => $aspirasi->lokasi,
                'keterangan'  => $aspirasi->keterangan,
                'status'      => $aspirasi->status,
                'feedback'    => $aspirasi->feedback ?? 'Belum ada feedback',
                'admin_nama'  => $aspirasi->admin->nama ?? '-',
                'tanggal'     => $aspirasi->created_at->format('d M Y, H:i'),
            ];
        }

        return $dataAspirasi;
    }
}
