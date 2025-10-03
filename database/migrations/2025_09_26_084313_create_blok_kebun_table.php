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
            Schema::create('blok_kebun', function (Blueprint $table) {
                $table->id();
                $table->string('kode_blok');
                $table->decimal('luas_ha', 8, 2);
                $table->json('geom'); // simpan polygon GeoJSON
                $table->integer('rotasi_panen'); // hari
                $table->date('tgl_panen_terakhir');
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blok_kebun');
    }
};
