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

        // Buat beberapa atlit contoh
        foreach ($klubs->take(3) as $klub) {
            foreach ($cabors->take(2) as $cabor) {
                $kategoriList = KategoriAtlit::where('cabang_olahraga_id', $cabor->id)->aktif()->get();

                if ($kategoriList->isNotEmpty()) {
                    for ($i = 1; $i <= 3; $i++) {
                        $kategori = $kategoriList->random();

                        $atlit = Atlit::create([
                            'nama_lengkap' => fake()->name(),
                            'nik' => fake()->unique()->numerify('##########'),
                            'tempat_lahir' => fake()->city(),
                            'tanggal_lahir' => fake()->dateTimeBetween('-25 years', '-15 years'),
                            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
                            'alamat' => fake()->address(),

                            'telepon' => fake()->phoneNumber(),
                            'email' => fake()->unique()->safeEmail(),

                            'klub_id' => $klub->id,
                            'cabang_olahraga_id' => $cabor->id,
                            'kategori_atlit_id' => $kategori->id,

                            'prestasi' => fake()->optional(0.6)->paragraph(),
                            'status' => fake()->randomElement(['aktif', 'aktif', 'aktif', 'nonaktif']), // Lebih banyak aktif
                        ]);

                        if ($atlit->email) {
                            $user = User::create([
                                'name' => $atlit->nama_lengkap,
                                'email' => $atlit->email,
                                'password' => Hash::make('password123'),
                            ]);

                            $atlit->update(['user_id' => $user->id]);
                        }
                    }
                }
            }
        }

        $this->command->info('Atlit seeder completed successfully!');
    }
}
