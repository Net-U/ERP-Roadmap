<!DOCTYPE html>
<html>
<head>
    <title>ERP Kebun - Peta</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>
    <div id="map" style="height: 100vh"></div>

    <script>
        var map = L.map("map").setView([-2.092, 112.010], 15);

        // Satelit basemap
        L.tileLayer(
            "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
            { attribution: "Tiles © Esri", maxZoom: 20 }
        ).addTo(map);

        // Ambil data dari API
        fetch("http://127.0.0.1:8000/api/blok")
            .then(res => res.json())
            .then(data => {
                L.geoJSON(data, {
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
            });
    </script>
</body>
</html>
