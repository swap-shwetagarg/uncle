function initialize(loc, lat, long)
{
    var geocoder = new google.maps.Geocoder();
    var input = document.getElementById('searchInput');
    geocoder.geocode({
        address: loc
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            rlat = results[0].geometry.location.lat();
            rlong = results[0].geometry.location.lng();
            var latlng = new google.maps.LatLng(rlat, rlong);
            console.log(rlat, rlong);
            var options = {
                zoom: 11,
                center: latlng
            };
            var map = new google.maps.Map(document.getElementById('map'), options);
            google.maps.event.addListenerOnce(map, 'idle', function () {
                var bb = map.getBounds();
                var ne = bb.getNorthEast(); // top-left
                var sw = bb.getSouthWest(); //bottom-right
                initializeMap(sw.lat(), ne.lat(), sw.lng(), ne.lng(), input, options, map);
            });
        } else {
            alert("Something got wrong " + status);
        }
    });
}
function initializeMap(swLat, neLat, swlng, nelng, input, options, map) {
    var latlng = new google.maps.LatLng(swLat, nelng);
//    var map = new google.maps.Map(document.getElementById('map'), {
//        center: latlng,
//        zoom: 13
//    });
    var marker = new google.maps.Marker({
        map: map,
        position: latlng,
        draggable: true,
        anchorPoint: new google.maps.Point(0, -29)
    });
//    var options = {
//        componentRestrictions: {country: 'gh'}
//    };
    var restrictedBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(swLat, swlng),
            new google.maps.LatLng(neLat, nelng)
            );

    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input, {
        bounds: restrictedBounds,
        strictBounds: true,
    });
    console.log(swLat, swlng, neLat, nelng);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();
    autocomplete.addListener('place_changed', function () {        
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (place.geometry.location.lng() > restrictedBounds.getNorthEast().lng() || place.geometry.location.lng() < restrictedBounds.getSouthWest().lng())
        {
            document.getElementById('latlong').value ='';
            document.getElementById('searchInput').value ='';            
            return;
        }
        if (place.geometry.location.lat() > restrictedBounds.getNorthEast().lat() || place.geometry.location.lat() < restrictedBounds.getSouthWest().lat())
        {
            document.getElementById('latlong').value ='';
            document.getElementById('searchInput').value ='';
            return;
        }
        if (!place.geometry) {
            swal("{Address contains no geometry.", "", "warning");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);

    });
    // this function will work on marker move event into map 
    google.maps.event.addListener(marker, 'dragend', function () {
        geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    bindDataToForm(results[0].formatted_address, marker.getPosition().lat(), marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
            }
        });
    });
}
function bindDataToForm(address, lat, lng) {
    document.getElementById('latlong').value = lat + ',' + lng;
}
// google.maps.event.addDomListener(window, 'load', initialize);