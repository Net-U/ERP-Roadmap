@extends('layouts-admin.app')

@section('content')
<div class="container py-4">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-success text-white text-center py-3 rounded-top">
          <h4 class="mb-0 fw-semibold">Edit Data Karyawan</h4>
        </div>

        <div class="card-body bg-light">

          {{-- Notifikasi Error --}}
          @if ($errors->any())
            <div class="alert alert-danger rounded-3">
              <strong>Terjadi Kesalahan:</strong>
              <ul class="mb-0 mt-2 ps-3">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          {{-- Form Edit --}}
          <form action="{{ route('admin.employees.update', $employee->id) }}" 
                method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            @method('PUT')

            {{-- Form partial --}}
            @include('register.form', [
                'employee' => $employee,
                'departments' => $departments,
                'positions' => $positions,
                'grades' => $grades
            ])

            {{-- Persetujuan --}}
            <div class="form-check mt-3 mb-3">
              <input type="checkbox" class="form-check-input" id="terms" required>
              <label class="form-check-label small" for="terms">
                Saya menyetujui syarat & ketentuan yang berlaku
              </label>
            </div>

            {{-- Tombol --}}
            <div class="text-center">
              <button type="submit" class="btn btn-success px-5 py-2 fw-semibold">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
              </button>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>


</div>

{{-- Script logika tampil spouse field --}}
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const maritalStatus = document.getElementById("maritalStatus");
    const spouseFields = document.getElementById("spouseFields");
    if (maritalStatus && spouseFields) {
      const toggleSpouseFields = () => {
        spouseFields.style.display = maritalStatus.value === "Menikah" ? "block" : "none";
      };
      maritalStatus.addEventListener("change", toggleSpouseFields);
      toggleSpouseFields();
    }
  });
</script>
@endsection
