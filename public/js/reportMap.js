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
            center: latLng
        });
        var marker = new google.maps.Marker({
            position: latLng,
            map: map
        });
    }

}
