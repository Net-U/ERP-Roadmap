<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Dashboard')</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  
    <!-- Tambahkan ini di bawah link CSS Bootstrap atau lainnya -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  {{-- TOPBAR --}}
  <div class="topbar d-flex justify-content-between align-items-center px-3 py-2 bg-light border-bottom">
    <div class="d-flex align-items-center gap-2">
      <button id="togglePolygon" class="btn btn-outline-success btn-sm d-flex align-items-center">
        <i id="polygonIcon" class="fas fa-eye me-2"></i> Polygon
      </button>
    </div>

    <div class="dropdown">
      <button class="btn-account dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
        <i class="bi bi-person-circle me-2"></i> 
        <span class="d-none d-md-inline">Akun</span>
      </button>
      <ul class="dropdown-menu shadow account-menu">
        <li class="text-center p-3 border-bottom">
          <img src="https://i.ibb.co/3mBch4w/profile.png" alt="User" class="profile-pic-lg mb-2">
          <h6 class="fw-bold mb-0">Admin Sawit</h6>
          <small class="text-muted">admin@sawit.com</small>
        </li>
        <li><a class="dropdown-item" href="#"><i class="bi bi-person-lines-fill me-2"></i>Profil Saya</a></li>
        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
              <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>

  {{-- === LAYOUT === --}}
  <div class="d-flex">
    {{-- SIDEBAR --}}
    @include('sidebar.sidebar-left')
  
    {{-- sidebar left --}}
    @include('sidebar.sidebar-right')
    

    {{-- bottom bar --}}
    @include('sidebar.bottom-bar')


    {{-- MAIN CONTENT --}}
    <main class="main-content flex-grow-1 p-4">
      {{-- CONTENT --}}
      @yield('content')
    </main>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet.gridlayer.googlemutant@latest/Leaflet.GoogleMutant.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- SweetAlert Flash Message -->
  <script>
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    @endif

    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
      });
    @endif
  </script>

  <!-- Custom JS -->
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @stack('scripts')
</body>
</html>
