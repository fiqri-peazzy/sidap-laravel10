<?php

namespace Database\Seeders;

use App\Models\Atlit;
use App\Models\Klub;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AtlitSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ada data klub, cabor, dan kategori
        $klubs = Klub::aktif()->get();
        $cabors = Cabor::aktif()->get();

        if ($klubs->isEmpty() || $cabors->isEmpty()) {
            $this->command->info('Tidak ada klub atau cabang olahraga aktif. Jalankan seeder untuk klub dan cabor terlebih dahulu.');
            return;
        }

        $atletJson = file_get_contents(database_path('seeders/atlet_data.json'));
        $atletData = json_decode($atletJson, true);

        if (!$atletData) {
            $this->command->info('File atlet_data.json tidak ditemukan atau kosong.');
            return;
        }

        foreach ($atletData as $data) {
            if ($data['nama'] === 'JUMLAH') {
                continue;
            }

            // Cari apakah atlet sudah ada berdasarkan nama_lengkap
            $atlit = Atlit::where('nama_lengkap', $data['nama'])->first();

            // Jika atlet sudah ada dan cabor di excel kosong, wariskan cabor sebelumnya
            if ($atlit && empty($data['cabor'])) {
                $caborId = $atlit->cabang_olahraga_id;
                $kategoriId = $atlit->kategori_atlit_id;
                $klubId = $atlit->klub_id; // Juga warisi klub jika kosong
            } else {
                $cabor = Cabor::where('nama_cabang', $data['cabor'])->first();
                $caborId = $cabor ? $cabor->id : $cabors->random()->id;
                
                $kategoriId = null;
                if (!empty($data['nomor_spesialis'])) {
                    $kategori = KategoriAtlit::where('cabang_olahraga_id', $caborId)
                        ->where('nama_kategori', trim($data['nomor_spesialis']))
                        ->aktif()
                        ->first();
                    if ($kategori) {
                        $kategoriId = $kategori->id;
                    }
                }

                if (!$kategoriId) {
                    $kategoriList = KategoriAtlit::where('cabang_olahraga_id', $caborId)->aktif()->get();
                    $kategoriId = $kategoriList->isNotEmpty() ? $kategoriList->random()->id : null;
                }

                $klubId = $klubs->random()->id;
            }

            if (!$kategoriId) continue;

            // Generate created_at random untuk variasi grafik dashboard (antara tahun atlet bergabung s.d sekarang)
            $randomMonth = rand(1, 12);
            $randomDay = rand(1, 28);
            $createdAt = \Carbon\Carbon::create($data['tahun'], $randomMonth, $randomDay);
            if ($createdAt->gt(now())) {
                $createdAt = now();
            }

            if ($atlit) {
                // Update profil terkini ke data tahun terbaru
                $atlit->update([
                    'klub_id' => $klubId,
                    'cabang_olahraga_id' => $caborId,
                    'kategori_atlit_id' => $kategoriId,
                    'created_at' => $atlit->created_at->gt($createdAt) ? $createdAt : $atlit->created_at, 
                ]);
            } else {
                // Buat atlet baru
                $baseEmail = strtolower(str_replace(' ', '.', trim($data['nama'])));
                $generatedEmail = $baseEmail . '@gmail.com';
                $counter = 1;
                while (Atlit::where('email', $generatedEmail)->exists()) {
                    $generatedEmail = $baseEmail . $counter . '@gmail.com';
                    $counter++;
                }

                $generatedNik = fake()->unique()->numerify('##########');
                $counterNik = 1;
                while (Atlit::where('nik', $generatedNik)->exists()) {
                    $generatedNik = substr($generatedNik, 0, 9) . $counterNik;
                    $counterNik++;
                }

                $atlit = Atlit::create([
                    'nama_lengkap' => $data['nama'],
                    'nik' => $generatedNik,
                    'tempat_lahir' => 'Gorontalo',
                    'tanggal_lahir' => fake()->dateTimeBetween('-25 years', '-15 years'),
                    'jenis_kelamin' => $data['jk'] ?? fake()->randomElement(['L', 'P']),
                    'alamat' => fake()->address(),
                    'telepon' => fake()->phoneNumber(),
                    'email' => $generatedEmail,
                    'klub_id' => $klubId,
                    'cabang_olahraga_id' => $caborId,
                    'kategori_atlit_id' => $kategoriId,
                    'prestasi' => fake()->paragraph(),
                    'status' => 'aktif',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            // Catat ke riwayat
            \App\Models\AtlitRiwayat::updateOrCreate(
                [
                    'atlit_id' => $atlit->id,
                    'tahun' => $data['tahun'],
                ],
                [
                    'klub_id' => $klubId,
                    'cabang_olahraga_id' => $caborId,
                    'kategori_atlit_id' => $kategoriId,
                    'status' => 'aktif',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]
            );

            // Buat atau dapatkan user
            if ($atlit->email) {
                // Periksa apakah user dengan email ini sudah ada (untuk menghindari duplicate)
                $user = User::where('email', $atlit->email)->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $atlit->nama_lengkap,
                        'email' => $atlit->email,
                        'password' => Hash::make('password123'),
                    ]);
                }

                $atlit->update(['user_id' => $user->id]);
            }
        }

        $this->command->info('Atlit seeder completed successfully with real names!');
    }
}
