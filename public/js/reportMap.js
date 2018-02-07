/**
 * Created by Emilien on 21/11/2017.
 */
function initMap(loopIndex) {

    // report maps
    var getid = 'reportMapSatNav' + loopIndex;
    var location =  document.getElementById(getid);
    var data     = location.value.split(',');
    var latLng = new google.maps.LatLng(data[0], data[1]);
    var mapId = 'reportMap'+loopIndex;
    var map = new google.maps.Map(document.getElementById(mapId), {
        zoom: 6,
        center: latLng
    });

    var marker = new google.maps.Marker({
        position: latLng,
        map: map
    });


    google.maps.event.addListener(map, 'idle', function(){
        google.maps.event.trigger(map, 'resize');
        map.setCenter(latLng);
    });
}






