<div class="sidebar" id="sidebar">
  <div id="toggle-sidebar-left" class="toggle-sidebar-left">
    <i class="bi bi-list"></i>
  </div>
  <hr>
  <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid"></i> <span>Dashboard</span>
  </a>
  <a href="#"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>
  <a href="#"><i class="bi bi-bar-chart"></i> <span>Rendemen</span></a>
  <a href="#"><i class="bi bi-people"></i> <span>Tenaga Kerja</span></a>
  <a href="#"><i class="bi bi-gear"></i> <span>Pengaturan</span></a>

  {{-- Menu hanya muncul kalau user admin --}}
  @if(Auth::check() && Auth::user()->role === 'admin')
    <a href="{{ route('admin.import-geojson') }}" 
      class="{{ request()->routeIs('admin.import-geojson') ? 'active' : '' }}">
      <i class="bi bi-upload"></i> <span>Import GeoJSON</span>
    </a>
  @endif
</div>
