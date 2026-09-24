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
            $table->unsignedBigInteger('sekolah_id')->nullable()->after('klub_id');

            $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('set null');
            $table->index(['sekolah_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atlit', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropIndex(['sekolah_id', 'status']);
            $table->dropColumn('sekolah_id');
        });
    }
};
