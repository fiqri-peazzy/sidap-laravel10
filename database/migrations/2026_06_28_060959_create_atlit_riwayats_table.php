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
        Schema::create('atlit_riwayats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atlit_id');
            $table->year('tahun');
            $table->unsignedBigInteger('klub_id');
            $table->unsignedBigInteger('cabang_olahraga_id');
            $table->unsignedBigInteger('kategori_atlit_id');
            $table->enum('status', ['aktif', 'nonaktif', 'pensiun'])->default('aktif');
            $table->timestamps();

            $table->foreign('atlit_id')->references('id')->on('atlit')->onDelete('cascade');
            $table->foreign('klub_id')->references('id')->on('klub')->onDelete('cascade');
            $table->foreign('cabang_olahraga_id')->references('id')->on('cabang_olahraga')->onDelete('cascade');
            $table->foreign('kategori_atlit_id')->references('id')->on('kategori_atlit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atlit_riwayats');
    }
};
