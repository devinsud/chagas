var geocoder;
var map;
var marker;
var ren;
var ser;
var lat1, lng1, lat2, lng2; 
var data = {};
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var oldDirections = [];
var currentDirections = null; 
/*function detenerError()
{
    return true
}
window.onerror=detenerError */
function initialize(){
    //MAP
    var latlng = new google.maps.LatLng(-34.554922, -58.725357);
    var options = {
        zoom: 14,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
       
    map = new google.maps.Map(document.getElementById("map_canvas"), options);
       
    directionsDisplay = new google.maps.DirectionsRenderer({
        'map': map,
        'preserveViewport': true,
        'draggable': true
    });
    directionsDisplay.setPanel(document.getElementById("directions_panel"));
    //setUndoDisabled(true);

    
    
    stepDisplay = new google.maps.InfoWindow();

    geocoder = new google.maps.Geocoder();
    google.maps.event.addListener(directionsDisplay, 'directions_changed',
        function() {
          
            if (currentDirections) {
                //console.log(currentDirections);
                oldDirections.push(currentDirections);
            // setUndoDisabled(false);
            }
            currentDirections = directionsDisplay.getDirections();
            //showSteps(response);
            devuelve_geo();
        
            //save_waypoints($('#campa_oculto').val());
            write_waypoints($('#campa_oculto').val());
        
        
        });
    
    
    //fetchdata();
      
    

    

}
function devuelve_geo(){
    var w=[],wp;
    
    var rleg = directionsDisplay.directions.routes[0].legs[0];
    var latlng = new google.maps.LatLng(rleg.start_location.lat(),rleg.start_location.lng());
    var latlng1 = new google.maps.LatLng(rleg.end_location.lat(),rleg.end_location.lng());
    
    geocoder.geocode({
            'latLng': latlng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#address1').val(results[0].formatted_address);
                    $('#latitude1').val(rleg.start_location.lat());
                    $('#longitude1').val(rleg.start_location.lng());
                }
            }
        });
     geocoder.geocode({
            'latLng': latlng1
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#address2').val(results[0].formatted_address);
                    $('#latitude2').val(rleg.end_location.lat());
                    $('#longitude2').val(rleg.end_location.lng());
                }
            }
        });
}
function write_waypoints()
{
    var w=[],wp;
    var rleg = directionsDisplay.directions.routes[0].legs[0];
    data.start = {'lat': rleg.start_location.lat(), 'lng':rleg.start_location.lng()}
    data.end = {'lat': rleg.end_location.lat(), 'lng':rleg.end_location.lng()}
    var wp = rleg.via_waypoints
    for(var i=0;i<wp.length;i++)w[i] = [wp[i].lat(),wp[i].lng()]
    data.waypoints = w;
    var str = JSON.stringify(data)
    $('#camino_real').val(str);
    
}
function save_waypoints()
{
    var w=[],wp;
    var rleg = directionsDisplay.directions.routes[0].legs[0];
    data.start = {
        'lat': rleg.start_location.lat(), 
        'lng':rleg.start_location.lng()
        }
    data.end = {
        'lat': rleg.end_location.lat(), 
        'lng':rleg.end_location.lng()
        }
    var wp = rleg.via_waypoints
    for(var i=0;i<wp.length;i++)w[i] = [wp[i].lat(),wp[i].lng()]
    data.waypoints = w;
    var str = JSON.stringify(data)
    var jax = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    jax.open('POST',base+'sessions/salva_waypoints/'+campa);
    jax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    jax.send('command=save&mapdata='+str)
    jax.onreadystatechange = function(){
        if(jax.readyState==4) {
    /* if(jax.responseText.indexOf('bien')+1)alert('Updated');
        else alert(jax.responseText)*/
        }
    }
}

function setroute(os)
{
    var wp = [];
    for(var i=0;i<os.waypoints.length;i++)
        wp[i] = {
            'location': new google.maps.LatLng(os.waypoints[i][0], os.waypoints[i][1]),
            'stopover':false
        }
    directionsService.route({
        'origin':new google.maps.LatLng(os.start.lat,os.start.lng),
        'destination':new google.maps.LatLng(os.end.lat,os.end.lng),
        'waypoints': wp,
        'travelMode': google.maps.DirectionsTravelMode.DRIVING
        },function(res,sts) {
        if(sts=='OK')directionsDisplay.setDirections(res);
    }) 
}

function fetchdata()
{
    var jax = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    jax.open('GET',base+'sessions/trae_waypoints/'+campa);
    jax.send('command=fetch')
    jax.onreadystatechange = function(){
        if(jax.readyState==4) {  
            try {
                setroute( eval('(' + jax.responseText + ')') );
            }
            catch(e){
                alert(e);
            }
        }
    }
}

function calcRoute() {
    var start = $('#address1').val();
    var end = $('#address2').val();
    var request = {
        origin:start,
        destination:end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        //console.log(response)
        }
    });
}
function undo() {
    currentDirections = null;
    directionsDisplay.setDirections(oldDirections.pop());
    if (!oldDirections.length) {
        setUndoDisabled(true);
    }
}
  