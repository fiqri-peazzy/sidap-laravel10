<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atlit_id')->constrained('atlit')->onDelete('cascade');
            $table->foreignId('cabang_olahraga_id')->constrained('cabang_olahraga')->onDelete('cascade');
            $table->string('nama_kejuaraan');
            $table->string('jenis_kejuaraan'); // Nasional, Internasional, Regional, dll
            $table->string('tingkat_kejuaraan'); // PON, POPNAS, SEA Games, Asian Games, dll
            $table->string('tempat_kejuaraan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->year('tahun');
            $table->string('nomor_pertandingan')->nullable(); // Untuk cabor yang ada nomor/kategori
            $table->enum('peringkat', ['1', '2', '3', '4', '5', '6', '7', '8', 'partisipasi']);
            $table->string('medali')->nullable(); // Emas, Perak, Perunggu
            $table->text('keterangan')->nullable();
            $table->string('sertifikat')->nullable(); // File sertifikat/foto
            $table->enum('status', ['verified', 'pending', 'rejected'])->default('pending');
            $table->timestamps();

            // Index untuk optimasi query
            $table->index(['atlit_id', 'tahun']);
            $table->index(['cabang_olahraga_id', 'tahun']);
            $table->index('tahun');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
