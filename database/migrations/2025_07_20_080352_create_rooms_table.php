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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // otomatis jadi nomor urut (primary key)
            $table->string('nama_ruang');       // nama ruangan
            $table->string('kegiatan')->nullable(); // digunakan untuk apa (bisa kosong)
            $table->enum('status', ['tersedia', 'sedang diguanakan', 'maintenance'])->default('tersedia'); // status ruangan
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
