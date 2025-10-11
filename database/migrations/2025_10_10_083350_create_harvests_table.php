<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvests', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel pekerja (employees)
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');

            // Relasi ke blok kebun
            $table->foreignId('blok_kebun_id')->constrained('blok_kebun')->onDelete('cascade');

            // Data hasil panen
            $table->string('afd');             // AFD (afdeling)
            $table->string('kerja');           // Jenis kerja (misal: panen, angkut, dlsb)
            $table->integer('ttl_janjang');    // Total janjang
            $table->decimal('tonase', 8, 2);   // Berat hasil (tonase)
            $table->date('tanggal_panen');     // Tanggal panen

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};
