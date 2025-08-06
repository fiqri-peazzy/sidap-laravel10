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
        Schema::create('klub_cabang_olahraga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klub_id')->constrained('klub')->onDelete('cascade');
            $table->foreignId('cabang_olahraga_id')->constrained('cabang_olahraga')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            // Unique constraint untuk mencegah duplikasi
            $table->unique(['klub_id', 'cabang_olahraga_id']);

            // Index untuk performa
            $table->index(['klub_id', 'status']);
            $table->index(['cabang_olahraga_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klub_cabang_olahraga');
    }
};