<!DOCTYPE html>
<html>
<head>
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>
    <h1>Mapa ni biong</h1>
    <div id="map" style="height: 600px;"></div>
    <button onclick="getUserLocation()">Get My Location</button>
    <div id="destinationCoordinates">
        <label for="destLat">Destination Latitude:</label>
        <input type="text" id="destLat" placeholder="Latitude">
        <label for="destLng">Destination Longitude:</label>
        <input type="text" id="destLng" placeholder="Longitude">
        <button onclick="markDestination()">Mark Destination</button>
    </div>

    <!-- Include Leaflet.js -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var userMarker;
        var destinationMarker;

        // Function to get user's location
        function getUserLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    // Remove the existing user marker
                    if (userMarker) {
                        map.removeLayer(userMarker);
                    }

                    // Create a marker for the user's location
                    userMarker = L.marker([userLat, userLng]).addTo(map);
                    userMarker.bindPopup("Your Current Location").openPopup();

                    // Set the map view to the user's location
                    map.setView([userLat, userLng], 20);
                });
            } else {
                alert("Geolocation is not available in your browser.");
            }
        }

        // Function to mark a destination on the map
        function markDestination() {
            var destLat = parseFloat(document.getElementById('destLat').value);
            var destLng = parseFloat(document.getElementById('destLng').value);

            if (!isNaN(destLat) && !isNaN(destLng)) {
                // Remove the existing destination marker
                if (destinationMarker) {
                    map.removeLayer(destinationMarker);
                }

                // Create a marker for the destination
                destinationMarker = L.marker([destLat, destLng]).addTo(map);
                destinationMarker.bindPopup("Your Destination").openPopup();
            } else {
                alert("Please enter valid destination coordinates.");
            }
        }

        // Function to handle map click event for marking destination
        map.on('click', function(e) {
            var destLat = e.latlng.lat;
            var destLng = e.latlng.lng;

            // Remove the existing destination marker
            if (destinationMarker) {
                map.removeLayer(destinationMarker);
            }

            // Create a marker for the clicked location (destination)
            destinationMarker = L.marker([destLat, destLng]).addTo(map);
            destinationMarker.bindPopup("Your Destination").openPopup();

            // Update the destination coordinates input fields
            document.getElementById('destLat').value = destLat;
            document.getElementById('destLng').value = destLng;
        });
    </script>
</body>
</html>
