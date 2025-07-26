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
        Schema::create('materials', function (Blueprint $table) {
            $table->id(); // bigint unsigned AUTO_INCREMENT
            $table->string('name', 255); // Nama bahan
            $table->string('jumlah_bahan', 255); // Jumlah stok atau ukuran
            $table->string('satuan', 50)->nullable(); // Satuan (gram, ml, pcs)
            $table->text('deskripsi')->nullable(); // Info tambahan bahan
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
