@extends('layouts-admin.app')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">
    <div class="row mt-4 mb-5">
      <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
         <div class="card-header text-white text-center py-3">
          <h4 class="mb-0 fw-semibold">Tambahkan Akun Karyawan</h4>
          </div>

          <div class="card-body px-4 py-4">
            <form action="{{ route('admin.accounts.store') }}" method="POST">
              @csrf

              {{-- Pilih Karyawan --}}
              <div class="form-group mb-3">
                <label for="employee_id" class="form-label fw-semibold text-dark">Pilih Karyawan</label>
                <select name="employee_id" id="employee_id" class="form-control" required>
                  <option value="">-- Pilih Karyawan --</option>
                  @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                  @endforeach
                </select>
              </div>

              {{-- Email --}}
              <div class="form-group mb-3">
                <label class="form-label fw-semibold text-dark">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email karyawan" required>
              </div>

              {{-- Role --}}
              <div class="form-group mb-3">
                <label class="form-label fw-semibold text-dark">Role</label>
                <select name="role" class="form-control" required>
                  <option value="">-- Pilih Role --</option>
                  <option value="manajer">Manajer</option>
                  <option value="asmen">Asisten Manajer</option>
                  <option value="sekretariat">Admin Sekretariat</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
              </div>

              {{-- Password --}}
              <div class="form-group mb-3">
                <label class="form-label fw-semibold text-dark">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
              </div>

              {{-- Konfirmasi Password --}}
              <div class="form-group mb-4">
                <label class="form-label fw-semibold text-dark">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
              </div>

              {{-- Tombol --}}
              <div class="text-left">
                <button 
                  type="submit" 
                  class="btn btn-success px-5 py-2 fw-semibold custom-submit-btn">
                  <i class="bi bi-check-lg me-1"></i> Buat Akun
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
@endsection
