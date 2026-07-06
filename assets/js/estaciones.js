/**
 * Estaciones de Servicio - Funcionalidad JavaScript
 * 
 * Maneja la interactividad de la sección de estaciones de servicio:
 * - Toggle de vistas (Lista, Mapa, Grid)
 * - Botón de filtros
 * - Integración con FacetWP
 */

document.addEventListener('DOMContentLoaded', function() {
    const toggleViews = document.getElementById('toggle-views-estaciones');
    const estacionesContent = document.getElementById('estacionesContent');
    const mapElement = document.querySelector('.facetwp-facet-eess_map');
    
    if (toggleViews && estacionesContent) {
        // Obtener todos los botones de vista
        const viewButtons = toggleViews.querySelectorAll('.toggle-btn');
        
        // Función para resetear todas las vistas
        function resetViews() {
            // Ocultar mapa
            if (mapElement) {
                mapElement.style.display = 'none';
            }
            
            // Mostrar listado
            estacionesContent.style.display = '';
            
            // Remover clases de grid y mantener horizontal scroll
            estacionesContent.classList.remove('is-style-group-grid');
            if (!estacionesContent.classList.contains('is-style-group-horizontal-scroll')) {
                estacionesContent.classList.add('is-style-group-horizontal-scroll');
            }
        }
        
        // Agregar event listeners a cada botón
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const viewType = this.getAttribute('data-view');
                
                // Remover clase active de todos los botones
                viewButtons.forEach(btn => btn.classList.remove('active'));
                
                // Agregar clase active al botón clickeado
                this.classList.add('active');
                
                // Manejar diferentes vistas
                switch(viewType) {
                    case 'list':
                        resetViews();
                        break;
                        
                    case 'map':
                        // Ocultar listado
                        estacionesContent.style.display = 'none';
                        
                        // Mostrar mapa
                        if (mapElement) {
                            mapElement.style.display = 'block';
                        }
                        break;
                        
                    case 'grid':
                        resetViews();
                        
                        // Cambiar a vista de grid
                        estacionesContent.classList.remove('is-style-group-horizontal-scroll');
                        estacionesContent.classList.add('is-style-group-grid');
                        break;
                }
            });
        });
        
        // Inicializar vista por defecto (mapa)
        const defaultButton = toggleViews.querySelector('[data-view="map"]');
        if (defaultButton) {
            defaultButton.click();
        }
    }

    // Solo inicializar el mapa si no se está usando el callback de Google Maps
    if (typeof window.initializeStationMapCallback === 'undefined') {
        initializeStationMap();
    }
});

// Función global para el callback de Google Maps API
window.initializeStationMapCallback = function() {
    initializeStationMap();
};

/**
 * Inicializa el mapa individual de la estación de servicio
 */
function initializeStationMap() {
    const mapContainer = document.querySelector('.acf-map');
    
    if (!mapContainer) {
        return; // No hay mapa en esta página
    }

    // Verificar si Google Maps API está disponible
    if (typeof google === 'undefined') {
        console.error('Google Maps API no está cargada');
        return;
    }

    const marker = mapContainer.querySelector('.marker');
    
    if (!marker) {
        console.error('No se encontró el marcador del mapa');
        return;
    }

    // Obtener coordenadas del marcador
    const lat = parseFloat(marker.getAttribute('data-lat'));
    const lng = parseFloat(marker.getAttribute('data-lng'));
    const zoom = parseInt(mapContainer.getAttribute('data-zoom')) || 15;

    if (isNaN(lat) || isNaN(lng)) {
        console.error('Coordenadas inválidas para el mapa');
        return;
    }

    // Crear el mapa
    const map = new google.maps.Map(mapContainer, {
        zoom: zoom,
        center: { lat: lat, lng: lng },
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
            {
                featureType: 'poi',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }]
            }
        ]
    });

    // Crear el marcador
    const mapMarker = new google.maps.Marker({
        position: { lat: lat, lng: lng },
        map: map,
        title: marker.querySelector('h4') ? marker.querySelector('h4').textContent : 'Estación de Servicio'
    });

    // Crear InfoWindow con el contenido del marcador
    const infoWindow = new google.maps.InfoWindow({
        content: marker.innerHTML
    });

    // Abrir InfoWindow al hacer clic en el marcador
    mapMarker.addListener('click', function() {
        infoWindow.open(map, mapMarker);
    });

    // Opcional: Abrir InfoWindow por defecto
    // infoWindow.open(map, mapMarker);

    console.log('Mapa de estación inicializado correctamente');
}
