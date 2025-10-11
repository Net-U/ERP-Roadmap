<div class="sidebar" id="sidebar">
  <!-- Header Sidebar -->
  <div id="sidebar-header" class="d-flex align-items-center justify-content-between px-3 pt-3">
    <!-- Tombol Toggle Sidebar -->
    <div id="toggle-sidebar-center" class="toggle-sidebar-center">
      <i class="bi bi-list fs-4"></i>
    </div>

    <!-- Tombol Switch Mode (Admin/User) -->
    @if(Auth::check() && Auth::user()->role === 'admin')
      <button id="switchModeBtn" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
        <i class="bi bi-shield-lock"></i> Admin
      </button>
    @endif
  </div>

  <hr>

  <!-- Bagian Menu Scrollable -->
  <div class="sidebar-menu px-2 pb-3">
    {{-- === MENU UMUM === --}}
    <div id="userMenu">
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid"></i> <span>Dashboard</span>
      </a>
      <a href="#"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>
      <a href="#"><i class="bi bi-bar-chart"></i> <span>Rendemen</span></a>
      <a href="#"><i class="bi bi-gear"></i> <span>Pengaturan</span></a>
    </div>

    {{-- === MENU ADMIN === --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
    <div id="adminMenu" style="display: none;">
      <a href="{{ route('admin.register.form') }}" class="{{ request()->routeIs('admin.register.form') ? 'active' : '' }}">
        <i class="bi bi-person-plus"></i> <span>Registration</span>
      </a>

      <a href="{{ route('admin.accounts.create') }}" class="{{ request()->routeIs('admin.accounts.create') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> <span>Tambah Akun</span>
      </a>

      <a href="{{ route('admin.employees.index') }}" class="{{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">
        <i class="bi bi-people"></i> <span>Karyawan</span>
      </a>

      <a href="{{ route('admin.harvest.create') }}" class="{{ request()->routeIs('admin.harvest.create') ? 'active' : '' }}">
        <i class="bi bi-tree-fill"></i> <span>Input Hasil Panen</span>
      </a>

      <a href="{{ route('admin.import-geojson') }}" class="{{ request()->routeIs('admin.import-geojson') ? 'active' : '' }}">
        <i class="bi bi-upload"></i> <span>Import GeoJSON</span>
      </a>
    </div>
    @endif
  </div>
</div>

<!-- Script Toggle Sidebar & Admin/User Mode -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  // ===== Toggle Sidebar =====
  const toggleBtn = document.getElementById('toggle-sidebar-center');
  const sidebar = document.getElementById('sidebar');

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      sidebar.classList.toggle('collapsed');
      // Optional: ganti ikon saat sidebar collapse
      const icon = toggleBtn.querySelector('i');
      if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('bi-list');
        icon.classList.add('bi-list');
      } else {
        icon.classList.remove('bi-list');
        icon.classList.add('bi-list');
      }
    });
  }

  // ===== Toggle Mode Admin/User =====
  const switchBtn = document.getElementById('switchModeBtn');
  const userMenu = document.getElementById('userMenu');
  const adminMenu = document.getElementById('adminMenu');
  if (!switchBtn) return;

  // Deteksi apakah route saat ini adalah admin.*
  const currentRouteIsAdmin = "{{ str_contains(Route::currentRouteName(), 'admin.') ? 'true' : 'false' }}" === 'true';
  let isAdminMode = currentRouteIsAdmin;

  function updateMenu() {
    if (isAdminMode) {
      userMenu.style.display = 'none';
      adminMenu.style.display = 'block';
      switchBtn.innerHTML = '<i class="bi bi-person"></i> User';
      switchBtn.classList.remove('btn-outline-primary');
      switchBtn.classList.add('btn-outline-success');
    } else {
      userMenu.style.display = 'block';
      adminMenu.style.display = 'none';
      switchBtn.innerHTML = '<i class="bi bi-shield-lock"></i> Admin';
      switchBtn.classList.remove('btn-outline-success');
      switchBtn.classList.add('btn-outline-primary');
    }
  }

  updateMenu();

  switchBtn.addEventListener('click', function () {
    isAdminMode = !isAdminMode;
    updateMenu();
  });
});
</script>
