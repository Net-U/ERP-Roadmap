@extends('layouts-admin.app')

@section('content')
  <div class="container pt-5 mt-4">

    {{-- Ringkasan Karyawan --}}
    <div class="card bg-light shadow-sm p-4 rounded-4 mb-5">
      <div class="row text-dark text-center">
        <div class="col-md-4 mb-3 mb-md-0">
          <div class="p-3 rounded bg-primary text-white">
            <h6><i class="fas fa-users me-1"></i> Total Karyawan</h6>
            <h4 class="fw-bold">{{ $totalEmployees }}</h4>
          </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
          <div class="p-3 rounded bg-success text-white">
            <h6><i class="fas fa-layer-group me-1"></i> Jumlah Grade</h6>
            <h4 class="fw-bold">{{ $grades->count() }}</h4>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded bg-info text-white">
            <h6><i class="fas fa-briefcase me-1"></i> Posisi Terbanyak</h6>
            <h4 class="fw-bold">{{ $topPosition ?? '-' }}</h4>
          </div>
        </div>
      </div>
    </div>

{{-- Card Import Karyawan --}}
<div class="card shadow-sm p-4 rounded-4 border-0  mt-5">
  <h4 class="mb-4 text-dark fw-bold">
    <i class="fas fa-user-plus me-2 text-primary"></i> Import Data Karyawan via Excel
  </h4>

  {{-- Success Message --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Error Message --}}
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan:</strong>
      <ul class="mb-0 mt-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Form Import --}}
    <form action="{{ route('admin.employees.import.store') }}" method="POST" enctype="multipart/form-data">
    
    @csrf

    <div class="mb-4">
      <label for="file_karyawan" class="form-label fw-semibold">
        📄 Upload File Excel 
        <span class="text-muted small d-block">Format yang diterima: .xlsx atau .xls</span>
      </label>
      <div class="input-group">
        <label class="input-group-text bg-light border-end-0" for="file_karyawan">
          <i class="fas fa-file-excel text-success"></i>
        </label>
        <input 
          type="file" 
          name="file" 
          id="file_karyawan" 
          class="form-control @error('file') is-invalid @enderror" 
          accept=".xlsx,.xls" 
          required>
        @error('file')
          <div class="invalid-feedback d-block mt-1">
            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
          </div>
        @enderror
      </div>
      <div class="form-text mt-2" id="fileNameDisplayKaryawan">Belum ada file yang dipilih</div>
    </div>

    <div class="d-flex justify-content-between">
      <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
      </a>
      <button type="submit" class="btn btn-success" >
        <i class="fas fa-upload me-1"></i> Import Sekarang
      </button>
    </div>
  </form>
</div>


    {{-- Chart: Karyawan per Tahun --}}
    @if(isset($years) && isset($gradeEmployeeData))
      <div class="card bg-secondary text-white shadow p-4 mb-4 rounded-4">
        <h5 class="mb-3">📊 Statistik Karyawan per Tahun</h5>
        <canvas id="chart1" height="100"></canvas>
      </div>
    @endif

    {{-- Chart: Distribusi Grade --}}
    @if(isset($gradeLabels) && isset($gradeCounts))
      <div class="card bg-dark text-white shadow p-4 rounded-4 mb-5">
        <h5 class="mb-3">📈 Distribusi Grade Karyawan</h5>
        <canvas id="chart2" height="120"></canvas>
      </div>
    @endif

  </div>

  {{-- Scripts --}}
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  <script src="{{ asset('assets/js/app-script.js') }}"></script>

  {{-- Chart 1 --}}
  @if(isset($years) && isset($gradeEmployeeData))
  <script>
    new Chart(document.getElementById('chart1'), {
      type: 'line',
      data: {
        labels: @json($years),
        datasets: @json($gradeEmployeeData)
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            labels: { color: '#fff' }
          },
          title: {
            display: true,
            text: 'Jumlah Karyawan per Grade per Tahun',
            color: '#fff',
            font: { size: 18, weight: 'bold' }
          }
        },
        scales: {
          x: { ticks: { color: '#fff' }, grid: { color: '#444' } },
          y: { beginAtZero: true, ticks: { color: '#fff' }, grid: { color: '#444' } }
        }
      }
    });
  </script>
  @endif

  {{-- Chart 2 --}}
  @if(isset($gradeLabels) && isset($gradeCounts))
  <script>
    new Chart(document.getElementById('chart2'), {
      type: 'doughnut',
      data: {
        labels: @json($gradeLabels),
        datasets: [{
          data: @json($gradeCounts),
          backgroundColor: ['#4bc0c0', '#36a2eb', '#ff6384', '#9966ff', '#ffcd56'],
          borderWidth: 2
        }]
      },
      options: {
        plugins: {
          legend: { position: 'bottom', labels: { color: '#fff' } }
        },
        cutout: '70%',
        responsive: true
      }
    });
  </script>
  @endif

  <script>
    document.getElementById('file_karyawan').addEventListener('change', function (e) {
      const fileName = e.target.files.length ? e.target.files[0].name : 'Belum ada file yang dipilih';
      document.getElementById('fileNameDisplayKaryawan').textContent = fileName;
    });
  </script>

  {{-- SweetAlert2 CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if (session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#198754',
        confirmButtonText: 'Oke'
      });
    </script>
  @endif

  @if (session('error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Tutup'
      });
    </script>
  @endif


@endsection
