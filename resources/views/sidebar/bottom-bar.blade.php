<div class="bottom-bar closed" id="bottomBar">
  <!-- Tombol Toggle -->
  <button class="toggle-btn" id="toggleBtn">
    <i class="bi bi-caret-down-fill"></i>
  </button>

  {{-- PRODUKSI 3 HARI TERAKHIR --}}
  <div class="production-container" id="productionContainer">
    <div class="text-center text-muted small">Memuat data...</div>
  </div>

  {{-- GRAFIK BULANAN --}}
  <div class="chart-container mt-3">
    <h5 class="text-center text-dark fw-semibold mb-2">PRODUKTIFITAS PRODUKSI</h5>
    <canvas id="productionChart"></canvas>
  </div>

  {{-- HASIL HARI INI --}}
  <div class="hasil-card mt-3 text-white">
    <h5 class="text-center mb-3 fw-semibold">Hasil Hari Ini</h5>
    <div class="hasil-row d-flex justify-content-around align-items-center" id="todayResult">
      <div class="text-center text-muted small">Memuat data...</div>
    </div>
  </div>
</div>
