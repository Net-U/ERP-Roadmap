@extends('layouts-admin.app')

@section('title', 'Laporan Hasil Panen')

@section('content')
<div class="container-fluid mt-4 mb-5">
  <div class="row">
    <div class="col-lg-10 mx-auto">

      <!-- Card Utama -->
      <div class="card shadow-sm border-0 rounded-3">

        <!-- Header -->
<div class="card-header text-white py-3 rounded-top">
  <div class="d-flex align-items-center justify-content-center position-relative">
    
    <!-- Form filter tanggal -->
    <form method="GET" action="{{ route('admin.harvest.index') }}" 
          class="d-flex align-items-center position-absolute start-0 ms-3">
      <i class="bi bi-calendar-event me-2 fs-5"></i>
      <input 
        type="date" 
        name="tanggal_panen" 
        value="{{ request('tanggal_panen') }}" 
        class="form-control form-control-sm me-2"
        style="width: 180px;">
      <button type="submit" class="btn btn-light btn-sm fw-semibold">Tampilkan</button>
    </form>

    <!-- Judul di tengah -->
    <h5 class="mb-0 fw-semibold text-uppercase text-center">Laporan Panen</h5>

  </div>
</div>


        <!-- Isi Tabel -->
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle text-center">
              <thead class="bg-light fw-semibold text-dark">
                <tr>
                  <th>NAMA</th>
                  <th>TANGGAL PANEN</th>
                  <th>NIK</th>
                  <th>AFD</th>
                  <th>BLOK</th>
                  <th>JANJANG</th>
                  <th>TONASE</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($harvests as $harvest)
                  <tr>
                    <td>{{ $harvest->employee->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($harvest->tanggal_panen)->format('d/m/Y') }}</td>
                    <td>{{ $harvest->employee->identity_number }}</td>
                    <td>{{ $harvest->afd }}</td>
                    <td>{{ $harvest->blokKebun->kode_blok }}</td>
                    <td>{{ $harvest->ttl_janjang }}</td>
                    <td>{{ number_format($harvest->tonase, 3, ',', '.') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-muted py-3">Belum ada data hasil panen.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-white text-center py-3">
          {{ $harvests->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
