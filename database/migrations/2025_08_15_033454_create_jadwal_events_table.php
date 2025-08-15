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
        Schema::create('jadwal_event', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->enum('jenis_event', ['pertandingan', 'seleksi', 'uji_coba', 'kejuaraan']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('lokasi');
            $table->string('penyelenggara');
            $table->unsignedBigInteger('cabang_olahraga_id');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->timestamps();

            $table->foreign('cabang_olahraga_id')->references('id')->on('cabang_olahraga');

            $table->index(['tanggal_mulai', 'tanggal_selesai']);
            $table->index('cabang_olahraga_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_event');
    }
};