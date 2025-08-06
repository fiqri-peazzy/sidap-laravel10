<?php

namespace Database\Seeders;

use App\Models\Cabor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaborSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabangOlahraga = [
            [
                'nama_cabang' => 'Sepak Bola',
                'deskripsi' => 'Olahraga beregu yang dimainkan oleh dua tim beranggotakan sebelas orang yang berusaha memasukkan bola ke gawang lawan.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Bulu Tangkis',
                'deskripsi' => 'Olahraga raket yang dimainkan oleh dua orang (tunggal) atau dua pasangan (ganda) yang saling berlawanan.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Bola Basket',
                'deskripsi' => 'Olahraga beregu yang dimainkan oleh dua tim beranggotakan lima orang yang berusaha mencetak poin dengan memasukkan bola ke keranjang lawan.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Voli',
                'deskripsi' => 'Olahraga beregu yang dimainkan oleh dua tim beranggotakan enam orang yang dipisahkan oleh net.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Renang',
                'deskripsi' => 'Olahraga yang melombakan kecepatan atlet renang dalam berenang di berbagai nomor dan gaya.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Atletik',
                'deskripsi' => 'Cabang olahraga yang terdiri dari nomor lari, lompat, lempar, dan jalan cepat.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Tenis Meja',
                'deskripsi' => 'Olahraga yang menggunakan raket untuk memukul bola celluloid melewati net di atas meja.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Angkat Besi',
                'deskripsi' => 'Olahraga yang melombakan angkatan beban terberat dalam dua gerakan: snatch dan clean & jerk.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Karate',
                'deskripsi' => 'Seni bela diri yang berasal dari Jepang yang menggunakan teknik pukulan, tendangan, dan tangkisan.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Taekwondo',
                'deskripsi' => 'Seni bela diri yang berasal dari Korea yang menekankan pada teknik tendangan tinggi dan cepat.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Panahan',
                'deskripsi' => 'Olahraga yang menggunakan busur untuk menembakkan anak panah ke target.',
                'status' => 'aktif'
            ],
            [
                'nama_cabang' => 'Senam',
                'deskripsi' => 'Olahraga yang melibatkan latihan pada berbagai alat atau di lantai dengan gerakan yang memerlukan kekuatan, fleksibilitas, dan koordinasi.',
                'status' => 'aktif'
            ]
        ];

        foreach ($cabangOlahraga as $cabang) {
            Cabor::create($cabang);
        }
    }
}