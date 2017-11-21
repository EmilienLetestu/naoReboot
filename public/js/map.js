/**
 * Created by Emilien on 21/11/2017.
 */
function initMap() {
    var center = new google.maps.LatLng(46.7667, 2.45);
    var locations = document.getElementsByClassName('locations');
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center:  center,
        map :map

    });

    var markers = [];
    for( var i = 0; i < locations.length; i++)
    {
        var data   = locations[i].value.split(',');
        var latLng = new google.maps.LatLng(data[0], data[1]);

        var marker = new google.maps.Marker({
            position: latLng,
            map:map
        });
        markers.push(marker);
    }
}