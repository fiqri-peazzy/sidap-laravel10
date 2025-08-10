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
        Schema::create('atlit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nik', 20)->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');

            $table->string('telepon', 20)->nullable();
            $table->string('email')->unique()->nullable();


            $table->unsignedBigInteger('klub_id');
            $table->unsignedBigInteger('cabang_olahraga_id');
            $table->unsignedBigInteger('kategori_atlit_id');
            $table->string('foto')->nullable();
            $table->text('prestasi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'pensiun'])->default('aktif');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('klub_id')->references('id')->on('klub')->onDelete('cascade');
            $table->foreign('cabang_olahraga_id')->references('id')->on('cabang_olahraga')->onDelete('cascade');
            $table->foreign('kategori_atlit_id')->references('id')->on('kategori_atlit')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->index(['klub_id', 'status']);
            $table->index(['cabang_olahraga_id', 'status']);
            $table->index(['kategori_atlit_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('atlit');
    }
};
