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
            // Tambahkan kolom verifikasi jika belum ada
            if (!Schema::hasColumn('atlit', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('status');
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('atlit', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }

            if (!Schema::hasColumn('atlit', 'alasan_ditolak')) {
                $table->text('alasan_ditolak')->nullable()->after('verified_at');
            }

            // Update status default jika belum ada
            if (!Schema::hasColumn('atlit', 'status') || Schema::getColumnType('atlit', 'status') !== 'string') {
                $table->string('status')->default('pending')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atlit', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['verified_by']);

            // Drop columns
            $table->dropColumn(['verified_by', 'verified_at', 'alasan_ditolak']);
        });
    }
};
