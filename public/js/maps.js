/**
 * Created by Emilien on 21/11/2017.
 */

    function initMap() {

    // report maps
    var locations = document.querySelectorAll('*[id^="reportMapSatNav"]');

    for( var i = 0; i < locations.length; i++ )
    {
        var data = locations[i].value.split(',');
        var latLng = new google.maps.LatLng(data[0], data[1]);

        var index = i + parseInt(1);
        var mapId = 'reportMap'+index;

        var map = new google.maps.Map(document.getElementById(mapId), {
            zoom: 6,
            center: latLng,
        });
        var marker = new google.maps.Marker({
            position: latLng,
            map: map
        });
    }

    google.maps.event.addListener(map, 'idle', function(){
        google.maps.event.trigger(map, 'resize');
        map.setCenter(latLng);
    });

    //bird map
    var center = new google.maps.LatLng(46.7667, 2.45);
    var birdLocations = document.getElementsByClassName('locations');
    var birdMap = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center:  center

    });

    var markers = [];
    for( var i = 0; i < locations.length; i++)
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

