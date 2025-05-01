// Map functionality using Leaflet and OpenStreetMap (no API key required)

// Initialize the map when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});

function initMap() {
    // Create map centered at a default location
    const map = L.map('map').setView([40.7128, -74.006], 12);

    // Add OpenStreetMap tile layer (free and no API key required)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Custom marker icon
    const propertyIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background-color: #2196F3; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"><i class="fas fa-home" style="font-size: 12px;"></i></div>',
        iconSize: [22, 22],
        iconAnchor: [11, 11]
    });

    // Get property cards from the DOM
    const propertyCards = document.querySelectorAll('.property-card');

    // Add markers for each property with information from the DOM
    propertyCards.forEach(card => {
        const id = card.getAttribute('data-id');
        const name = card.querySelector('h3').textContent;
        const price = card.querySelector('.price').textContent;

        // We need to define coordinates for each property
        // For demo purposes, we'll use slightly offset coordinates
        // In a real application, you would have actual coordinates for each property
        const baseLatitude = 40.7128;
        const baseLongitude = -74.006;
        const offsetLat = (id % 5) * 0.01;
        const offsetLng = (id % 3) * 0.01;

        const coordinates = [baseLatitude + offsetLat, baseLongitude + offsetLng];

        // Create marker
        const marker = L.marker(coordinates, { icon: propertyIcon }).addTo(map);

        // Add popup with property info
        marker.bindPopup(`
            <div class="map-popup">
                <h3>${name}</h3>
                <p>${price}</p>
                <button class="map-details-btn" data-id="${id}">View Details</button>
            </div>
        `, {
            closeButton: true,
            offset: [0, -10]
        });

        // Add click event to the "View Details" button in popup
        marker.on('popupopen', function() {
            document.querySelectorAll('.map-details-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const propertyId = this.getAttribute('data-id');
                    openPropertyModal(propertyId);
                });
            });
        });
    });
}
