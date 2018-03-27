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
                disable('reportBtn','reportForm');
            }
            if (!results) {
                generateMsg('jsGenerated','jsGeneratedMsg','Nous ne parvenons pas à géolocaliser !','#ff5240');
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


            var message =  'Coordonnées GPS qui seront enregistrées : ' + results[0].geometry.location;
            generateMsg('jsGenerated','jsGeneratedMsg',message,'#5fdda1');

            var data = results[0].geometry.location.toString();
            var addressToUpper = address.charAt(0).toUpperCase() + address.slice(1);


            address.match( /^[a-zA-Z\s\-]*$/) ?
                $id('report_location').value =  addressToUpper + ', ' +  results[0].address_components[2].long_name
                :
                $id('report_location').value =  results[0].address_components[2].long_name + ', ' +  results[0].address_components[4].long_name
            ;

            $id('report_satNav').value = data.replace(/\(|\)/g,'') ;
            disable('reportBtn','reportForm');

        } else {
            generateMsg('jsGenerated','jsGeneratedMsg','Aucune données pour ce lieu !','#ff5240');
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

