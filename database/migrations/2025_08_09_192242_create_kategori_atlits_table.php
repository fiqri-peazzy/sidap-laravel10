<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kategori_atlit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cabang_olahraga_id');
            $table->string('nama_kategori');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('cabang_olahraga_id')->references('id')->on('cabang_olahraga')->onDelete('cascade');
            $table->index(['cabang_olahraga_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_atlit');
    }
};
