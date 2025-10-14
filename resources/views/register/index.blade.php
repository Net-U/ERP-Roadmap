@extends('layouts-admin.app')

@section('content')
<div class="content-wrapper py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-header bg-success text-white text-center py-3 rounded-top">
            <h4 class="mb-0 fw-semibold">Form Registrasi Karyawan</h4>
          </div>

          <div class="card-body px-4 py-4">
            
            {{-- 🔻 Alert error --}}
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('admin.register.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              {{-- ==================== DATA PRIBADI ==================== --}}
              <h5 class="text-dark fw-bold mb-3 mt-2 border-bottom pb-2">Data Pribadi</h5>

              <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">NRK</label>
                  <input type="text" name="nrk" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">NIK SAP</label>
                  <input type="text" name="nik_sap" class="form-control">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Tempat Lahir</label>
                  <input type="text" name="place_of_birth" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Tanggal Lahir</label>
                  <input type="date" name="date_of_birth" class="form-control">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Jenis Kelamin</label>
                  <select name="gender" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Agama</label>
                  <input type="text" name="religion" class="form-control">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Golongan Darah</label>
                  <select name="blood_type" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Nomor Identitas (KTP)</label>
                  <input type="text" name="identity_number" class="form-control">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Alamat Domisili</label>
                <textarea name="address" class="form-control" rows="2"></textarea>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Kecamatan</label>
                  <input type="text" name="district" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Kota/Kabupaten</label>
                  <input type="text" name="city" class="form-control">
                </div>
              </div>

              <hr class="my-4">

              {{-- ==================== DATA PEKERJAAN ==================== --}}
              <h5 class="text-dark fw-bold mb-3 border-bottom pb-2">Data Pekerjaan</h5>

              <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Tanggal Masuk</label>
                <input type="date" name="join_date" class="form-control">
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Departemen</label>
                  <select name="department_id" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach ($departments as $dept)
                      <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Posisi</label>
                  <select name="position_id" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach ($positions as $pos)
                      <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Sub Bagian</label>
                  <input type="text" name="subdivision" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Grade</label>
                  <select name="grade_id" class="form-select">
                    <option value="">-- Pilih Grade --</option>
                    @foreach ($grades as $grade)
                      <option value="{{ $grade->id }}">{{ $grade->code }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <hr class="my-4">

              {{-- ==================== KONTAK & STATUS ==================== --}}
              <h5 class="text-dark fw-bold mb-3 border-bottom pb-2">Kontak & Status</h5>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">Email</label>
                  <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-dark">No. HP</label>
                  <input type="text" name="phone" class="form-control">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Status Pernikahan</label>
                <select name="marital_status" id="maritalStatus" class="form-select">
                  <option value="">-- Pilih --</option>
                  <option value="Lajang">Lajang</option>
                  <option value="Menikah">Menikah</option>
                </select>
              </div>

              <div id="spouseFields" style="display: none;">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label text-dark">Jumlah Anak</label>
                    <input type="number" name="children_count" class="form-control" min="0">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label text-dark">Nama Pasangan</label>
                    <input type="text" name="spouse_name" class="form-control">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label text-dark">Pekerjaan Pasangan</label>
                    <input type="text" name="spouse_job" class="form-control">
                  </div>
                </div>
              </div>

              <hr class="my-4">

              {{-- ==================== KESEHATAN ==================== --}}
              <h5 class="text-dark fw-bold mb-3 border-bottom pb-2">Kesehatan</h5>

              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label text-dark">Vaksin 1</label>
                  <select name="vaccine_1" class="form-select">
                    <option value="">-- Status --</option>
                    <option value="1">✓ Sudah</option>
                    <option value="0">✗ Belum</option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label text-dark">Vaksin 2</label>
                  <select name="vaccine_2" class="form-select">
                    <option value="">-- Status --</option>
                    <option value="1">✓ Sudah</option>
                    <option value="0">✗ Belum</option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label text-dark">Vaksin 3</label>
                  <select name="vaccine_3" class="form-select">
                    <option value="">-- Status --</option>
                    <option value="1">✓ Sudah</option>
                    <option value="0">✗ Belum</option>
                  </select>
                </div>
              </div>

              <hr class="my-4">

              {{-- ==================== AHLI WARIS ==================== --}}
              <h5 class="text-dark fw-bold mb-3 border-bottom pb-2">Data Ahli Waris</h5>

              <div class="mb-3">
                <label class="form-label text-dark">Nama Ahli Waris</label>
                <input type="text" name="heir_name" class="form-control" required>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label text-dark">Hubungan</label>
                  <input type="text" name="heir_relationship" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-dark">Nomor HP</label>
                  <input type="text" name="heir_phone" class="form-control">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label text-dark">Alamat</label>
                <input type="text" name="heir_address" class="form-control">
              </div>

              {{-- Upload Foto --}}
              <hr class="my-4">
              <h5 class="text-dark fw-bold mb-3 border-bottom pb-2">Upload Foto</h5>

              <div class="mb-4">
                <input type="file" name="photo" class="form-control" accept="image/*">
              </div>

              {{-- Persetujuan --}}
              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="terms" required>
                <label class="form-check-label" for="terms">Saya menyetujui syarat & ketentuan</label>
              </div>

              <div class="text-left">
                <button 
                  type="submit" 
                  class="btn btn-success px-5 py-2 fw-semibold custom-submit-btn">
                  <i class="bi bi-check-lg me-1"></i> Simpan Data
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<style>
  /* Warna default tombol */
  .custom-submit-btn {
    background-color: #155b46 !important;
    border: none !important;
    transition: all 0.3s ease;
  }

  /* Efek hover */
  .custom-submit-btn:hover {
    background-color: #1e7b60 !important; /* Hijau muda seperti sebelumnya */
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
  }

  /* Saat ditekan (active) */
  .custom-submit-btn:active {
    background-color: #134d3c !important; /* sedikit lebih gelap */
    transform: scale(0.98);
  }
</style>
{{-- Script --}}
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const maritalStatus = document.getElementById("maritalStatus");
    const spouseFields = document.getElementById("spouseFields");

    function toggleSpouseFields() {
      spouseFields.style.display = maritalStatus.value === "Menikah" ? "block" : "none";
    }

    maritalStatus.addEventListener("change", toggleSpouseFields);
    toggleSpouseFields();
  });
</script>

@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      icon: 'success',
      title: 'Sukses',
      text: '{{ session("success") }}',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'OK'
    });
  });
</script>
@endif
@endsection
