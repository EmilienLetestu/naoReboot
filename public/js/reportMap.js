/**
 * Created by Emilien on 21/11/2017.
 */

function initReportMap(loopIndex) {

    // report maps
    var getid = 'reportMapSatNav' + loopIndex;
    var location =  $id(getid);
    var data     = location.value.split(',');
    var latLng = new google.maps.LatLng(data[0], data[1]);
    var mapId = 'reportMap'+loopIndex;
    var quantity = 'reportQuantity' + loopIndex;

    var num  = $id(quantity).value;

    var map = new google.maps.Map($id(mapId), {
        zoom: 6,
        center: latLng,
        mapTypeControl: false,
        streetViewControl: false
    });


    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        label: num
    });


    google.maps.event.addListener(map, 'idle', function(){
        google.maps.event.trigger(map, 'resize');
        map.setCenter(latLng);
    });

}






