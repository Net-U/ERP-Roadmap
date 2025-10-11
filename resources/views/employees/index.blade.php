@extends('layouts-admin.app')

@section('content')
<div class="content-wrapper" style="min-height: 100vh; background-color: #f8f9fa; padding: 20px;">
  
  <div class="card shadow-sm border-0">
    <div class="card-header bg-success text-white text-center py-3">
      <h4 class="mb-0 fw-semibold">Daftar Seluruh Karyawan</h4>
    </div>

    <div class="card-body">

      <!-- 🔍 Form Pencarian -->
      <form action="{{ route('admin.employees.index') }}" method="GET" class="mb-4">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Cari karyawan..." 
                 value="{{ request('search') }}">
          <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Cari</button>
        </div>
      </form>

      <!-- 📋 Tabel Data -->
      <div class="table-responsive">
        <table class="table table-striped align-middle text-center mb-0">
          <thead class="table-success">
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
              <tr>
                <td class="text-start">{{ $employee->name }}</td>
                <td>{{ $employee->nrk }}</td>
                <td>{{ $employee->nik_sap }}</td>
                <td class="text-start">{{ $employee->email }}</td>
                <td>{{ $employee->position->name ?? '-' }}</td>
                <td>
                  {{ $employee->grade ? $employee->grade->code . ' - ' . $employee->grade->grade_name : '-' }}
                </td>
                <td>{{ \Carbon\Carbon::parse($employee->join_date)->format('d M Y') }}</td>
                <td>
                  <a href="{{ route('admin.employees.show', $employee->id) }}" class="btn btn-success btn-sm">Detail</a>
                  <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-warning btn-sm text-white">Update</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-muted py-4">Tidak ada data karyawan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- 📁 Tombol Import (hanya admin) -->
      @if (Auth::user()->role === 'admin')
        <div class="mt-4">
          <a href="{{ route('admin.employees.import') }}" class="btn btn-outline-success btn-sm">
            <i class="bi bi-upload"></i> Import Data Karyawan
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
