var geocoder;
var btn = document.getElementById('localizeMe');


// Get the latitude and the longitude;
function successFunction(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    codeLatLng(lat, lng);
}

// Get Error
function errorFunction() {
    alert('Echec de la géolocalisation');
}

//initialize Google Map
function initMap() {
    geocoder = new google.maps.Geocoder();

}

//auto find lat, lng and address
function codeLatLng(lat, lng) {

    var latLng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latLng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            console.log(results)
            if (results[1]) {
                //find county name
                for (var i=0; i<results[0].address_components.length; i++) {
                    for (var b=0;b<results[0].address_components[i].types.length;b++) {
                        //try to find : administrative area level 2
                        if (results[0].address_components[i].types[b] == 'administrative_area_level_2') {
                            county= results[0].address_components[i];
                            break;
                        }
                    }
                }
                //insert collected data into form
                document.getElementById('report_location').value = results[0].formatted_address + ','  + county.short_name;
                document.getElementById('report_satNav').value   = lat + ', ' + lng
            } else {
                alert('aucun résultat trouvé');
            }
        } else {
            alert('Echec réseau: ' + status);
        }
    });
}

//find lat and lng from submitted location
function codeLocation(geocoder)
{
    var address = document.getElementById('report_location').value;
    geocoder.geocode({'address': address}, function (results, status) {
        if(status === 'OK'){
            alert('Coordonnées GPS qui seront enregistrées : ' + results[0].geometry.location)
            document.getElementById('satNav').value = location;
        }else{
            alert('Aucune données pour ce lieu !');

        }

    });
}

btn.onclick = function localizedMe () {
    var address = document.getElementById('report_location').value;
    if (navigator.geolocation && address === '' ) {
        navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
    }
    if(address !== ''){
        codeLocation(geocoder);
    }
}
