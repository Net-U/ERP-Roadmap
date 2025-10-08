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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->integer('year');
            $table->integer('month');
            $table->decimal('basic_salary', 12, 2); // otomatis dari grade
            $table->decimal('tunjangan_keluarga', 12, 2)->default(0);
            $table->decimal('tunjangan_kematian', 12, 2)->default(0);
            $table->decimal('tunjangan_lainnya', 12, 2)->default(0);
            $table->decimal('deduction', 12, 2)->default(0);
            $table->timestamps();

            // ⬅️ Tambahkan ini agar kombinasi unik dijaga
            $table->unique(['employee_id', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
