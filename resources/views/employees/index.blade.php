@extends('layouts-admin.app')

@section('content')
<div class="content-wrapper" style="min-height: 100vh; background-color: #eef6f0; padding: 25px;">
  
  <div class="card shadow-sm border-0">
    <div class="card-header text-white text-center py-3">
      <h4 class="mb-0 fw-semibold text-uppercase">DAFTAR SELURUH KARYAWAN</h4>
    </div>

    <div class="card-body px-4 py-4">

      <!-- 🔍 Form Pencarian -->
      <form action="{{ route('admin.employees.index') }}" method="GET" class="mb-4">
        <div class="input-group">
          <input 
            type="text" 
            name="search" 
            class="form-control border-success shadow-sm" 
            placeholder="Cari karyawan..." 
            value="{{ request('search') }}"
          >
          <button class="btn btn-success fw-semibold" type="submit" style="background-color: #155b46;">
            <i class="bi bi-search me-1"></i> Cari
          </button>
        </div>
      </form>

      <!-- 📋 Tabel Data -->
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center mb-0 border">
          <thead class="bg-success text-white">
            <tr>
              <th>Nama</th>
              <th>NRK</th>
              <th>NIK SAP</th>
              <th>Email</th>
              <th>Posisi</th>
              <th>Grade</th>
              <th>Tanggal Masuk</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($employees as $employee)
              <tr class="align-middle">
                <td class="text-start fw-semibold text-dark">{{ $employee->name }}</td>
                <td class="text-secondary">{{ $employee->nrk }}</td>
                <td class="text-secondary">{{ $employee->nik_sap }}</td>
                <td class="text-start text-muted">{{ $employee->email }}</td>
                <td class="text-dark">{{ $employee->position->name ?? '-' }}</td>
                <td class="text-dark">
                  {{ $employee->grade ? $employee->grade->code . ' - ' . $employee->grade->grade_name : '-' }}
                </td>
                <td class="text-dark">{{ \Carbon\Carbon::parse($employee->join_date)->format('d M Y') }}</td>
                <td>
                  <a href="{{ route('admin.employees.show', $employee->id) }}" 
                     class="btn btn-outline-success btn-sm fw-semibold">
                    <i class="bi bi-eye"></i> Detail
                  </a>
                  <a href="{{ route('admin.employees.edit', $employee->id) }}" 
                     class="btn btn-warning btn-sm text-white fw-semibold">
                    <i class="bi bi-pencil-square"></i> Update
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-muted py-4 fst-italic">Tidak ada data karyawan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- 📁 Tombol Import (hanya admin) -->
      @if (Auth::user()->role === 'admin')
        <div class="mt-4 text-left ">
          <a href="{{ route('admin.employees.import') }}" 
             class="btn btn-outline-success btn-sm px-4 fw-semibold shadow-sm" style="background-color: #155b46;">
            <i class="bi bi-upload me-1"></i> Import Data Karyawan
          </a>
        </div>
      @endif

      <!-- Pagination -->
      <div class="pagination-container mt-4 d-flex justify-content-center">
        {{ $employees->links('pagination::bootstrap-5') }}
      </div>

    </div>
  </div>
</div>
@endsection
