# Dokumentasi Sistem SIDAP

## 1. Tujuan Umum Sistem

Sistem ini dibuat untuk mengelola data atlet, latihan, event, prestasi, dan verifikasi dokumen di organisasi olahraga.

Tujuan utama:

- Mempermudah admin mengelola data atlet dan jadwal.
- Memberi atlet akses untuk melihat profil, dokumen, jadwal latihan/event, dan prestasi.
- Memberi verifikator kemampuan untuk memeriksa data atlet, dokumen, dan prestasi.
- Menyediakan laporan dan statistik yang mudah dilihat serta cetak laporan dalam bentuk PDF.

## 2. Alur Sistem Secara Singkat

1. Pengguna membuka situs dan melakukan login.
2. Sistem mengecek peran (role) pengguna: `admin`, `user` (atlit), atau `verifikator`.
3. Setelah login, pengguna diarahkan ke dashboard sesuai role.
4. Di dashboard, pengguna memilih modul sesuai aksesnya.
5. Admin bisa mengelola semua data utama.
6. Atlit bisa mengelola profil sendiri, mengunggah dokumen, melihat jadwal/event, dan melihat prestasi.
7. Verifikator bisa memeriksa dan mengonfirmasi data atlet, dokumen, dan prestasi.

## 3. Role dan Hak Akses

### 3.1 Admin

Admin adalah pengguna dengan akses paling lengkap.
Fitur yang bisa dilakukan admin:

- Mengelola data atlet:
    - tambah, lihat, edit, hapus atlet
    - mengatur kategori atlet berdasarkan cabang olahraga
- Mengelola data master:
    - cabang olahraga
    - klub
    - pelatih
- Mengelola jadwal latihan:
    - tambah, edit, lihat, hapus jadwal
    - ubah status jadwal (aktif, selesai, dibatalkan)
- Mengelola jadwal event:
    - tambah, edit, lihat, hapus event
    - atur atlet yang mengikuti event
    - ubah status event (aktif, selesai, dibatalkan)
- Mengelola prestasi:
    - tambah, edit, lihat, hapus prestasi
    - akses laporan prestasi dan cetak laporan
- Mengakses laporan seluruh data:
    - laporan atlet, laporan prestasi, dan statistik

### 3.2 Atlit

Atlit adalah pengguna biasa yang memiliki akun individual.
Fitur yang bisa dilakukan atlet:

- Melihat dan mengupdate profil sendiri.
- Membuka preview dan cetak ID Card atlet.
- Mengunggah dokumen pribadi dan mengunduh dokumen yang pernah diunggah.
- Melihat daftar prestasi sendiri.
- Melihat jadwal latihan dan jadwal event terkait cabang olahraga sendiri.
- Melihat kalender kegiatan yang memadukan jadwal latihan dan event.

### 3.3 Verifikator

Verifikator bertugas mengecek validitas data atlet dan prestasi.
Fitur verifikator:

- Melihat daftar prestasi yang perlu diperiksa.
- Melihat detail prestasi dan memverifikasi atau menolak.
- Menambahkan catatan ketika menolak prestasi.
- Melihat daftar atlet untuk keperluan verifikasi.
- Memverifikasi atau menolak data atlet.
- Memverifikasi atau menolak dokumen atlet.
- Melihat statistik verifikasi dan status atlet.

## 4. Penjelasan Modul Utama

### 4.1 Autentikasi dan Dashboard

Semua pengguna harus login dulu.
Di `User` model, sistem menyimpan `role` untuk membedakan `admin`, `user`, dan `verifikator`.
Setiap role akan mendapat halaman dashboard berbeda.

### 4.2 Modul Admin

#### 4.2.1 Manajemen Atlet

Admin dapat melihat seluruh atlet dan mengubah data mereka.
Data atlet meliputi: nama lengkap, NIK, tanggal lahir, jenis kelamin, alamat, nomor telepon, email, klub, cabang olahraga, kategori atlet, foto, status, dan status verifikasi.

#### 4.2.2 Kategori Atlet

Admin mengelola kategori atlet per cabang olahraga.
Jenis kategori biasanya dibuat untuk membedakan usia, kelas, atau tingkatan.

#### 4.2.3 Jadwal Latihan

Admin bisa membuat jadwal latihan baru lengkap dengan cabang olahraga, pelatih, lokasi, tanggal, jam, dan status.
Status bisa diubah menjadi `aktif`, `selesai`, atau `dibatalkan`.

#### 4.2.4 Jadwal Event

Admin bisa membuat event olahraga, memilih cabang olahraga, menentukan jenis event, tanggal mulai/selesai, lokasi, penyelenggara, dan atlet yang ikut.
Event juga bisa diatur statusnya seperti `aktif`, `selesai`, atau `dibatalkan`.

#### 4.2.5 Prestasi

Admin dapat memasukkan prestasi atlet yang terdiri dari nama kejuaraan, tempat, tanggal, peringkat, medali, dan sertifikat.
Prestasi memiliki status `verified`, `pending`, atau `rejected`.

#### 4.2.6 Laporan dan Statistik

Admin bisa melihat laporan atlet, laporan prestasi, dan ringkasan statistik.
Fitur cetak laporan tersedia dalam format PDF untuk data atlet dan prestasi.

### 4.3 Modul Atlit

#### 4.3.1 Profil Atlit

Atlit dapat melihat datanya sendiri dan menggunakan fitur update profil.
Profil ini terhubung ke akun login dan cabang olahraga yang dimiliki.

#### 4.3.2 Dokumen Pribadi

Atlit dapat mengunggah dokumen seperti ijazah, akta kelahiran, kartu pelajar, atau dokumen pendukung lain.
Dokumen akan disimpan dan status verifikasinya dapat dilihat: `pending`, `verified`, atau `rejected`.

#### 4.3.3 Prestasi Khusus Atlit

Atlit hanya dapat melihat prestasi mereka sendiri.
Mereka dapat melihat detail prestasi dan mengunduh sertifikat jika tersedia.

#### 4.3.4 Jadwal Latihan dan Event

Atlit melihat jadwal latihan dan event yang sesuai dengan cabang olahraga mereka.
Fungsi ini membantu atlet mengikuti semua kegiatan penting.

#### 4.3.5 Kalender Kegiatan

Atlit dapat membuka kalender yang menggabungkan jadwal latihan dan event.
Kalender ini membantu melihat aktivitas harian dan bulanan.

#### 4.3.6 ID Card Atlit

Atlit bisa melihat preview ID Card dan mencetak ID Card dalam bentuk PDF.
Di dalam ID Card juga ada QR code yang dapat diverifikasi.

### 4.4 Modul Verifikator

#### 4.4.1 Verifikasi Prestasi

Verifikator memeriksa prestasi yang diunggah admin atau atlet.
Setelah diperiksa, prestasi dapat disetujui (`verified`) atau ditolak (`rejected`).
Jika ditolak, verifikator wajib memberi alasan.

#### 4.4.2 Verifikasi Atlet dan Dokumen

Verifikator dapat membuka detail atlet, membaca dokumen pendukung, dan menyetujui atau menolak data atlet.
Dokumen yang ditolak dapat diminta diunggah ulang oleh atlet.

#### 4.4.3 Statistik Verifikator

Verifikator dapat melihat ringkasan jumlah atlet dan dokumen dalam status `pending`, `verified`, atau `rejected`.
Ini membantu memantau progres proses verifikasi.

### 4.5 Kalender Kegiatan / Event

Modul kalender mengumpulkan dua jenis data:

- Jadwal latihan aktif
- Event aktif

Semua role dapat melihat event publik dari kalender kegiatan, tetapi atlet melihat hanya event dan latihan yang relevan dengan cabang olahraga sendiri.

## 5. User Guide Sederhana

### 5.1 Untuk Admin

1. Login sebagai admin.
2. Di dashboard, pilih menu `Atlit` untuk melihat atau mengubah data atlet.
3. Gunakan menu `Jadwal Latihan` untuk membuat jadwal latihan baru.
4. Gunakan menu `Jadwal Event` untuk menambahkan event dan mengatur atlet yang ikut.
5. Gunakan menu `Prestasi` untuk merekam hasil pertandingan sekaligus mengunggah sertifikat.
6. Jika ingin laporan, buka menu `Laporan` dan pilih `Atlit`, `Prestasi`, atau `Statistik`.
7. Untuk cetak, gunakan tombol `Cetak` di halaman laporan.

### 5.2 Untuk Atlit

1. Login dengan akun atlet.
2. Buka halaman `Profil` untuk mengecek data pribadi.
3. Jika masih ada data yang kurang, perbarui profil di halaman tersebut.
4. Buka menu `Dokumen` untuk mengunggah berkas seperti ijazah atau kartu pelajar.
5. Buka menu `Prestasi` untuk melihat semua prestasi pribadi.
6. Buka `Jadwal Latihan` dan `Jadwal Event` untuk melihat kegiatan mendatang.
7. Buka `Kalender` untuk lihat semua kegiatan lebih mudah.
8. Untuk kartu ID, buka preview ID Card lalu cetak jika diperlukan.

### 5.3 Untuk Verifikator

1. Login sebagai verifikator.
2. Buka dashboard verifikator untuk melihat ringkasan tugas verifikasi.
3. Buka `Prestasi` untuk melihat daftar prestasi yang harus dicek.
4. Jika prestasi valid, pilih `Verify`; jika tidak, pilih `Reject` dan beri alasan.
5. Buka `Atlit` untuk melihat data atlet dan dokumen pendukung.
6. Verifikasi data atlet dan dokumen dengan memberi status yang sesuai.
7. Gunakan `Statistik` untuk melihat jumlah atlet/dokumen yang sudah diverifikasi.

## 6. Catatan Khusus

- Data atlet, dokumen, dan prestasi memiliki status tersendiri. Ini penting untuk proses verifikasi.
- Status dokumen atlet: `pending`, `verified`, `rejected`.
- Status prestasi: `verified`, `pending`, `rejected`.
- Status atlet: `aktif`, `nonaktif`, `pensiun`.
- Sistem menggunakan PDF untuk cetak ID Card dan laporan.
- Semua data terkait jadwal latihan dan event tersimpan di dalam modul kalender.

## 7. Struktur Utama Komponen Sistem

- `routes/web.php`: mengatur jalur akses dan role.
- `app/Models/User.php`: menyimpan info login dan role.
- `app/Models/Atlit.php`: menyimpan data atlet.
- `app/Models/DokumenAtlit.php`: menyimpan dokumen atlet.
- `app/Models/Prestasi.php`: menyimpan data prestasi atlet.
- `app/Models/JadwalLatihan.php`: menyimpan jadwal latihan.
- `app/Models/JadwalEvent.php`: menyimpan event dan atlet yang terkait.
- `app/Http/Controllers/DashboardController.php`: mengarahkan dashboard berdasarkan role.
- `app/Http/Controllers/AtlitController.php`: mengelola data atlet dan profil atlet.
- `app/Http/Controllers/PrestasiController.php`: mengelola prestasi.
- `app/Http/Controllers/JadwalLatihanController.php`: mengelola jadwal latihan.
- `app/Http/Controllers/JadwalEventController.php`: mengelola event.
- `app/Http/Controllers/LaporanController.php`: mengelola laporan dan statistik.
- `app/Http/Controllers/KalenderKegiatanController.php`: mengelola event kalender.
- `app/Http/Controllers/Verifikator/AtlitVerifikasiController.php`: mengelola proses verifikasi atlet.

## 8. Kesimpulan

Sistem ini dirancang agar setiap peran bisa bekerja dengan jelas:

- Admin fokus pada pengelolaan data dan laporan.
- Atlit fokus pada profil, dokumen, prestasi, dan jadwal.
- Verifikator fokus pada pemeriksaan data dan dokumentasi.

Dokumentasi ini dapat membantu pengguna awam memahami alur dan fungsi setiap bagian secara sederhana.
