document.addEventListener("DOMContentLoaded", async function () {
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
       🔹 Statistik Produksi Panen
       ======================= */
    try {
        const res = await fetch("/harvest/stats");
        if (!res.ok) throw new Error("HTTP error ${res.status}");
        const data = await res.json();

        // === Hasil Hari Ini ===
        const today = data.today || { total_janjang: 0, total_tonase: 0 };
        const todayResult = el("todayResult");
        if (todayResult) {
            todayResult.innerHTML = `
                <div class="hasil-item text-center">
                  <h3 class="mb-0">${today.total_janjang ?? 0}</h3>
                  <small>Janjang</small>
                </div>
                <div class="hasil-item text-center">
                  <h3 class="mb-0">${today.total_tonase ?? 0}</h3>
                  <small>Tonase</small>
                </div>
            `;
        }

        // === Produksi 3 Hari Terakhir ===
        const prodContainer = el("productionContainer");
        if (prodContainer) {
            prodContainer.innerHTML = "";

            // urutan warna sesuai CSS
            const colorClasses = [
                "production-22",
                "production-23",
                "production-24",
            ];

            data.recent.forEach((item, index) => {
                const date = new Date(item.date);
                const day = date.toLocaleDateString("id-ID", {
                    weekday: "short",
                    day: "numeric",
                });

                // ambil warna sesuai urutan (misal: 22, 23, 24, lalu berulang)
                const colorClass = colorClasses[index % colorClasses.length];

                const card = document.createElement("div");
                card.className = `production-card ${colorClass}`;
                card.innerHTML = `
            <strong>${day}</strong><br>
            ${item.total_tonase ?? 0} ton
        `;
                prodContainer.appendChild(card);
            });
        }

        // === Grafik Bulanan ===
        const months = [
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
        ];
        const monthlyData = Array(12).fill(0);
        data.monthly.forEach((item) => {
            monthlyData[item.month - 1] = item.total_tonase;
        });

        const canvas = el("productionChart");
        if (canvas && typeof Chart !== "undefined") {
            const ctx = canvas.getContext("2d");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: "Produksi",
                            data: monthlyData,
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
                            max: Math.max(...monthlyData) + 100,
                            ticks: { stepSize: 200 },
                        },
                    },
                },
            });
        }
    } catch (err) {
        console.error("Gagal memuat data panen:", err);
        el("todayResult").innerHTML =
            "<div class='text-danger'>Gagal memuat data.</div>";
        el("productionContainer").innerHTML =
            "<div class='text-danger'>Tidak ada data.</div>";
    }

    /* =======================
       🔹 Leaflet Map + Toggle Polygon
       ======================= */
    if (el("map")) {
        const map = L.map("map");

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

        // 🔹 Fungsi bantu hitung selisih hari
        function daysSince(dateString) {
            const today = new Date();
            const last = new Date(dateString);
            const diffTime = today - last;
            return Math.floor(diffTime / (1000 * 60 * 60 * 24));
        }

        // Ambil data GeoJSON dari API Laravel
        fetch("/api/blok-kebun")
            .then((res) => res.json())
            .then((data) => {
                geoLayer = L.geoJSON(data, {
                    style: (feature) => {
                        const rotasi = feature.properties.rotasi_panen;
                        const tglPanen = feature.properties.tgl_panen_terakhir;
                        let color = "#95a5a6"; // default abu-abu

                        if (tglPanen && rotasi) {
                            const hariSejakPanen = daysSince(tglPanen);
                            const sisaHari = rotasi - hariSejakPanen;

                            if (sisaHari >= 5 && sisaHari <= 7)
                                color = "#2ecc71"; // hijau
                            else if (sisaHari >= 3 && sisaHari <= 4)
                                color = "#f1c40f"; // kuning
                            else if (sisaHari >= 1 && sisaHari <= 2)
                                color = "#e67e22"; // oranye
                            else if (sisaHari <= 0) color = "#e74c3c"; // merah
                        }

                        return {
                            color: "#333",
                            weight: 1,
                            fillColor: color,
                            fillOpacity: 0.6,
                        };
                    },
                    onEachFeature: (feature, layer) => {
                        layer.bindPopup(`
                            <b>Kode Blok:</b> ${feature.properties.kode_blok}<br>
                            <b>Luas (ha):</b> ${feature.properties.luas_ha}<br>
                            <b>Rotasi Panen:</b> ${feature.properties.rotasi_panen} hari<br>
                            <b>Tgl Panen Terakhir:</b> ${feature.properties.tgl_panen_terakhir}
                        `);
                    },
                }).addTo(map);

                if (geoLayer.getBounds().isValid()) {
                    map.fitBounds(geoLayer.getBounds().pad(0.2));
                }
            })
            .catch((err) => console.error("Gagal ambil data GeoJSON:", err));

        // 🔘 Toggle Polygon
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
