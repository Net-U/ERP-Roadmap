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
    if (toggleLeft && sidebar) {
        toggleLeft.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");
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
   🔹 Leaflet Map + Polygon
   ======================= */
    if (document.getElementById("map")) {
        // Inisialisasi map (pusat awal + zoom default)
        var map = L.map("map").setView([-6.4331432, 106.4835269], 13); // zoom lebih jauh

        // Base layers
        var osm = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            { attribution: "&copy; OpenStreetMap contributors" }
        );

        // Google Hybrid (satelit + jalan + label)
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
        fetch("/api/blok")
            .then((res) => res.json())
            .then((data) => {
                var geoLayer = L.geoJSON(data, {
                    style: function (feature) {
                        let warna =
                            feature.properties.status === "hijau"
                                ? "green"
                                : "red";
                        return { color: warna, weight: 2, fillOpacity: 0.5 };
                    },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup(`
                        <b>Blok: ${feature.properties.kode}</b><br>
                        Luas: ${feature.properties.luas} ha<br>
                        Status: ${feature.properties.status}
                    `);
                    },
                }).addTo(map);

                // Zoom otomatis ke polygon TAPI kasih padding & batas zoom
                map.fitBounds(geoLayer.getBounds(), {
                    padding: [100, 100], // biar agak jauh
                    maxZoom: 15, // batasi supaya nggak terlalu dekat
                });
            });
    }
});
