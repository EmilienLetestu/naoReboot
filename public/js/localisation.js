var geocoder;

var btn = $id("localize");
var address = $id("report_location").value;


//initialize Google Map
function initMap() {
    geocoder = new google.maps.Geocoder();
}

/**
 * auto find lat, lng and address
 */
function getAll() {
    navigator.geolocation.getCurrentPosition(function (position) {

        var geocoder = new google.maps.Geocoder();
        var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        geocoder.geocode({'latLng': geolocate}, function (results, status) {
            if (status === "OK") {
                var result;
                if (results.length > 1) {
                    result = results[1];
                } else {
                    result = results[0];
                }

                $id('report_location').value = result.address_components[0].long_name + ', ' + result.address_components[2].long_name;
                $id('report_satNav').value   = position.coords.latitude + ', ' + position.coords.longitude;
            }
            if (!results) {
                alert('Nous ne parvenons pas à géolocaliser !');
            }
        });
    });
}


/**
 * find lat and lng from submitted location
 * @param geocoder
 */
function codeLocation(geocoder) {
    var address = $id("report_location").value;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === "OK") {
            alert('Coordonnées GPS qui seront enregistrées : ' + results[0].geometry.location);

            var data = results[0].geometry.location.toString();
            var addressToUpper = address.charAt(0).toUpperCase() + address.slice(1);

           $id('report_satNav').value = data.replace(/\(|\)/g,'') ;
            $id('report_location').value = addressToUpper + ', ' +  results[0].address_components[2].long_name;

        } else {
            alert('Aucune données pour ce lieu !');
        }
    });
}


function localizeMe() {
    var address = $id("report_location").value;
    if (address !== "") {
        codeLocation(geocoder);
    }
    else {
        getAll();
    }
}

