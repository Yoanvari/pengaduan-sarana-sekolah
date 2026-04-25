# Aplikasi Pengaduan Sarana Sekolah

Aplikasi Pengaduan Sarana Sekolah adalah platform berbasis web yang dikembangkan untuk memfasilitasi siswa dalam melaporkan masalah atau memberikan aspirasi terkait sarana dan prasarana di lingkungan sekolah. Proyek ini dibangun sebagai pemenuhan **Tugas Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak Tahun Pelajaran 2025/2026**.

Aplikasi ini menggunakan sistem *Multi-Authentication* untuk membedakan hak akses antara **Admin** (petugas/pihak sekolah) dan **Siswa**.

---

## 🚀 Tech Stack

Aplikasi ini dibangun menggunakan teknologi modern untuk memastikan performa, keamanan, dan kemudahan pengembangan:

-   **Framework:** Laravel 12
-   **Bahasa Pemrograman:** PHP (minimal versi 8.2)
-   **Database:** MySQL
-   **Styling:** Custom CSS (Vanilla)
-   **Asset Bundling:** Vite

---

## ✨ Fitur Utama

Aplikasi ini dibagi menjadi dua portal utama dengan fitur yang disesuaikan untuk masing-masing peran pengguna:

### 👨‍🎓 Portal Siswa
Siswa memiliki akses untuk melaporkan dan memantau aspirasi mereka.
-   **Login Siswa:** Autentikasi aman menggunakan NIS dan Password.
-   **Dashboard Siswa:** Ringkasan dan status dari semua aspirasi yang pernah diajukan.
-   **Input Aspirasi:** Formulir pengajuan pengaduan yang mencakup pemilihan kategori, detail lokasi, dan keterangan masalah.
-   **Tracking Status:** Memantau perkembangan laporan (Menunggu, Proses, Selesai) beserta *feedback* atau tanggapan dari Admin.

### 👨‍💼 Portal Admin
Admin memiliki kontrol penuh untuk mengelola laporan yang masuk.
-   **Login Admin:** Autentikasi khusus untuk administrator.
-   **Dashboard Admin:** Menampilkan seluruh data aspirasi yang masuk dari semua siswa.
-   **Filter Data:** Kemampuan untuk memfilter laporan berdasarkan rentang waktu (bulan/tanggal) atau berdasarkan kategori pelaporan.
-   **Manajemen Aspirasi (Edit/Update):** Memproses laporan, mengubah status penyelesaian, dan memberikan *feedback* langsung kepada pelapor.

---

## 🛠️ Panduan Instalasi

Untuk menjalankan aplikasi ini di lingkungan lokal Anda (Localhost), ikuti langkah-langkah instalasi standar Laravel berikut:

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/username-anda/pengaduan-sarana-sekolah.git
    cd pengaduan-sarana-sekolah
    ```

2.  **Install Dependensi PHP (Composer)**
    ```bash
    composer install
    ```

3.  **Setup Environment File (.env)**
    Salin file konfigurasi contoh dan sesuaikan pengaturan database Anda.
    ```bash
    cp .env.example .env
    ```
    *Catatan: Buka file `.env` dan atur `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan konfigurasi MySQL lokal Anda.*

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database dan Seeding**
    Jalankan perintah berikut untuk membuat struktur tabel dan mengisi data awal (seeder) seperti akun admin dan data kategori.
    ```bash
    php artisan migrate --seed
    ```

6.  **Install Dependensi Frontend (NPM)**
    ```bash
    npm install
    npm run build
    ```

7.  **Jalankan Local Development Server**
    ```bash
    php artisan serve
    ```
    Aplikasi sekarang dapat diakses melalui browser di `http://localhost:8000`.

---

## 🗄️ Struktur Database

Struktur database telah dirancang dan dioptimasi menggunakan fitur bawaan Laravel (Eloquent Relationships dan Eager Loading) untuk memastikan efisiensi *query*, terutama saat menampilkan data berelasi di dashboard.

Berikut adalah ringkasan struktur tabel yang digunakan:

| Nama Tabel | Deskripsi & Kolom Utama |
| :--- | :--- |
| `admins` | Menyimpan data administrator. <br> **Kolom:** `id`, `nama`, `username`, `password`. |
| `siswas` | Menyimpan data siswa yang berhak melakukan login. Menggunakan `nis` sebagai *Primary Key*. <br> **Kolom:** `nis` (PK), `nama`, `kelas`, `password`. |
| `kategoris` | Data referensi (Master) untuk jenis pengaduan (misal: Kebersihan, Kerusakan Fasilitas). <br> **Kolom:** `id`, nama/keterangan kategori. |
| `aspirasis` | Tabel transaksi utama yang menyimpan pengaduan siswa. Memiliki *Foreign Keys* ke tabel `siswas`, `kategoris`, dan `admins`. <br> **Kolom:** `id`, `nis`, `kategori_id`, `lokasi`, `keterangan`, `status` (Menunggu/Proses/Selesai), `feedback`, `admin_id`. |

*Catatan: Constraint `CASCADE` dan `SET NULL` pada Foreign Key telah diterapkan pada tingkat database untuk menjaga integritas data (Referential Integrity).*

---

**Dibuat untuk keperluan Uji Kompetensi Keahlian (UKK) RPL © 2025/2026**
