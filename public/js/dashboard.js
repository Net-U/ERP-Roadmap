// public/js/dashboard.js
document.addEventListener("DOMContentLoaded", function () {
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
                            autoSkip: false,
                            maxRotation: 45,
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
       🔹 Leaflet Map + Toggle Polygon (Topbar)
       ======================= */
    if (document.getElementById("map")) {
        let map = L.map("map");

        // Basemap
        L.tileLayer(
            "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
            {
                attribution:
                    "Tiles © Esri &mdash; Source: Esri, Earthstar Geographics",
                maxZoom: 20,
            }
        ).addTo(map);

        let geoLayer;
        let polygonVisible = true;

        // Ambil GeoJSON
        fetch("/api/blok-kebun")
            .then((res) => res.json())
            .then((data) => {
                geoLayer = L.geoJSON(data, {
                    style: (feature) => {
                        const colorMap = {
                            hijau: "green",
                            kuning: "yellow",
                            merah: "red",
                            biru: "blue",
                        };
                        return {
                            color:
                                colorMap[feature.properties.status] || "gray",
                            fillOpacity: 0.5,
                        };
                    },
                    onEachFeature: (feature, layer) => {
                        layer.bindPopup(
                            `<b>Blok ${feature.properties.kode_blok}</b><br>
                             Status: ${feature.properties.status}<br>
                             Luas: ${feature.properties.luas_ha || "-"} ha`
                        );
                    },
                }).addTo(map);

                if (geoLayer.getBounds().isValid()) {
                    map.fitBounds(geoLayer.getBounds().pad(0.2));
                }
            })
            .catch((err) => console.error("Gagal ambil data GeoJSON:", err));

        // 🔘 Toggle Polygon di Topbar
        const toggleButton = el("togglePolygon");
        const polygonIcon = el("polygonIcon");

        if (toggleButton && polygonIcon) {
            toggleButton.addEventListener("click", function () {
                if (!geoLayer) return;

                if (polygonVisible) {
                    map.removeLayer(geoLayer);
                    polygonIcon.classList.replace("fa-eye", "fa-eye-slash");
                    polygonIcon.classList.add("text-danger");
                    toggleButton.classList.replace(
                        "btn-outline-success",
                        "btn-outline-danger"
                    );
                } else {
                    geoLayer.addTo(map);
                    polygonIcon.classList.replace("fa-eye-slash", "fa-eye");
                    polygonIcon.classList.remove("text-danger");
                    toggleButton.classList.replace(
                        "btn-outline-danger",
                        "btn-outline-success"
                    );
                }

                polygonVisible = !polygonVisible;
            });
        }
    }
});
