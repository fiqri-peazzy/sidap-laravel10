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
                'nama_klub' => 'Manado United FC',
                'alamat' => 'Jl. Pierre Tendean No. 15',
                'kota' => 'Manado',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '95111',
                'telepon' => '0431-862345',
                'email' => 'info@manadounited.com',
                'tahun_berdiri' => 2010,
                'ketua_klub' => 'Bapak Roni Mandagi',
                'sekretaris' => 'Ibu Sarah Lengkey',
                'bendahara' => 'Bapak David Wowiling',
                'website' => 'https://www.manadounited.com',
                'deskripsi' => 'Klub sepak bola profesional yang bermarkas di Manado, Sulawesi Utara. Didirikan dengan visi mengembangkan sepak bola di kawasan Indonesia Timur.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Sepak Bola']
            ],
            [
                'nama_klub' => 'PB Sulut Jaya',
                'alamat' => 'Jl. Sam Ratulangi No. 45',
                'kota' => 'Manado',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '95112',
                'telepon' => '0431-851234',
                'email' => 'pbsulutjaya@gmail.com',
                'tahun_berdiri' => 2005,
                'ketua_klub' => 'Bapak Jeffry Roring',
                'sekretaris' => 'Ibu Maya Rumende',
                'bendahara' => 'Bapak Steven Kawengian',
                'deskripsi' => 'Persatuan Bulutangkis yang fokus pada pengembangan atlet muda berbakat di Sulawesi Utara.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Bulu Tangkis']
            ],
            [
                'nama_klub' => 'Basket Minahasa Club',
                'alamat' => 'Jl. Diponegoro No. 88',
                'kota' => 'Tomohon',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '95416',
                'telepon' => '0431-351789',
                'email' => 'bmc.minahasa@yahoo.com',
                'tahun_berdiri' => 2012,
                'ketua_klub' => 'Bapak Michael Sumilat',
                'sekretaris' => 'Ibu Grace Pangkey',
                'bendahara' => 'Bapak Ronny Tuerah',
                'website' => 'https://www.bmcminahasa.com',
                'deskripsi' => 'Klub bola basket yang mengembangkan talenta pemain basket di wilayah Minahasa dan sekitarnya.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Bola Basket']
            ],
            [
                'nama_klub' => 'Aquatic Center Manado',
                'alamat' => 'Jl. Boulevard Manado Town Square',
                'kota' => 'Manado',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '95115',
                'telepon' => '0431-889456',
                'email' => 'swimming@aquaticmanado.com',
                'tahun_berdiri' => 2015,
                'ketua_klub' => 'Bapak Richard Kalangi',
                'sekretaris' => 'Ibu Novi Legi',
                'bendahara' => 'Bapak Andy Taroreh',
                'website' => 'https://www.aquaticmanado.com',
                'deskripsi' => 'Pusat pelatihan renang modern dengan fasilitas lengkap untuk mengembangkan atlet renang berprestasi.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Renang']
            ],
            [
                'nama_klub' => 'Volley Bitung Prima',
                'alamat' => 'Jl. Yos Sudarso No. 25',
                'kota' => 'Bitung',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '95512',
                'telepon' => '0438-21567',
                'email' => 'vbprima@gmail.com',
                'tahun_berdiri' => 2008,
                'ketua_klub' => 'Bapak Franky Lumentut',
                'sekretaris' => 'Ibu Stella Mandagi',
                'bendahara' => 'Bapak Denny Waworuntu',
                'deskripsi' => 'Klub bola voli yang berfokus pada pengembangan atlet voli di Kota Bitung dan sekitarnya.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Voli']
            ],
            [
                'nama_klub' => 'Dojo Karate Sulut',
                'alamat' => 'Jl. Martadinata No. 12',
                'kota' => 'Manado',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '95113',
                'telepon' => '0431-123890',
                'email' => 'karate.sulut@gmail.com',
                'tahun_berdiri' => 2000,
                'ketua_klub' => 'Sensei Bambang Tumbuan',
                'sekretaris' => 'Ibu Linda Pontoh',
                'bendahara' => 'Bapak Dedi Maengkom',
                'deskripsi' => 'Dojo karate tertua di Sulawesi Utara yang telah menghasilkan banyak karateka berprestasi tingkat nasional.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Karate']
            ],
            [
                'nama_klub' => 'Athletic Club Manado',
                'alamat' => 'Stadion Klabat, Jl. Klabat',
                'kota' => 'Manado',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '95118',
                'telepon' => '0431-567123',
                'email' => 'athletic.manado@yahoo.com',
                'tahun_berdiri' => 2007,
                'ketua_klub' => 'Bapak Robby Supit',
                'sekretaris' => 'Ibu Merry Kolondam',
                'bendahara' => 'Bapak Tony Lasut',
                'website' => 'https://www.acmanado.org',
                'deskripsi' => 'Klub atletik yang mengembangkan atlet lari, lompat, dan lempar untuk kompetisi regional dan nasional.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Atletik']
            ],
            [
                'nama_klub' => 'Taekwondo Minahasa Utara',
                'alamat' => 'Jl. Trans Sulawesi No. 34',
                'kota' => 'Airmadidi',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '95371',
                'telepon' => '0431-345678',
                'email' => 'tkd.minut@gmail.com',
                'tahun_berdiri' => 2013,
                'ketua_klub' => 'Master Erik Wuisan',
                'sekretaris' => 'Ibu Christy Kaunang',
                'bendahara' => 'Bapak Jefri Tumbelaka',
                'deskripsi' => 'Klub taekwondo yang fokus pada pembinaan atlet muda di wilayah Minahasa Utara.',
                'status' => 'aktif',
                'cabang_olahraga' => ['Taekwondo']
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