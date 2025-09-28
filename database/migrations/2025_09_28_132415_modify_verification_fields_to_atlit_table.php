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
            // Tambahkan kolom status_verifikasi jika belum ada
            if (!Schema::hasColumn('atlit', 'status_verifikasi')) {
                $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])
                    ->default('pending')
                    ->after('status');
            }
            // verified_by, verified_at, alasan_ditolak sudah ada di migrasi sebelumnya

            if (!Schema::hasColumn('atlit', 'status') || Schema::getColumnType('atlit', 'status') !== 'string') {
                $table->string('status')->default('nonaktif')->change();
            }
        });

        // Update status default jika belum ada

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atlit', function (Blueprint $table) {
            if (Schema::hasColumn('atlit', 'status_verifikasi')) {
                $table->dropColumn('status_verifikasi');
            }
        });
    }
};
