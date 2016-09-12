var geocoder;
var map;
var marker;
   
/*function detenerError()
{
return true;
}
window.onerror=detenerError; */
function initialize(lat1,lng1){
    //MAP
    //var latlng = new google.maps.LatLng(-34.6084175,-58.37316129999999);
    //GEOCODER
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat1,lng1);
    var options = {
        zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
       
    map = new google.maps.Map(document.getElementById("map_canvas"), options);
       
    
    
      
    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        draggable: true
    });
    /*google.maps.event.addListener(map, 'idle', function() {
         alert(map.getBounds());
      });*/
    google.maps.event.addListener(marker, 'drag', function() {
    
    geocoder.geocode({
        'latLng': marker.getPosition()
        }, 
        
        function(results, status) {
        
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                $('#address').val(results[0].formatted_address);
                $('#latitude').val(marker.getPosition().lat());
                $('#longitude').val(marker.getPosition().lng());
            }
        }
    });
});
               
}

