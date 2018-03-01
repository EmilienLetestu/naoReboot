/**
 * Created by Emilien on 21/11/2017.
 */
function initMap(){

    var center = new google.maps.LatLng(46.7667, 2.45);

    //get all maps id
    var maps =  document.querySelectorAll('*[id^="birdStatMap"]');
    var zoom = screen.width <  768 ? 5 : 6;

   //loop through all id and create map
   for( var i = 0; i < maps.length; i++)
   {
       var locations = maps[i].querySelectorAll('*[id^="reportMapSatNav"]');
       var index = i + parseInt(1);
       var mapId = 'birdStatMap'+index;
       var map = new google.maps.Map($id(mapId), {
           zoom: zoom,
           center: center
       });

       //loop through all hidden input and create an array of marker value
       var markers = [];
       for( var n = 0; n < locations.length; n++ )
       {
           var data = locations[n].value.split(',');
           var birdLatLng = new google.maps.LatLng(data[0], data[1]);
           var birdMarker = new google.maps.Marker({
               position: birdLatLng,
               map:map
           });
           markers.push(birdMarker);
       }
   }
}

