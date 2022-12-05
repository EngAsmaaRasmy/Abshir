var google;

// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see the error "The Geolocation service
// failed.", it means you probably did not give permission for the browser to
// locate you.


function initMap() {
    let myLatLng = {};
    var marker;
    var lat = document.getElementById('lat');
    var long = document.getElementById('long');
    var area = document.getElementById('area');

    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 30.033333, lng: 31.233334 },
        zoom: 13,
    });
    infoWindow = new google.maps.InfoWindow();
    const locationButton = document.createElement("button");

    locationButton.textContent = "اضغط هنا لتحديد موقعك";
    locationButton.classList.add("custom-map-control-button");
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
    locationButton.addEventListener("click", () => {
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent(placeMarker(pos));
                    // infoWindow.open(map);
                    map.setCenter(pos);
                },
                () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                }
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    });

    google.maps.event.addListener(map, 'click', function(event) {
        myLatLng = { lat: event.latLng.lat(), lng: event.latLng.lng() }
            // alert("Latitude: " + event.latLng.lat() + " " + ", longitude: " + event.latLng.lng());
        placeMarker(myLatLng);

    });


    function placeMarker(location) {
        lat.value = location.lat;
        long.value = location.lng;

        getReverseGeocodingData(location.lat, location.lng);

        if (marker == null) {
            marker = new google.maps.Marker({
                position: location,
                map: map
            });
        } else {
            marker.setPosition(location);
        }
    }

    function getReverseGeocodingData(late, lng) {
        var latlng = new google.maps.LatLng(late, lng);
        // This is making the Geocode request
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': latlng }, (results, status) => {
            if (status !== google.maps.GeocoderStatus.OK) {
                alert(status);
            }
            // This is checking to see if the Geoeode Status is OK before proceeding
            if (status == google.maps.GeocoderStatus.OK) {
                // console.log(results);
                var address = (results[5].formatted_address);
                var parts = address.split(',');
                var area_value = parts[0].trim();
                area.value = area_value;
            }
        });
    }

}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
        browserHasGeolocation ?
        "Error: The Geolocation service failed." :
        "Error: Your browser doesn't support geolocation."
    );
    infoWindow.open(map);
}

// window.initMap = initMap;
google.maps.event.addDomListener(window, 'load', initMap);
