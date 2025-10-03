<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ERP Kebun - Dashboard</title>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar kiri */
    .sidebar-left {
      width: 220px;
      background: #064e3b;
      color: white;
      display: flex;
      flex-direction: column;
    }
    .sidebar-left h2 {
      padding: 20px;
      margin: 0;
      font-size: 1.2rem;
      border-bottom: 1px solid #0f766e;
    }
    .sidebar-left nav {
      flex: 1;
      padding: 10px;
    }
    .sidebar-left nav a {
      display: block;
      padding: 10px;
      margin-bottom: 5px;
      color: white;
      text-decoration: none;
      border-radius: 6px;
    }
    .sidebar-left nav a:hover {
      background: #0d9488;
    }
    .sidebar-left .bottom {
      border-top: 1px solid #0f766e;
      padding: 10px;
    }

    /* Konten utama */
    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      position: relative;
    }
    #map {
      flex: 1;
    }
    .bottom-bar {
      background: #222;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
    }
    .bottom-bar .cards {
      display: flex;
      gap: 10px;
    }
    .bottom-bar .card {
      background: #047857;
      padding: 8px 12px;
      border-radius: 8px;
      color: white;
      text-align: center;
    }
    .bottom-bar .hasil {
      background: #064e3b;
      padding: 10px 20px;
      border-radius: 8px;
      text-align: center;
    }

    /* Sidebar kanan */
    .sidebar-right {
      width: 250px;
      background: #047857;
      color: white;
      padding: 20px;
    }
    .sidebar-right h2 {
      font-size: 1.1rem;
      border-bottom: 1px solid #0f766e;
      padding-bottom: 8px;
      margin-bottom: 12px;
    }
    .sidebar-right p {
      margin: 6px 0;
      font-size: 0.9rem;
    }
    .sidebar-right span {
      background: #2563eb;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 0.75rem;
    }
  </style>
</head>
<body>

  <!-- Sidebar kiri -->
  <div class="sidebar-left">
    <h2>Dashboard</h2>
    <nav>
      <a href="#">📄 Laporan</a>
      <a href="#">📊 Rendemen</a>
      <a href="#">👷 Tenaga Kerja</a>
    </nav>
    <div class="bottom">
      <a href="#">⚙️ Pengaturan</a>
    </div>
  </div>

  <!-- Main -->
  <div class="main">
    <div id="map"></div>
    <div class="bottom-bar">
      <div class="cards">
        <div class="card" style="background:#064e3b;">
          <p>Mon 22</p>
          <p class="text-sm">Production 54%</p>
        </div>
        <div class="card" style="background:#16a34a;">
          <p>Mon 23</p>
          <p class="text-sm">Production 65%</p>
        </div>
        <div class="card" style="background:#22c55e;">
          <p>Mon 24</p>
          <p class="text-sm">Production 75%</p>
        </div>
      </div>
      <div class="hasil">
        <p class="text-lg"><strong>Hasil</strong></p>
        <p>569 Janjang</p>
        <p>990 Tonase</p>
      </div>
    </div>
  </div>

  <!-- Sidebar kanan -->
  <div class="sidebar-right">
    <h2>MEI</h2>
    <p>📅 <strong>TGL Panen:</strong> 27</p>
    <p>🌱 <strong>THN Tanam:</strong> 2007</p>
    <p>📍 <strong>Luasan:</strong> 7 Ha</p>
    <p>🌴 <strong>JML Pokok:</strong> 200</p>
    <p>👷 <strong>TTL Pemanen:</strong> 14</p>
    <p>🔄 <strong>Rotasi:</strong> <span>6 Hari</span></p>
  </div>

  <!-- Script untuk Leaflet -->
  <script>
    var map = L.map("map").setView([-2.092, 112.010], 16);

    // Satelit basemap
    L.tileLayer(
      "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
      { attribution: "Tiles © Esri", maxZoom: 20 }
    ).addTo(map);

    // Data dummy blok
    var blok = {
      "type": "FeatureCollection",
      "features": [
        {
          "type": "Feature",
          "properties": { "kode": "A1", "status": "hijau", "luas": 10 },
          "geometry": {
            "type": "Polygon",
            "coordinates": [[[112.010, -2.092], [112.012, -2.092], [112.012, -2.094], [112.010, -2.094], [112.010, -2.092]]]
          }
        }
      ]
    };

    L.geoJSON(blok, {
      style: function (feature) {
        switch (feature.properties.status) {
          case "hijau": return { color: "green", fillOpacity: 0.5 };
          case "kuning": return { color: "yellow", fillOpacity: 0.5 };
          case "merah": return { color: "red", fillOpacity: 0.5 };
          default: return { color: "gray", fillOpacity: 0.5 };
        }
      },
      onEachFeature: function (feature, layer) {
        layer.bindPopup(`
          <b>Blok ${feature.properties.kode}</b><br>
          Status: ${feature.properties.status}<br>
          Luas: ${feature.properties.luas} ha
        `);
      }
    }).addTo(map);
  </script>
</body>
</html>
