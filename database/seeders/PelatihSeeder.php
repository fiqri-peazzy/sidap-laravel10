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

        $pelatihJson = file_get_contents(database_path('seeders/pelatih_data.json'));
        $pelatihDataList = json_decode($pelatihJson, true);

        if (!$pelatihDataList) {
            $this->command->error('File pelatih_data.json tidak ditemukan atau kosong.');
            return;
        }

        foreach ($pelatihDataList as $data) {
            if ($data['nama'] === 'JUMLAH') continue;

            $cabor = null;
            if ($data['cabor']) {
                $cabor = Cabor::where('nama_cabang', $data['cabor'])->first();
            }
            $caborId = $cabor ? $cabor->id : $cabangOlahragas->random()->id;
            
            $klubId = $klubs->random()->id;

            Pelatih::create([
                'nama' => $data['nama'],
                'email' => $faker->unique()->safeEmail,
                'telepon' => $faker->phoneNumber,
                'alamat' => $data['alamat'] ?? $faker->address,
                'tanggal_lahir' => $faker->dateTimeBetween('-50 years', '-25 years')->format('Y-m-d'),
                'jenis_kelamin' => $data['jk'] ?? $faker->randomElement($jenisKelaminOptions),
                'klub_id' => $klubId,
                'cabang_olahraga_id' => $caborId,
                'lisensi' => $faker->boolean(70) ? 'LISENSI-' . $faker->numerify('###') . '-2023' : null,
                'pengalaman_tahun' => $faker->numberBetween(1, 25),
                'status' => 'aktif',
            ]);
        }

        $this->command->info('Pelatih seeder completed successfully with real names!');
    }
}