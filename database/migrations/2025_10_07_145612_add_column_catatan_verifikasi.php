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
        Schema::table('atlit', function (Blueprint $table) {
            $table->renameColumn('alasan_ditolak', 'catatan_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atlit', function (Blueprint $table) {
            $table->renameColumn('catatan_verifikasi', 'alasan_ditolak');
        });
    }
};
