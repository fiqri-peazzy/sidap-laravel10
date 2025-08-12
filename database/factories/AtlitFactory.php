<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Atlit;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use App\Models\Klub;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Atlit>
 */
class AtlitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Atlit::class;

    public function definition()
    {
        $jk = $this->faker->randomElement(['L', 'P']);
        $tanggalLahir = $this->faker->dateTimeBetween('-35 years', '-15 years');

        return [
            'nama_lengkap' => $this->faker->name(),
            'nik' => $this->faker->unique()->numerify('##########'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $tanggalLahir,
            'jenis_kelamin' => $jk,
            'alamat' => $this->faker->address(),

            'telepon' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),

            'klub_id' => Klub::factory(),
            'cabang_olahraga_id' => Cabor::factory(),
            'kategori_atlit_id' => KategoriAtlit::factory(),

            'prestasi' => $this->faker->optional(0.6)->paragraph(),
            'status' => $this->faker->randomElement(['aktif', 'nonaktif', 'pensiun']),
        ];
    }
}
