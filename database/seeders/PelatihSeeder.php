<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelatih;
use App\Models\Klub;
use App\Models\Cabor;
use Faker\Factory as Faker;

class PelatihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $klubs = Klub::all();
        $cabangOlahragas = Cabor::all();

        if ($klubs->isEmpty() || $cabangOlahragas->isEmpty()) {
            $this->command->error('Harap jalankan seeder Klub dan CabangOlahraga terlebih dahulu!');
            return;
        }

        $statusOptions = ['aktif', 'nonaktif', 'cuti'];
        $jenisKelaminOptions = ['L', 'P'];

        // Data pelatih dummy
        $pelatihData = [
            [
                'nama' => 'Ahmad Fauzi, S.Pd',
                'email' => 'ahmad.fauzi@pplpgorontalo.com',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Sudirman No. 123, Kota Gorontalo',
                'tanggal_lahir' => '1985-03-15',
                'jenis_kelamin' => 'L',
                'lisensi' => 'LISENSI-001-2023',
                'pengalaman_tahun' => 12,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Siti Nurhaliza, M.Pd',
                'email' => 'siti.nurhaliza@pplpgorontalo.com',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Ahmad Yani No. 456, Kota Gorontalo',
                'tanggal_lahir' => '1988-07-22',
                'jenis_kelamin' => 'P',
                'lisensi' => 'LISENSI-002-2023',
                'pengalaman_tahun' => 8,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Muhammad Ridwan',
                'email' => 'muhammad.ridwan@pplpgorontalo.com',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Diponegoro No. 789, Kota Gorontalo',
                'tanggal_lahir' => '1982-11-08',
                'jenis_kelamin' => 'L',
                'lisensi' => 'LISENSI-003-2023',
                'pengalaman_tahun' => 15,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Dewi Kartika, S.Or',
                'email' => 'dewi.kartika@pplpgorontalo.com',
                'telepon' => '081234567893',
                'alamat' => 'Jl. Gajah Mada No. 321, Kota Gorontalo',
                'tanggal_lahir' => '1990-05-30',
                'jenis_kelamin' => 'P',
                'lisensi' => 'LISENSI-004-2023',
                'pengalaman_tahun' => 6,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Bambang Susilo',
                'email' => 'bambang.susilo@pplpgorontalo.com',
                'telepon' => '081234567894',
                'alamat' => 'Jl. Veteran No. 654, Kota Gorontalo',
                'tanggal_lahir' => '1979-12-14',
                'jenis_kelamin' => 'L',
                'lisensi' => null,
                'pengalaman_tahun' => 18,
                'status' => 'cuti'
            ]
        ];

        foreach ($pelatihData as $data) {
            $data['klub_id'] = $klubs->random()->id;
            $data['cabang_olahraga_id'] = $cabangOlahragas->random()->id;

            Pelatih::create($data);
        }

        for ($i = 0; $i < 15; $i++) {
            Pelatih::create([
                'nama' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'telepon' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'tanggal_lahir' => $faker->dateTimeBetween('-50 years', '-25 years')->format('Y-m-d'),
                'jenis_kelamin' => $faker->randomElement($jenisKelaminOptions),
                'klub_id' => $klubs->random()->id,
                'cabang_olahraga_id' => $cabangOlahragas->random()->id,
                'lisensi' => $faker->boolean(70) ? 'LISENSI-' . str_pad($i + 6, 3, '0', STR_PAD_LEFT) . '-2023' : null,
                'pengalaman_tahun' => $faker->numberBetween(1, 25),
                'status' => $faker->randomElement($statusOptions),
            ]);
        }

        $this->command->info('Pelatih seeder completed successfully!');
    }
}