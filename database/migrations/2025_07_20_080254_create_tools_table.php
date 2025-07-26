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
        Schema::create('tools', function (Blueprint $table) {
            $table->id(); // bigint UNSIGNED AUTO_INCREMENT

            $table->string('nup')->nullable(); // Nullable
            $table->string('nama_alat');       // Not null
            $table->year('tahun_perolehan')->nullable();
            $table->string('merk_type');       // Not null
            $table->string('no_inventaris');   // Not null
            $table->integer('jumlah_alat');    // Not null
            $table->string('penguasaan');      // Not null
            $table->string('kondisi_alat')->nullable();
            $table->string('gambar_alat')->nullable(); // path gambar
            $table->text('deskripsi');         // Not null

            $table->timestamps(); // created_at & updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
