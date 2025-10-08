<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi tabel employees.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Informasi dasar
            $table->string('name');                  // Nama lengkap
            $table->string('nrk')->nullable();       // Nomor Registrasi Karyawan
            $table->string('nik_sap')->nullable();   // NIK SAP (jika ada)
            $table->date('join_date');               // Tanggal masuk kerja
            $table->string('place_of_birth')->nullable(); // Tempat lahir
            $table->date('date_of_birth')->nullable();    // Tanggal lahir
            $table->string('gender')->nullable();         // Jenis kelamin
            $table->string('religion')->nullable();       // Agama
            $table->string('blood_type')->nullable();     // Golongan darah

            // Kontak & alamat
            $table->string('email')->nullable();       // Email
            $table->string('phone')->nullable();     // No HP
            $table->string('address')->nullable();   // Alamat domisili
            $table->string('district')->nullable();  // Kecamatan
            $table->string('city')->nullable();      // Kota/Kabupaten

            // Pendidikan
            $table->string('education')->nullable();     // Pendidikan terakhir
            $table->string('education_major')->nullable(); // Jurusan

            // Informasi pekerjaan
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade'); // Divisi
            $table->foreignId('position_id')->nullable()->constrained()->onDelete('cascade');   // Jabatan
            $table->foreignId('grade_id')->nullable()->constrained()->onDelete('set null'); // Grade
            $table->string('subdivision')->nullable();   // Sub Bagian

            // Kesehatan dan lainnya
            $table->string('bpjs_tk')->nullable();   // BPJS Ketenagakerjaan
            $table->string('bpjs_ks')->nullable();   // BPJS Kesehatan
            $table->string('npwp')->nullable();      // NPWP
            $table->string('identity_number')->nullable(); // No KTP
            $table->string('bank_account')->nullable();    // No rekening
            $table->string('spouse_job')->nullable();      // Pekerjaan pasangan
            $table->enum('marital_status', ['Lajang', 'Menikah'])->nullable(); // Status pernikahan
            $table->string('spouse_name')->nullable();
            $table->integer('children_count')->nullable(); // Jumlah anak

            // cuti
            $table->integer('total_cuti')->default(0); // Jumlah cuti();
            $table->year('last_cuti_update')->nullable();

            // Status vaksin
            $table->boolean('vaccine_1')->default(false);
            $table->boolean('vaccine_2')->default(false);
            $table->boolean('vaccine_3')->default(false);

            // Ahli waris
            $table->string('heir_name')->nullable();
            $table->string('heir_relationship')->nullable();
            $table->string('heir_phone')->nullable();
            $table->string('heir_address')->nullable();


            $table->string('photo')->nullable();     // Foto profil (jika ada)

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Rollback jika migrasi dibatalkan.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
