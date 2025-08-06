<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klub', function (Blueprint $table) {
            $table->id();
            $table->string('nama_klub')->unique();
            $table->text('alamat');
            $table->string('kota', 100);
            $table->string('provinsi', 100);
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable()->unique();
            $table->year('tahun_berdiri')->nullable();
            $table->string('ketua_klub')->nullable();
            $table->string('sekretaris')->nullable();
            $table->string('bendahara')->nullable();
            $table->string('website')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            // Index untuk performa
            $table->index(['status', 'deleted_at']);
            $table->index(['kota', 'provinsi']);
            $table->index('nama_klub');
            $table->index('tahun_berdiri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klub');
    }
};