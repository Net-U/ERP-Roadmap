<!-- resources/views/sidebar/bottom-bar.blade.php -->
<div class="bottom-bar closed" id="bottomBar">
  <button class="toggle-btn" id="toggleBtn"><i class="bi bi-caret-down-fill"></i></button>

  <div class="production-container">
    <div class="production-card production-22"><strong>Mon 22</strong><br>54%</div>
    <div class="production-card production-23"><strong>Mon 23</strong><br>65%</div>
    <div class="production-card production-24"><strong>Mon 24</strong><br>75%</div>
  </div>

  <div class="chart-container">
    <h5 class="text-center">PRODUKTIFITAS PRODUKSI </h5>
    <canvas id="productionChart"></canvas>
  </div>

  <div class="hasil-card">
    <h5>Hasil</h5>
    <div class="hasil-row d-flex justify-content-around align-items-center">
      <div class="hasil-item text-center">
        <h3 class="mb-0">569</h3>
        <small>Janjang</small>
      </div>
      <div class="hasil-item text-center">
        <h3 class="mb-0">990</h3>
        <small>Tonase</small>
      </div>
    </div>
  </div>
</div>
