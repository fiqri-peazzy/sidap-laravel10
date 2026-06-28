<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cabor;
use App\Models\KategoriAtlit;

class KategoriAtlitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil semua cabang olahraga
        $cabors = Cabor::all();

        $kategoriData = [
            'Taekwondo' => ['Kyorugi', 'Poomsae', 'Hanbon Kyorugi', 'Para Taekwondo'],
            'Karate' => ['Kumite', 'Kata', 'Team Kata', 'Team Kumite'],
            'Pencak Silat' => ['Tanding', 'Tunggal', 'Ganda', 'Regu'],
            'Sepak Bola' => ['Senior', 'Junior', 'Futsal', 'Beach Soccer'],
            'Bulu Tangkis' => ['Tunggal Putra', 'Tunggal Putri', 'Ganda Putra', 'Ganda Putri', 'Ganda Campuran'],
            'Renang' => ['Gaya Bebas', 'Gaya Punggung', 'Gaya Dada', 'Gaya Kupu-kupu', 'Gaya Ganti'],
            'Atletik' => ['Lari Jarak Pendek', 'Lari Jarak Menengah', 'Lari Jarak Jauh', 'Lompat Jauh', 'Lompat Tinggi', 'Lempar Lembing', 'Tolak Peluru'],
        ];

        // Baca dari JSON hasil ekstrak
        $atletJson = file_get_contents(database_path('seeders/atlet_data.json'));
        $atletDataList = json_decode($atletJson, true);

        if ($atletDataList) {
            foreach ($atletDataList as $data) {
                if (empty($data['cabor']) || empty($data['nomor_spesialis']) || $data['nama'] === 'JUMLAH') {
                    continue;
                }
                $caborName = trim($data['cabor']);
                $kategoriName = trim($data['nomor_spesialis']);
                
                if (!isset($kategoriData[$caborName])) {
                    $kategoriData[$caborName] = [];
                }
                
                if (!in_array($kategoriName, $kategoriData[$caborName])) {
                    $kategoriData[$caborName][] = $kategoriName;
                }
            }
        }

        foreach ($cabors as $cabor) {
            $namaKategori = $kategoriData[$cabor->nama_cabang] ?? ['Umum', 'Prestasi'];

            foreach ($namaKategori as $kategori) {
                KategoriAtlit::firstOrCreate(
                    [
                        'cabang_olahraga_id' => $cabor->id,
                        'nama_kategori' => $kategori
                    ],
                    [
                        'deskripsi' => "Kategori $kategori untuk cabang olahraga {$cabor->nama_cabang}",
                        'status' => 'aktif',
                    ]
                );
            }
        }
    }
}
