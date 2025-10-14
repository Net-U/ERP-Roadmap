@extends('layouts-admin.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0 rounded-3">
        {{-- Header --}}
        <div class="card-header text-white text-center py-3 rounded-top" >
          <h4 class="mb-0 fw-semibold">Form Update Karyawan</h4>
        </div>

        {{-- Body --}}
        <div class="card-body bg-light">
          {{-- Pesan Error --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          {{-- Form --}}
          <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- DATA PRIBADI --}}
            <h5 class="fw-bold text-dark mt-3 mb-3 border-bottom pb-2">Data Pribadi</h5>

            <div class="form-group mb-3">
              <label class="text-dark fw-medium">Nama Lengkap</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $employee->name) }}" required>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">NRK</label>
                <input type="text" name="nrk" class="form-control @error('nrk') is-invalid @enderror"
                  value="{{ old('nrk', $employee->nrk) }}">
                @error('nrk') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">NIK SAP</label>
                <input type="text" name="nik_sap" class="form-control @error('nik_sap') is-invalid @enderror"
                  value="{{ old('nik_sap', $employee->nik_sap) }}">
                @error('nik_sap') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">Tempat Lahir</label>
                <input type="text" name="place_of_birth" class="form-control @error('place_of_birth') is-invalid @enderror"
                  value="{{ old('place_of_birth', $employee->place_of_birth) }}">
                @error('place_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror"
                  value="{{ old('birth_date', $employee->birth_date) }}">
                @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group mb-3">
              <label class="text-dark fw-medium">Jenis Kelamin</label>
              <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('gender', $employee->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender', $employee->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
              @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  value="{{ old('email', $employee->email) }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">No. HP</label>
                <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                  value="{{ old('phone_number', $employee->phone_number) }}">
                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group mb-3">
              <label class="text-dark fw-medium">Alamat</label>
              <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $employee->address) }}</textarea>
              @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- JABATAN --}}
            <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2">Jabatan & Status</h5>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">Pilih Jabatan</label>
                <select name="position_id" class="form-control @error('position_id') is-invalid @enderror">
                  <option value="">-- Pilih Jabatan --</option>
                  @foreach ($positions as $position)
                    <option value="{{ $position->id }}" {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                      {{ $position->name }}
                    </option>
                  @endforeach
                </select>
                @error('position_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                  <option value="">-- Pilih Status --</option>
                  <option value="Active" {{ old('status', $employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Inactive" {{ old('status', $employee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- AHLI WARIS --}}
            <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2">Data Ahli Waris</h5>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">Nama Ahli Waris</label>
                <input type="text" name="heir_name" class="form-control @error('heir_name') is-invalid @enderror"
                  value="{{ old('heir_name', $employee->heir_name) }}">
                @error('heir_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">Hubungan</label>
                <input type="text" name="heir_relationship" class="form-control @error('heir_relationship') is-invalid @enderror"
                  value="{{ old('heir_relationship', $employee->heir_relationship) }}">
                @error('heir_relationship') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">No. HP Ahli Waris</label>
                <input type="text" name="heir_phone" class="form-control @error('heir_phone') is-invalid @enderror"
                  value="{{ old('heir_phone', $employee->heir_phone) }}">
                @error('heir_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="text-dark fw-medium">Alamat Ahli Waris</label>
                <textarea name="heir_address" class="form-control @error('heir_address') is-invalid @enderror" rows="2">{{ old('heir_address', $employee->heir_address) }}</textarea>
                @error('heir_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- FOTO --}}
            <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2">Foto Karyawan</h5>
            @if ($employee->photo)
              <div class="mb-3">
                <img src="{{ asset('uploads/karyawan/' . $employee->photo) }}" width="120" class="rounded shadow-sm border" alt="Foto Karyawan">
              </div>
            @endif
            <div class="form-group mb-4">
              <label class="text-dark fw-medium">Ganti Foto</label>
              <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
              @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            {{-- TOMBOL --}}
            <div class="form-check mb-3">
              <input type="checkbox" class="form-check-input" id="terms" required>
              <label class="form-check-label" for="terms">Saya menyetujui syarat & ketentuan</label>
            </div>

            <div class="text-left">
              <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-save"></i> Simpan Perubahan
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
