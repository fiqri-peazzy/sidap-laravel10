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
        Schema::create('jadwal_latihan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('lokasi');
            $table->unsignedBigInteger('cabang_olahraga_id');
            $table->unsignedBigInteger('pelatih_id');
            $table->unsignedBigInteger('klub_id')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->timestamps();

            $table->foreign('cabang_olahraga_id')->references('id')->on('cabang_olahraga');
            $table->foreign('pelatih_id')->references('id')->on('pelatih');
            $table->foreign('klub_id')->references('id')->on('klub');

            $table->index(['tanggal', 'status']);
            $table->index('cabang_olahraga_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_latihan');
    }
};