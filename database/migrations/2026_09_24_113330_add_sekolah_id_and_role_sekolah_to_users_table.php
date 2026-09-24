<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum role lewat raw SQL — doctrine/dbal tidak bisa introspeksi
        // kolom bertipe "enum" saat memakai ->change() bawaan Laravel.
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user', 'verifikator', 'sekolah') NOT NULL DEFAULT 'user'");

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('sekolah_id')->nullable()->after('role');

            $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user', 'verifikator') NOT NULL DEFAULT 'user'");
    }
};
