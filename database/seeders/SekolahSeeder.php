<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahData = [
            [
                'npsn' => '40501234',
                'nama_sekolah' => 'SMA Negeri 1 Gorontalo',
                'jenjang' => 'SMA',
                'alamat' => 'Jl. Nani Wartabone No. 3',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96115',
                'telepon' => '0435-821001',
                'email' => 'sman1.gorontalo@sch.id',
                'kepala_sekolah' => 'Dra. Hj. Rahmawati',
                'status' => 'aktif',
            ],
            [
                'npsn' => '40501235',
                'nama_sekolah' => 'SMA Negeri 2 Gorontalo',
                'jenjang' => 'SMA',
                'alamat' => 'Jl. Sultan Botutihe No. 10',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96128',
                'telepon' => '0435-821002',
                'email' => 'sman2.gorontalo@sch.id',
                'kepala_sekolah' => 'Drs. Anwar Suleman',
                'status' => 'aktif',
            ],
            [
                'npsn' => '40501236',
                'nama_sekolah' => 'SMK Negeri 1 Gorontalo',
                'jenjang' => 'SMK',
                'alamat' => 'Jl. Kasuari No. 7',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96135',
                'telepon' => '0435-821003',
                'email' => 'smkn1.gorontalo@sch.id',
                'kepala_sekolah' => 'Ir. Hamzah Yusuf',
                'status' => 'aktif',
            ],
        ];

        foreach ($sekolahData as $data) {
            $sekolah = Sekolah::create($data);

            if ($sekolah->nama_sekolah === 'SMA Negeri 1 Gorontalo') {
                $sekolah->createUser('sekolah@pplp.test', 'sekolah123');
            }
        }
    }
}
