// public/js/dashboard.js
document.addEventListener("DOMContentLoaded", function () {
    // helper to safely query
    function el(id) {
        return document.getElementById(id);
    }

    /* =======================
       🔹 Sidebar & UI Toggle
       ======================= */
    const toggleLeft = el("toggle-sidebar-left");
    const sidebar = el("sidebar");
    const mainContent = document.querySelector(".main-content");

    if (toggleLeft && sidebar) {
        toggleLeft.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");
            if (mainContent) {
                mainContent.classList.toggle("collapsed");
            }
        });
    }

    const toggleRight = el("toggle-sidebar-right");
    const sidebarRight = el("sidebar-right");
    if (toggleRight && sidebarRight) {
        toggleRight.addEventListener("click", function () {
            sidebarRight.classList.toggle("collapsed");
        });
    }

    const toggleBtn = el("toggleBtn");
    const bottomBar = el("bottomBar");
    if (toggleBtn && bottomBar) {
        toggleBtn.addEventListener("click", function () {
            bottomBar.classList.toggle("closed");
            toggleBtn.classList.toggle("rotate");
        });
    }

    /* =======================
       🔹 Chart.js Example
       ======================= */
    const canvas = document.getElementById("productionChart");
    if (canvas && typeof Chart !== "undefined") {
        const ctx = canvas.getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "Mei",
                    "Jun",
                    "Jul",
                    "Agu",
                    "Sep",
                    "Okt",
                    "Nov",
                    "Des",
                ],
                datasets: [
                    {
                        label: "Produksi",
                        data: [
                            500, 600, 950, 500, 900, 0, 400, 600, 700, 450, 420,
                            530,
                        ],
                        fill: true,
                        borderColor: "#1c6758",
                        backgroundColor: "rgba(28,103,88,0.14)",
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            autoSkip: false, // biar semua label bulan muncul
                            maxRotation: 45, // miringin biar muat
                            minRotation: 45,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        max: 1000,
                        ticks: { stepSize: 200 },
                    },
                },
            },
        });
    }

    /* =======================
   🔹 Leaflet Map + Blok Kebun dari Database
   ======================= */
    if (document.getElementById("map")) {
        // Inisialisasi map (pusat awal + zoom default)
        var map = L.map("map").setView([-2.092, 112.011], 13);

        // Base layer
        var osm = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            { attribution: "&copy; OpenStreetMap contributors" }
        );

        // Google Hybrid (satelit + jalan)
        var googleHybrid = L.tileLayer(
            "http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}",
            {
                maxZoom: 20,
                subdomains: ["mt0", "mt1", "mt2", "mt3"],
            }
        );

        // Tambahkan layer default
        googleHybrid.addTo(map);

        // Control switcher
        L.control
            .layers({
                "Peta Biasa (OSM)": osm,
                "Google Hybrid": googleHybrid,
            })
            .addTo(map);

        // Ambil GeoJSON dari API Laravel
        fetch("/api/blok-kebun")
            .then((res) => res.json())
            .then((data) => {
                var geoLayer = L.geoJSON(data, {
                    style: function (feature) {
                        // Warna berdasarkan rotasi panen
                        const rotasi = feature.properties.rotasi_panen;
                        let warna = "#2ecc71"; // hijau default

                        if (rotasi <= 10) warna = "#f1c40f"; // kuning
                        if (rotasi <= 5) warna = "#e74c3c"; // merah

                        return { color: warna, weight: 2, fillOpacity: 0.6 };
                    },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup(`
                        <b>Kode Blok:</b> ${feature.properties.kode_blok}<br>
                        <b>Luas:</b> ${feature.properties.luas_ha} ha<br>
                        <b>Rotasi Panen:</b> ${feature.properties.rotasi_panen} hari<br>
                        <b>Tgl Panen Terakhir:</b> ${feature.properties.tgl_panen_terakhir}
                    `);
                    },
                }).addTo(map);

                // Zoom otomatis ke semua blok
                if (geoLayer.getBounds().isValid()) {
                    map.fitBounds(geoLayer.getBounds(), {
                        padding: [100, 100],
                        maxZoom: 16,
                    });
                }
            })
            .catch((err) => console.error("Gagal ambil data GeoJSON:", err));
    }
});
