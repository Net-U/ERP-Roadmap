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
        // Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Nama lengkap user
            $table->string('username')->unique(); // Username unik
            $table->string('email')->unique(); // Email unik
            $table->timestamp('email_verified_at')->nullable(); // Waktu verifikasi email
            $table->string('password'); // Password terenkripsi

            // ✅ Kolom role (ganti is_admin)
            // Menggunakan enum agar terbatas pada 'admin' dan 'user' saja
            $table->enum('role', [
                'manajer',
                'asmen',
                'sekretariat',
                'admin',
                'user'
            ])->default('user');

            $table->rememberToken(); // Token untuk fitur "remember me"
            $table->timestamps(); // Kolom created_at & updated_at
        });

        // Tabel untuk reset password
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabel session (jika menggunakan fitur session Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
