<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JadwalEvent;
use App\Models\Cabor;
use App\Models\Atlit;
use Carbon\Carbon;

class JadwalEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data cabang olahraga dan atlit yang ada
        $cabors = Cabor::where('status', 'aktif')->get();
        $atlits = Atlit::where('status', 'aktif')->get();

        if ($cabors->isEmpty()) {
            $this->command->warn('Tidak ada cabang olahraga aktif. Jalankan CaborSeeder terlebih dahulu.');
            return;
        }

        // Data jadwal event dummy
        $eventsData = [
            [
                'nama_event' => 'Kejuaraan Nasional Bulu Tangkis Junior',
                'jenis_event' => 'kejuaraan',
                'tanggal_mulai' => Carbon::now()->addDays(30),
                'tanggal_selesai' => Carbon::now()->addDays(35),
                'lokasi' => 'Jakarta Convention Center, Jakarta',
                'penyelenggara' => 'PBSI (Persatuan Bulutangkis Seluruh Indonesia)',
                'deskripsi' => 'Kejuaraan nasional bulu tangkis untuk kategori junior yang diselenggarakan untuk mencari bibit-bibit muda terbaik Indonesia.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Seleksi Atlet Renang PON 2024',
                'jenis_event' => 'seleksi',
                'tanggal_mulai' => Carbon::now()->addDays(15),
                'tanggal_selesai' => Carbon::now()->addDays(17),
                'lokasi' => 'Aquatic Stadium Gelora Bung Karno, Jakarta',
                'penyelenggara' => 'PRSI (Persatuan Renang Seluruh Indonesia)',
                'deskripsi' => 'Seleksi atlet renang untuk persiapan PON 2024. Atlet terbaik akan mewakili daerah dalam ajang bergengsi nasional.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Pertandingan Persahabatan Sepak Bola',
                'jenis_event' => 'pertandingan',
                'tanggal_mulai' => Carbon::now()->addDays(7),
                'tanggal_selesai' => Carbon::now()->addDays(7),
                'lokasi' => 'Stadion Gelora Bung Tomo, Surabaya',
                'penyelenggara' => 'PSSI Jawa Timur',
                'deskripsi' => 'Pertandingan persahabatan antar klub untuk meningkatkan sportivitas dan kemampuan bermain.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Uji Coba Atlet Atletik Nasional',
                'jenis_event' => 'uji_coba',
                'tanggal_mulai' => Carbon::now()->addDays(45),
                'tanggal_selesai' => Carbon::now()->addDays(46),
                'lokasi' => 'Stadion Madya Gelora Bung Karno, Jakarta',
                'penyelenggara' => 'PB PASI (Persatuan Atletik Seluruh Indonesia)',
                'deskripsi' => 'Uji coba untuk mengukur kemampuan dan kesiapan atlet atletik dalam persiapan kompetisi internasional.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Kejuaraan Daerah Tenis Meja',
                'jenis_event' => 'kejuaraan',
                'tanggal_mulai' => Carbon::now()->addDays(20),
                'tanggal_selesai' => Carbon::now()->addDays(23),
                'lokasi' => 'GOR Pajajaran, Bandung',
                'penyelenggara' => 'PTMSI Jawa Barat',
                'deskripsi' => 'Kejuaraan tenis meja tingkat daerah untuk menentukan atlet terbaik yang akan mewakili daerah.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Pertandingan Basket Antar Klub',
                'jenis_event' => 'pertandingan',
                'tanggal_mulai' => Carbon::now()->addDays(12),
                'tanggal_selesai' => Carbon::now()->addDays(14),
                'lokasi' => 'GOR C-Tra Arena, Bandung',
                'penyelenggara' => 'Perbasi Jawa Barat',
                'deskripsi' => 'Pertandingan basket antar klub untuk meningkatkan kualitas permainan dan sportivitas.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Seleksi Pelatnas Voli Pantai',
                'jenis_event' => 'seleksi',
                'tanggal_mulai' => Carbon::now()->addDays(60),
                'tanggal_selesai' => Carbon::now()->addDays(62),
                'lokasi' => 'Pantai Kuta, Bali',
                'penyelenggara' => 'PBVSI (Persatuan Bola Voli Seluruh Indonesia)',
                'deskripsi' => 'Seleksi untuk menentukan atlet voli pantai yang akan mengikuti pelatihan nasional.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Turnamen Karate Tradisional',
                'jenis_event' => 'pertandingan',
                'tanggal_mulai' => Carbon::now()->addDays(25),
                'tanggal_selesai' => Carbon::now()->addDays(26),
                'lokasi' => 'Padepokan Pencak Silat, Taman Mini Indonesia Indah',
                'penyelenggara' => 'FORKI (Federasi Olahraga Karate-Do Indonesia)',
                'deskripsi' => 'Turnamen karate dengan mengedepankan nilai-nilai tradisional dan sportivitas.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Uji Coba Pemanasan Asian Games',
                'jenis_event' => 'uji_coba',
                'tanggal_mulai' => Carbon::now()->addDays(90),
                'tanggal_selesai' => Carbon::now()->addDays(95),
                'lokasi' => 'Kompleks Gelora Bung Karno, Jakarta',
                'penyelenggara' => 'Kementerian Pemuda dan Olahraga RI',
                'deskripsi' => 'Uji coba multi cabang olahraga sebagai persiapan Asian Games dengan standar internasional.',
                'status' => 'aktif'
            ],
            [
                'nama_event' => 'Kejuaraan Panahan Nasional',
                'jenis_event' => 'kejuaraan',
                'tanggal_mulai' => Carbon::now()->addDays(35),
                'tanggal_selesai' => Carbon::now()->addDays(38),
                'lokasi' => 'Lapangan Panahan Senayan, Jakarta',
                'penyelenggara' => 'Perpani (Persatuan Panahan Indonesia)',
                'deskripsi' => 'Kejuaraan panahan nasional untuk menentukan atlet terbaik di berbagai kategori.',
                'status' => 'aktif'
            ],
            // Event yang sudah selesai
            [
                'nama_event' => 'Pertandingan Persahabatan Futsal',
                'jenis_event' => 'pertandingan',
                'tanggal_mulai' => Carbon::now()->subDays(15),
                'tanggal_selesai' => Carbon::now()->subDays(15),
                'lokasi' => 'GOR Futsal Senayan, Jakarta',
                'penyelenggara' => 'AFC (Asosiasi Futsal Indonesia)',
                'deskripsi' => 'Pertandingan persahabatan futsal yang telah selesai dilaksanakan.',
                'status' => 'selesai'
            ],
            [
                'nama_event' => 'Seleksi Atlet Angkat Besi Regional',
                'jenis_event' => 'seleksi',
                'tanggal_mulai' => Carbon::now()->subDays(30),
                'tanggal_selesai' => Carbon::now()->subDays(28),
                'lokasi' => 'GOR Angkat Besi Cibubur, Jakarta',
                'penyelenggara' => 'PABBSI (Persatuan Angkat Berat dan Besi Seluruh Indonesia)',
                'deskripsi' => 'Seleksi regional untuk angkat besi yang telah selesai dilaksanakan.',
                'status' => 'selesai'
            ]
        ];

        foreach ($eventsData as $eventData) {
            // Ambil cabang olahraga secara acak
            $cabor = $cabors->random();
            $eventData['cabang_olahraga_id'] = $cabor->id;

            // Buat event
            $event = JadwalEvent::create($eventData);

            // Tambahkan atlet secara acak untuk event ini
            $atletsCabor = $atlits->where('cabang_olahraga_id', $cabor->id);

            if ($atletsCabor->count() > 0) {
                // Ambil 2-5 atlet secara acak dari cabang olahraga yang sama
                $selectedAtlits = $atletsCabor->random(min($atletsCabor->count(), rand(2, 5)));
                $event->atlit()->attach($selectedAtlits->pluck('id')->toArray());
            }

            $this->command->info("Event '{$event->nama_event}' berhasil dibuat dengan " . $event->atlit()->count() . " atlet.");
        }

        $this->command->info('JadwalEventSeeder selesai. Total ' . count($eventsData) . ' event berhasil dibuat.');
    }
}
