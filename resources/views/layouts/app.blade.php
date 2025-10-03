<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Dashboard')</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet.gridlayer.googlemutant@latest/Leaflet.GoogleMutant.js"></script>



  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  {{-- sidebar left --}}
  @include('sidebar.sidebar-left')

  {{-- topbar --}}
  <div class="topbar">
    <div></div>
    <div class="dropdown">
      <button class="btn-account dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
        <i class="bi bi-person-circle"></i> <span class="d-none d-md-inline">Akun</span>
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
        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
      </ul>
    </div>
  </div>

  {{-- sidebar right --}}
  @include('sidebar.sidebar-right')

  {{-- bottom bar --}}
  @include('sidebar.bottom-bar')

  {{-- main content --}}
  <main class="pt-3">
    @yield('content')
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @stack('scripts')
</body>
</html>
