var geocoder;

var btn = document.getElementById("localize");
var address = document.getElementById("report_location").value;


//initialize Google Map
function initMap() {
    geocoder = new google.maps.Geocoder();
}

//auto find lat, lng and address
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
                //console.log(result);
                document.getElementById("report_location").value = result.address_components[0].long_name + ', ' + result.address_components[2].long_name;
                document.getElementById("report_satNav").value = position.coords.latitude + ', ' + position.coords.longitude;
            }
            if (!results) {
                alert('dsddqd');
            }
        });
    });
}

//find lat and lng from submitted location
function codeLocation(geocoder) {
    var address = document.getElementById("report_location").value;
    geocoder.geocode({"address": address}, function (results, status) {
        if (status === "OK") {
            alert("Coordonnées GPS qui seront enregistrées : " + results[0].geometry.location);

            var data = results[0].geometry.location.toString();

            document.getElementById("report_satNav").value = data.replace(/\(|\)/g,'') ;
        } else {
            alert("Aucune données pour ce lieu !");
        }
    });
}

function localizeMe() {
    var address = document.getElementById("report_location").value;
    if (address !== "") {
        codeLocation(geocoder);
    }
    else {
        getAll();
    }
}
