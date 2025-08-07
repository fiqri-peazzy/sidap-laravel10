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
        Schema::create('pelatih', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telepon', 20);
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->unsignedBigInteger('klub_id');
            $table->unsignedBigInteger('cabang_olahraga_id');
            $table->string('lisensi', 100)->nullable();
            $table->integer('pengalaman_tahun');
            $table->enum('status', ['aktif', 'nonaktif', 'cuti'])->default('aktif');
            $table->string('foto')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('klub_id')->references('id')->on('klub')->onDelete('cascade');
            $table->foreign('cabang_olahraga_id')->references('id')->on('cabang_olahraga')->onDelete('cascade');

            // Indexes
            $table->index(['status']);
            $table->index(['klub_id']);
            $table->index(['cabang_olahraga_id']);
            $table->index(['nama']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatih');
    }
};