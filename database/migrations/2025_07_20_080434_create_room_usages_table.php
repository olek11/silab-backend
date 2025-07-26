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
        Schema::create('room_usages', function (Blueprint $table) {
            $table->id();

            $table->string('jenis_kegiatan');                // Contoh: Praktikum, Seminar, dll
            $table->string('judul_kegiatan');                // Judul spesifik kegiatan
            $table->date('hari_tanggal_mulai');              // Tanggal mulai
            $table->date('hari_tanggal_selesai');            // Tanggal selesai
            $table->time('jam_mulai');                       // Jam mulai
            $table->time('jam_selesai');                     // Jam selesai
            $table->string('penanggung_jawab');              // Nama penanggung jawab utama
            $table->string('asisten_penanggung_jawab');      // Nama asisten jika ada

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps(); // created_at & updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_usages');
    }
};
