<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prestasi;
use App\Models\Atlit;
use App\Models\Cabor;
use Carbon\Carbon;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data atlit dan cabor yang ada
        $atlits = Atlit::aktif()->get();
        $cabors = Cabor::aktif()->get();

        if ($atlits->isEmpty() || $cabors->isEmpty()) {
            $this->command->warn('Silakan jalankan AtlitSeeder dan CaborSeeder terlebih dahulu!');
            return;
        }

        $kejuaraan = [
            [
                'nama' => 'Pekan Olahraga Nasional (PON) XXI Papua 2024',
                'jenis' => 'Nasional',
                'tingkat' => 'PON',
                'tempat' => 'Papua, Indonesia',
            ],
            [
                'nama' => 'Pekan Olahraga Pelajar Nasional (POPNAS) XVII',
                'jenis' => 'Nasional',
                'tingkat' => 'POPNAS',
                'tempat' => 'Banjarmasin, Kalimantan Selatan',
            ],
            [
                'nama' => 'SEA Games 32nd',
                'jenis' => 'Internasional',
                'tingkat' => 'SEA Games',
                'tempat' => 'Phnom Penh, Cambodia',
            ],
            [
                'nama' => 'Asian Games XIX',
                'jenis' => 'Internasional',
                'tingkat' => 'Asian Games',
                'tempat' => 'Hangzhou, China',
            ],
            [
                'nama' => 'Kejuaraan Nasional Pelajar',
                'jenis' => 'Nasional',
                'tingkat' => 'Nasional',
                'tempat' => 'Jakarta, Indonesia',
            ],
            [
                'nama' => 'Porprov Sulawesi Utara 2024',
                'jenis' => 'Regional',
                'tingkat' => 'Porprov',
                'tempat' => 'Manado, Sulawesi Utara',
            ],
            [
                'nama' => 'Kejuaraan Nasional Junior & Senior',
                'jenis' => 'Nasional',
                'tingkat' => 'Nasional',
                'tempat' => 'Surabaya, Jawa Timur',
            ],
            [
                'nama' => 'Porprov Gorontalo 2024',
                'jenis' => 'Provinsi',
                'tingkat' => 'Porprov',
                'tempat' => 'Gorontalo, Indonesia',
            ],
        ];

        $nomorPertandingan = [
            // Atletik
            ['100m Putra', '200m Putra', '400m Putra', '800m Putra', '1500m Putra', 'Lompat Jauh Putra'],
            ['100m Putri', '200m Putri', '400m Putri', '800m Putri', '1500m Putri', 'Lompat Jauh Putri'],
            // Renang
            ['50m Bebas Putra', '100m Bebas Putra', '200m Bebas Putra', '100m Kupu-kupu Putra'],
            ['50m Bebas Putri', '100m Bebas Putri', '200m Bebas Putri', '100m Kupu-kupu Putri'],
            // Badminton
            ['Tunggal Putra', 'Ganda Putra', 'Ganda Campuran'],
            ['Tunggal Putri', 'Ganda Putri'],
            // Sepak Bola
            ['Tim Putra', 'Tim Putri'],
            // Bola Basket
            ['Tim Putra', 'Tim Putri'],
            // Tenis Meja
            ['Tunggal Putra', 'Ganda Putra', 'Tunggal Putri', 'Ganda Putri'],
            // Karate
            ['Kata Individu Putra', 'Kumite -60kg Putra', 'Kata Individu Putri', 'Kumite -55kg Putri'],
        ];

        $this->command->info('Membuat data prestasi...');
        $bar = $this->command->getOutput()->createProgressBar(50);

        for ($i = 0; $i < 50; $i++) {
            $atlit = $atlits->random();
            $kejuaraanData = $kejuaraan[array_rand($kejuaraan)];
            $tahun = rand(2020, 2024);

            // Tanggal random dalam tahun yang dipilih
            $tanggalMulai = Carbon::create($tahun, rand(1, 12), rand(1, 28));
            $tanggalSelesai = $tanggalMulai->copy()->addDays(rand(1, 14));

            // Peringkat random dengan bobot (lebih banyak juara 1-3)
            $peringkatOptions = ['1', '1', '1', '2', '2', '3', '3', '4', '5', 'partisipasi'];
            $peringkat = $peringkatOptions[array_rand($peringkatOptions)];

            // Set medali berdasarkan peringkat
            $medali = null;
            if ($peringkat == '1') $medali = 'Emas';
            elseif ($peringkat == '2') $medali = 'Perak';
            elseif ($peringkat == '3') $medali = 'Perunggu';

            // Nomor pertandingan random
            $nomorOptions = array_merge(...$nomorPertandingan);
            $nomor = (rand(0, 1) == 1) ? $nomorOptions[array_rand($nomorOptions)] : null;

            // Keterangan random
            $keteranganOptions = [
                'Pencapaian terbaik dalam kategori ini',
                'Prestasi membanggakan untuk PPLP Gorontalo',
                'Hasil kerja keras latihan intensif',
                'Meningkat dari prestasi sebelumnya',
                null,
                null // lebih banyak yang null
            ];

            $keterangan = $keteranganOptions[array_rand($keteranganOptions)];

            Prestasi::create([
                'atlit_id' => $atlit->id,
                'cabang_olahraga_id' => $atlit->cabang_olahraga_id, // sesuai dengan cabor atlit
                'nama_kejuaraan' => $kejuaraanData['nama'],
                'jenis_kejuaraan' => $kejuaraanData['jenis'],
                'tingkat_kejuaraan' => $kejuaraanData['tingkat'],
                'tempat_kejuaraan' => $kejuaraanData['tempat'],
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'tahun' => $tahun,
                'nomor_pertandingan' => $nomor,
                'peringkat' => $peringkat,
                'medali' => $medali,
                'keterangan' => $keterangan,
                'status' => ['verified', 'verified', 'verified', 'pending'][array_rand(['verified', 'verified', 'verified', 'pending'])], // 75% verified
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('Data prestasi berhasil dibuat!');

        // Tampilkan statistik
        $total = Prestasi::count();
        $verified = Prestasi::where('status', 'verified')->count();
        $pending = Prestasi::where('status', 'pending')->count();
        $juara1 = Prestasi::where('peringkat', '1')->count();
        $medaliEmas = Prestasi::where('medali', 'Emas')->count();

        $this->command->table(
            ['Keterangan', 'Jumlah'],
            [
                ['Total Prestasi', $total],
                ['Prestasi Terverifikasi', $verified],
                ['Prestasi Pending', $pending],
                ['Juara 1', $juara1],
                ['Medali Emas', $medaliEmas],
            ]
        );
    }
}
