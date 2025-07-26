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
        Schema::create('tool_usages', function (Blueprint $table) {
            $table->id(); // ID peminjaman (PK)

            $table->string('nama_peminjam');             // Nama lengkap peminjam
            $table->string('nim_nip_nidn');              // Nomor identitas
            $table->string('jurusan')->nullable();       // Jurusan/Instansi peminjam
            $table->string('nama_alat');                 // Nama alat yang dipinjam
            $table->string('jumlah');                    // Jumlah alat dipinjam
            $table->date('peminjaman');                  // Tanggal pinjam
            $table->date('pengembalian');                // Tanggal kembali
            $table->text('keterangan')->nullable();      // Catatan tambahan
            $table->string('paraf_peminjam')->nullable(); // Bisa disimpan sebagai path image/tanda tangan
            $table->string('paraf_petugas')->nullable();  // Tanda tangan petugas

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_usages');
    }
};
