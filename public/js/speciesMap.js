/**
 * Created by Emilien on 21/11/2017.
 */

    function initMap() {

    //bird map
    var center = new google.maps.LatLng(46.7667, 2.45);
    var birdLocations = $class('locations');
    var birdMap = new google.maps.Map($id('map'), {
        zoom: 5,
        center:  center

    });

    var markers = [];
    for( var i = 0; i < birdLocations.length; i++)
    {
        var birdData   = birdLocations[i].value.split(',');
        var birdLatLng = new google.maps.LatLng(birdData[0], birdData[1]);

        var birdMarker = new google.maps.Marker({
            position: birdLatLng,
            map:birdMap
        });
        markers.push(birdMarker);
    }
}

