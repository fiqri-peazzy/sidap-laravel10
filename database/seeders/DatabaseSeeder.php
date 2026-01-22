<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\JadwalEvent;
use App\Models\KategoriAtlit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserVerifikatorSeeder::class,
            CaborSeeder::class,
            KategoriAtlitSeeder::class,
            KlubSeeder::class,
            PelatihSeeder::class,
            AtlitSeeder::class,
            JadwalEventSeeder::class,
            JadwalLatihanSeeder::class,
            PrestasiSeeder::class,

        ]);
    }
}