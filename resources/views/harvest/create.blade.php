@extends('layouts-admin.app')

@section('title', 'Input Hasil Panen')

@section('content')
<div class="container-fluid">
  <div class="row mt-4 mb-5">
    <div class="col-lg-8 mx-auto">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-success text-white text-center py-3 rounded-top">
          <h4 class="mb-0 fw-semibold">Input Data Hasil Panen</h4>
        </div>

        <div class="card-body px-4 py-4">
          <form action="{{ route('admin.harvest.store') }}" method="POST">
            @csrf

            {{-- Pilih Karyawan --}}
            <div class="form-group mb-3">
              <label for="employee_id" class="form-label fw-semibold text-dark">Nama Pekerja</label>
              <select name="employee_id" id="employee_id" class="form-control" required>
                <option value="">-- Pilih Pekerja --</option>
                @foreach ($employees as $employee)
                  <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->identity_number }})</option>
                @endforeach
              </select>
            </div>

            {{-- Pilih Blok --}}
            <div class="form-group mb-3">
              <label for="blok_kebun_id" class="form-label fw-semibold text-dark">Blok Kebun</label>
              <select name="blok_kebun_id" id="blok_kebun_id" class="form-control" required>
                <option value="">-- Pilih Blok --</option>
                @foreach ($blokKebun as $blok)
                  <option value="{{ $blok->id }}">{{ $blok->kode_blok }}</option>
                @endforeach
              </select>
            </div>

            {{-- AFD --}}
            <div class="form-group mb-3">
              <label class="form-label fw-semibold text-dark">AFD</label>
              <input type="text" name="afd" class="form-control" placeholder="Masukkan AFD" required>
            </div>

            {{-- Jenis Kerja --}}
            <div class="form-group mb-3">
              <label class="form-label fw-semibold text-dark">Jenis Kerja</label>
              <input type="text" name="kerja" class="form-control" placeholder="Contoh: Panen" required>
            </div>

            {{-- Total Janjang --}}
            <div class="form-group mb-3">
              <label class="form-label fw-semibold text-dark">Total Janjang</label>
              <input type="number" name="ttl_janjang" class="form-control" placeholder="Masukkan total janjang" required>
            </div>

            {{-- Tonase --}}
            <div class="form-group mb-3">
              <label class="form-label fw-semibold text-dark">Tonase (kg)</label>
              <input type="number" step="0.01" name="tonase" class="form-control" placeholder="Masukkan tonase hasil panen" required>
            </div>

            {{-- Tanggal Panen --}}
            <div class="form-group mb-4">
              <label class="form-label fw-semibold text-dark">Tanggal Panen</label>
              <input type="date" name="tanggal_panen" class="form-control" required>
            </div>

            {{-- Tombol Submit --}}
            <div class="text-left">
              <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">
                <i class="bi bi-check-lg me-1"></i> Simpan Data
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
