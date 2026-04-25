<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Admin;
use App\Models\Kategori;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Data Dummy Kategori [cite: 75, 79]
        $kategoriList = ['Sarana Olahraga', 'Fasilitas Kelas', 'Kebersihan', 'Layanan IT'];
        foreach ($kategoriList as $kat) {
            Kategori::create(['nama_kategori' => $kat]);
        }

        // 2. Data Dummy Admin [cite: 64-66]
        Admin::create([
            'nama' => 'Admin Sekolah',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 3. Data Dummy Siswa [cite: 67-69]
        $siswa1 = Siswa::create([
            'nis' => '20260001',
            'nama' => 'Budi Santoso',
            'kelas' => 'XII RPL 1',
            'password' => Hash::make('password'),
        ]);

        $siswa2 = Siswa::create([
            'nis' => '20260002',
            'nama' => 'Siti Aminah',
            'kelas' => 'XII RPL 2',
            'password' => Hash::make('password'),
        ]);

        // 4. Data Dummy Aspirasi (Sudah digabung) [cite: 34, 61, 71, 74, 78]
        Aspirasi::create([
            'nis' => $siswa1->nis,
            'kategori_id' => 2, // Fasilitas Kelas
            'lokasi' => 'Ruang Lab 3',
            'keterangan' => 'AC mati sehingga ruangan sangat panas saat siang hari.',
            'status' => 'Proses',
            'feedback' => 'Teknisi akan mengecek unit AC besok jam 10 pagi.',
            'admin_id' => 1,
            'created_at' => now()->subDays(2), // Untuk tes filter tanggal
        ]);

        Aspirasi::create([
            'nis' => $siswa2->nis,
            'kategori_id' => 1, // Sarana Olahraga
            'lokasi' => 'Lapangan Basket',
            'keterangan' => 'Ring basket sebelah kiri goyang dan hampir lepas.',
            'status' => 'Menunggu',
            'feedback' => null,
            'created_at' => now(),
        ]);
    }
}