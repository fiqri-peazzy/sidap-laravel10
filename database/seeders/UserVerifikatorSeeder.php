<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserVerifikatorSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk user verifikator.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Verifikator SIDAP',
            'email' => 'verifikator@sidap.test',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman
            'role' => 'verifikator',

        ]);
    }
}