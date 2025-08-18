<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JadwalLatihan;
use App\Models\Cabor;
use App\Models\Pelatih;
use App\Models\Klub;
use Carbon\Carbon;

class JadwalLatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data yang diperlukan
        $cabors = Cabor::where('status', 'aktif')->get();
        $pelatihs = Pelatih::where('status', 'aktif')->get();
        $klubs = Klub::where('status', 'aktif')->get();

        if ($cabors->isEmpty()) {
            $this->command->warn('Tidak ada cabang olahraga aktif. Jalankan CaborSeeder terlebih dahulu.');
            return;
        }

        if ($pelatihs->isEmpty()) {
            $this->command->warn('Tidak ada pelatih aktif. Jalankan PelatihSeeder terlebih dahulu.');
            return;
        }

        // Template jadwal latihan berdasarkan cabang olahraga
        $latihanTemplates = [
            'Bulu Tangkis' => [
                'Latihan Teknik Dasar Bulutangkis',
                'Latihan Kondisi Fisik Bulutangkis',
                'Latihan Smash dan Drop Shot',
                'Sparring Bulutangkis',
                'Latihan Footwork dan Agility'
            ],
            'Renang' => [
                'Latihan Teknik Gaya Bebas',
                'Latihan Teknik Gaya Dada',
                'Latihan Teknik Gaya Punggung',
                'Latihan Teknik Gaya Kupu-kupu',
                'Latihan Stamina dan Endurance'
            ],
            'Sepak Bola' => [
                'Latihan Teknik Passing',
                'Latihan Shooting dan Finishing',
                'Latihan Taktik Tim',
                'Scrimmage dan Game Practice',
                'Latihan Kondisi Fisik Sepak Bola'
            ],
            'Atletik' => [
                'Latihan Lari Sprint',
                'Latihan Lompat Jauh',
                'Latihan Lempar Lembing',
                'Latihan Endurance Running',
                'Latihan Kekuatan dan Power'
            ],
            'Tenis Meja' => [
                'Latihan Teknik Forehand',
                'Latihan Teknik Backhand',
                'Latihan Servis dan Return',
                'Latihan Match Play',
                'Latihan Footwork Tenis Meja'
            ],
            'Basket' => [
                'Latihan Shooting Technique',
                'Latihan Dribbling dan Ball Handling',
                'Latihan Defense dan Rebounding',
                'Scrimmage Basketball',
                'Latihan Kondisi Fisik Basketball'
            ],
            'Voli' => [
                'Latihan Teknik Spike',
                'Latihan Teknik Block',
                'Latihan Servis dan Passing',
                'Latihan Taktik Tim Voli',
                'Match Practice Voli'
            ]
        ];

        // Lokasi latihan yang umum
        $lokasiLatihan = [
            'GOR Gelora Bung Karno, Jakarta',
            'Lapangan Olahraga Senayan, Jakarta',
            'GOR Pajajaran, Bandung',
            'Stadion Madya GBK, Jakarta',
            'GOR C-Tra Arena, Bandung',
            'Lapangan Tenis Indoor Senayan',
            'Kolam Renang Aquatic Stadium',
            'Lapangan Badminton Istora',
            'GOR Basket Kelapa Gading',
            'Lapangan Voli Indoor Senayan'
        ];

        // Jam latihan yang realistis
        $jamLatihan = [
            ['06:00', '08:00'], // Pagi
            ['08:00', '10:00'], // Pagi siang
            ['15:00', '17:00'], // Sore
            ['16:00', '18:00'], // Sore malam
            ['18:00', '20:00'], // Malam
            ['19:00', '21:00'], // Malam
        ];

        $catatanLatihan = [
            'Harap membawa perlengkapan latihan lengkap',
            'Latihan akan fokus pada peningkatan teknik',
            'Diperlukan pemanasan 15 menit sebelum latihan',
            'Latihan intensif untuk persiapan kompetisi',
            'Sesi evaluasi setelah latihan',
            'Latihan akan diadakan indoor',
            'Pastikan kondisi fisik prima',
            'Akan ada tes kemampuan di akhir sesi',
            'Latihan bersama pelatih nasional',
            'Sesi latihan untuk perbaikan teknik'
        ];

        // Generate jadwal latihan untuk 3 bulan ke depan
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addMonths(3);
        $totalCreated = 0;

        // Generate jadwal harian
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Skip weekend kadang-kadang
            if ($date->isWeekend() && rand(1, 3) == 1) {
                continue;
            }

            // Random 1-4 jadwal latihan per hari
            $jumlahLatihan = rand(1, 4);

            for ($i = 0; $i < $jumlahLatihan; $i++) {
                $cabor = $cabors->random();
                $caborName = $cabor->nama_cabang;

                // Ambil pelatih dari cabor yang sama atau random jika tidak ada
                $pelatihCabor = $pelatihs->where('cabang_olahraga_id', $cabor->id);
                $pelatih = $pelatihCabor->count() > 0 ? $pelatihCabor->random() : $pelatihs->random();

                // Pilih klub random atau null
                $klub = $klubs->count() > 0 && rand(1, 3) <= 2 ? $klubs->random() : null;

                // Pilih template latihan berdasarkan cabor
                $namaKegiatan = 'Latihan ' . $caborName;
                if (isset($latihanTemplates[$caborName])) {
                    $namaKegiatan = $latihanTemplates[$caborName][array_rand($latihanTemplates[$caborName])];
                }

                // Pilih jam latihan
                $jam = $jamLatihan[array_rand($jamLatihan)];

                // Status berdasarkan tanggal
                $status = 'aktif';
                if ($date->isPast()) {
                    $status = rand(1, 10) <= 8 ? 'selesai' : 'dibatalkan'; // 80% selesai, 20% dibatalkan
                }

                $jadwalData = [
                    'nama_kegiatan' => $namaKegiatan,
                    'tanggal' => $date->format('Y-m-d'),
                    'jam_mulai' => $jam[0],
                    'jam_selesai' => $jam[1],
                    'lokasi' => $lokasiLatihan[array_rand($lokasiLatihan)],
                    'cabang_olahraga_id' => $cabor->id,
                    'pelatih_id' => $pelatih->id,
                    'klub_id' => $klub ? $klub->id : null,
                    'catatan' => rand(1, 3) == 1 ? $catatanLatihan[array_rand($catatanLatihan)] : null,
                    'status' => $status
                ];

                try {
                    JadwalLatihan::create($jadwalData);
                    $totalCreated++;
                } catch (\Exception $e) {
                    // Skip jika ada error (misal jadwal bentrok)
                    continue;
                }
            }
        }

        // Tambahan: Generate jadwal latihan rutin (mingguan)
        $jadwalRutin = [
            1 => ['Senin', 'Latihan Rutin Senin'], // Monday
            3 => ['Rabu', 'Latihan Rutin Rabu'],   // Wednesday  
            5 => ['Jumat', 'Latihan Rutin Jumat'], // Friday
        ];

        // Generate jadwal rutin untuk 2 bulan ke depan
        $startWeek = Carbon::now()->startOfWeek();
        for ($week = 0; $week < 8; $week++) { // 8 minggu
            foreach ($jadwalRutin as $dayOfWeek => $rutinInfo) {
                $tanggalLatihan = $startWeek->copy()->addWeeks($week)->addDays($dayOfWeek - 1);

                if ($tanggalLatihan->isFuture()) {
                    $cabor = $cabors->random();
                    $pelatihCabor = $pelatihs->where('cabang_olahraga_id', $cabor->id);
                    $pelatih = $pelatihCabor->count() > 0 ? $pelatihCabor->random() : $pelatihs->random();

                    $jam = $jamLatihan[array_rand($jamLatihan)];

                    $jadwalRutinData = [
                        'nama_kegiatan' => $rutinInfo[1] . ' - ' . $cabor->nama_cabang,
                        'tanggal' => $tanggalLatihan->format('Y-m-d'),
                        'jam_mulai' => $jam[0],
                        'jam_selesai' => $jam[1],
                        'lokasi' => $lokasiLatihan[array_rand($lokasiLatihan)],
                        'cabang_olahraga_id' => $cabor->id,
                        'pelatih_id' => $pelatih->id,
                        'klub_id' => $klubs->count() > 0 && rand(1, 2) == 1 ? $klubs->random()->id : null,
                        'catatan' => 'Jadwal latihan rutin ' . $rutinInfo[0],
                        'status' => 'aktif'
                    ];

                    try {
                        JadwalLatihan::create($jadwalRutinData);
                        $totalCreated++;
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
        }

        $this->command->info("JadwalLatihanSeeder selesai. Total {$totalCreated} jadwal latihan berhasil dibuat.");
    }
}
