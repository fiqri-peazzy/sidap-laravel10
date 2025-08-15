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
        Schema::create('event_atlit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_event_id');
            $table->unsignedBigInteger('atlit_id');
            $table->timestamps();

            $table->foreign('jadwal_event_id')->references('id')->on('jadwal_event')->onDelete('cascade');
            $table->foreign('atlit_id')->references('id')->on('atlit')->onDelete('cascade');

            $table->unique(['jadwal_event_id', 'atlit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_atlit');
    }
};