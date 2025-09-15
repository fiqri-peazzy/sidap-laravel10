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
        Schema::create('dokumen_atlit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atlit_id')->constrained('atlit')->onDelete('cascade');
            $table->enum('kategori_berkas', ['Ijazah', 'Akta Kelahiran', 'Kartu Pelajar', 'Dokumen Pendukung']);
            $table->string('nama_file');
            $table->string('file_path');
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->text('alasan_ditolak')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            // Index untuk performa
            $table->index(['atlit_id', 'kategori_berkas']);
            $table->index('status_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_atlit');
    }
};
