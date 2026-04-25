<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Siswa;

class AdminController extends Controller
{
    /**
     * Dashboard Admin: menampilkan list aspirasi keseluruhan dengan filter.
     * Menggunakan Eager Loading & Query efisien.
     */
    public function dashboard(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Ambil data filter dari request
        $filters = $this->getFilterParams($request);

        // Query aspirasi dengan Eager Loading
        $query = Aspirasi::with(['siswa', 'kategori', 'admin']);

        // Terapkan filter menggunakan prosedur reusable
        $query = $this->applyFilters($query, $filters);

        $aspirasis = $query->orderBy('created_at', 'desc')->get();

        // Pengolahan data menggunakan Array sebelum dikirim ke View
        $statistik    = $this->hitungStatistikAdmin($aspirasis);
        $dataAspirasi = $this->formatAspirasiArrayAdmin($aspirasis);

        // Data untuk dropdown filter
        $kategoris = Kategori::all();
        $siswas    = Siswa::all();

        return view('admin.dashboard', compact(
            'admin', 'dataAspirasi', 'statistik',
            'kategoris', 'siswas', 'filters'
        ));
    }

    /**
     * Tampilkan halaman edit (feedback & status) aspirasi.
     */
    public function editAspirasi($id)
    {
        $admin    = Auth::guard('admin')->user();
        $aspirasi = Aspirasi::with(['siswa', 'kategori'])->findOrFail($id);

        return view('admin.edit_aspirasi', compact('admin', 'aspirasi'));
    }

    /**
     * Proses update feedback & status aspirasi.
     */
    public function updateAspirasi(Request $request, $id)
    {
        $request->validate([
            'status'   => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string',
        ]);

        $admin    = Auth::guard('admin')->user();
        $aspirasi = Aspirasi::findOrFail($id);

        $aspirasi->update([
            'status'   => $request->status,
            'feedback' => $request->feedback,
            'admin_id' => $admin->id,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Status dan feedback berhasil diperbarui.');
    }

    /**
     * Prosedur/Fungsi reusable: Ambil parameter filter dari request.
     *
     * @param Request $request
     * @return array
     */
    private function getFilterParams(Request $request): array
    {
        return [
            'tanggal'     => $request->input('tanggal', ''),
            'bulan'       => $request->input('bulan', ''),
            'nis'         => $request->input('nis', ''),
            'kategori_id' => $request->input('kategori_id', ''),
            'status'      => $request->input('status', ''),
        ];
    }

    /**
     * Prosedur/Fungsi reusable: Terapkan filter ke query aspirasi.
     * Menggunakan conditional query yang efisien.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applyFilters($query, array $filters)
    {
        // Filter berdasarkan tanggal spesifik
        if (!empty($filters['tanggal'])) {
            $query->whereDate('created_at', $filters['tanggal']);
        }

        // Filter berdasarkan bulan (format: YYYY-MM)
        if (!empty($filters['bulan'])) {
            $parts = explode('-', $filters['bulan']);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        // Filter berdasarkan NIS siswa
        if (!empty($filters['nis'])) {
            $query->where('nis', $filters['nis']);
        }

        // Filter berdasarkan kategori
        if (!empty($filters['kategori_id'])) {
            $query->where('kategori_id', $filters['kategori_id']);
        }

        // Filter berdasarkan status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }

    /**
     * Prosedur/Fungsi reusable: Hitung statistik aspirasi untuk admin.
     * Implementasi pengolahan Array.
     *
     * @param \Illuminate\Database\Eloquent\Collection $aspirasis
     * @return array
     */
    private function hitungStatistikAdmin($aspirasis): array
    {
        $statusList = ['Menunggu', 'Proses', 'Selesai'];
        $statistik  = [
            'total'    => $aspirasis->count(),
            'menunggu' => 0,
            'proses'   => 0,
            'selesai'  => 0,
        ];

        foreach ($statusList as $status) {
            $key = strtolower($status);
            $statistik[$key] = $aspirasis->where('status', $status)->count();
        }

        return $statistik;
    }

    /**
     * Prosedur/Fungsi reusable: Format data aspirasi menjadi array
     * yang terstruktur sebelum dikirim ke View.
     *
     * @param \Illuminate\Database\Eloquent\Collection $aspirasis
     * @return array
     */
    private function formatAspirasiArrayAdmin($aspirasis): array
    {
        $dataAspirasi = [];

        foreach ($aspirasis as $aspirasi) {
            $dataAspirasi[] = [
                'id'            => $aspirasi->id,
                'siswa_nis'     => $aspirasi->nis,
                'siswa_nama'    => $aspirasi->siswa->nama ?? '-',
                'siswa_kelas'   => $aspirasi->siswa->kelas ?? '-',
                'kategori'      => $aspirasi->kategori->nama_kategori ?? '-',
                'lokasi'        => $aspirasi->lokasi,
                'keterangan'    => $aspirasi->keterangan,
                'status'        => $aspirasi->status,
                'feedback'      => $aspirasi->feedback ?? '-',
                'admin_nama'    => $aspirasi->admin->nama ?? 'Belum ditangani',
                'tanggal'       => $aspirasi->created_at->format('d M Y, H:i'),
                'tanggal_raw'   => $aspirasi->created_at->toDateString(),
            ];
        }

        return $dataAspirasi;
    }
}
