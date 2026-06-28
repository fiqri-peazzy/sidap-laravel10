<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Klub;
use App\Models\Cabor;

class KlubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $klubData = [
            [
                'nama_klub' => 'Klub Sepak Takraw Gorontalo',
                'alamat' => 'Jl. P. Kalengkongan No. 12',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96115',
                'telepon' => '0435-123456',
                'email' => 'takraw.gorontalo@gmail.com',
                'tahun_berdiri' => 2010,
                'ketua_klub' => 'Bapak Budi Hartono',
                'sekretaris' => 'Ibu Sri Wahyuni',
                'bendahara' => 'Bapak Ahmad',
                'deskripsi' => 'Klub Sepak Takraw kebanggaan Gorontalo.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Sepak Takraw']
            ],
            [
                'nama_klub' => 'Dojo Karate Gorontalo',
                'alamat' => 'Jl. Jenderal Sudirman No. 45',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96128',
                'telepon' => '0435-654321',
                'email' => 'karate.gorontalo@yahoo.com',
                'tahun_berdiri' => 2005,
                'ketua_klub' => 'Bapak Hendra',
                'sekretaris' => 'Ibu Ningsih',
                'bendahara' => 'Bapak Yusuf',
                'deskripsi' => 'Dojo Karate di pusat kota Gorontalo.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Karate']
            ],
            [
                'nama_klub' => 'Padepokan Silat Gorontalo',
                'alamat' => 'Jl. H.B. Jassin No. 88',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96111',
                'telepon' => '0435-351789',
                'email' => 'silat.gorontalo@gmail.com',
                'tahun_berdiri' => 2012,
                'ketua_klub' => 'Bapak Iwan',
                'sekretaris' => 'Ibu Ratna',
                'bendahara' => 'Bapak Usman',
                'deskripsi' => 'Padepokan pencak silat terbesar di Gorontalo.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Pencak Silat']
            ],
            [
                'nama_klub' => 'Athletic Gorontalo',
                'alamat' => 'Stadion Merdeka',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96118',
                'telepon' => '0435-567123',
                'email' => 'athletic.gtlo@gmail.com',
                'tahun_berdiri' => 2008,
                'ketua_klub' => 'Bapak Rudi',
                'sekretaris' => 'Ibu Rina',
                'bendahara' => 'Bapak Taufik',
                'deskripsi' => 'Klub atletik yang berpusat di Stadion Merdeka.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Atletik']
            ],
            [
                'nama_klub' => 'Taekwondo Gorontalo',
                'alamat' => 'Jl. Agus Salim',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96115',
                'telepon' => '0435-889456',
                'email' => 'taekwondo.gtlo@gmail.com',
                'tahun_berdiri' => 2015,
                'ketua_klub' => 'Bapak Dedi',
                'sekretaris' => 'Ibu Nia',
                'bendahara' => 'Bapak Anton',
                'deskripsi' => 'Pusat pelatihan taekwondo Gorontalo.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Taekwondo']
            ],
            [
                'nama_klub' => 'Klub Tenis Meja Gorontalo',
                'alamat' => 'Jl. Nani Wartabone',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96113',
                'telepon' => '0435-123890',
                'email' => 'tenismeja.gtlo@gmail.com',
                'tahun_berdiri' => 2000,
                'ketua_klub' => 'Bapak Ali',
                'sekretaris' => 'Ibu Yanti',
                'bendahara' => 'Bapak Hasan',
                'deskripsi' => 'Klub Tenis Meja legendaris Gorontalo.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Tenis Meja']
            ],
            [
                'nama_klub' => 'Anggar Club Gorontalo',
                'alamat' => 'Jl. Budi Utomo',
                'kota' => 'Gorontalo',
                'provinsi' => 'Gorontalo',
                'kode_pos' => '96118',
                'telepon' => '0435-567123',
                'email' => 'anggar.gtlo@gmail.com',
                'tahun_berdiri' => 2007,
                'ketua_klub' => 'Bapak Aris',
                'sekretaris' => 'Ibu Maya',
                'bendahara' => 'Bapak Roni',
                'deskripsi' => 'Klub anggar pertama di Gorontalo.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Anggar']
            ]
        ];

        foreach ($klubData as $data) {
            $cabangOlahragaNames = $data['cabang_olahraga'];
            unset($data['cabang_olahraga']);

            $klub = Klub::create($data);

            foreach ($cabangOlahragaNames as $cabangName) {
                $cabangOlahraga = Cabor::where('nama_cabang', $cabangName)->first();
                if ($cabangOlahraga) {
                    $klub->cabangOlahraga()->attach($cabangOlahraga->id);
                }
            }
        }
    }
}