var geocoder;

var marker;
var directionDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
function detenerError()
{
    return true
}
window.onerror=detenerError
function initialize(){
    //MAP

    var latlng = new google.maps.LatLng(-34.556901,-58.727594);
    var options = {
        zoom: 15,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
   // directionsDisplay = new google.maps.DirectionsRenderer();
    map = new google.maps.Map(document.getElementById("map_canvas"), options);



    directionsDisplay = new google.maps.DirectionsRenderer({
        'map': map,
        'preserveViewport': true,
        'draggable': true
    });
    //pepe = document.getElementById("main");

    pepe = document.getElementById("dirs");

    directionsDisplay.setPanel(pepe);
    directionsDisplay.setMap(map);

    //
    //GEOCODER
    geocoder = new google.maps.Geocoder();


    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        draggable: true
    });
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


var control = 0;
function calcRoute() {
    console.log('llego');
    var start = document.getElementById("address").value;
    var end = 'Av Ricardo Balbín 3002, San Miguel, Buenos Aires, Argentina';
    var request = {
        origin:start,
        destination:end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsDisplay.setMap(map);
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}

function calcRouteInverse() {

    var start = 'Av Ricardo Balbín 3002, San Miguel, Buenos Aires, Argentina';
    var end = document.getElementById("address").value;
    if(control==0){
        var request = {
            origin:start,
            destination:end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        control=1;
    }else{
        var request = {
            origin:end,
            destination:start,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        control=0;
    }
    directionsDisplay.setMap(map);
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });

}

/*$("#address").autocomplete({
                    //This bit uses the geocoder to fetch address values
                    source: function(request, response) {
                        geocoder.geocode( {'address': request.term }, function(results, status) {
                            response($.map(results, function(item) {
                                return {
                                    label:  item.formatted_address,
                                    value: item.formatted_address,
                                    latitude: item.geometry.location.lat(),
                                    longitude: item.geometry.location.lng()
                                }
                            }));
                        })
                    },

                    //This bit is executed upon selection of an address
                    select: function(event, ui) {
                        $("#latitude").val(ui.item.latitude);
                        $("#longitude").val(ui.item.longitude);

                    },

                    focus:function(event, ui) {

                        $("#latitude").val(ui.item.latitude);
                        $("#longitude").val(ui.item.longitude);
                        $("#dirs").show();
                        calcRoute();

                    }
                });


*/

$(function() {
    $("#address").autocomplete({
      //This bit uses the geocoder to fetch address values
      source: function(request, response) {
        geocoder.geocode( {'address': request.term }, function(results, status) {
          response($.map(results, function(item) {
            return {
              label:  item.formatted_address,
              value: item.formatted_address,
              latitude: item.geometry.location.lat(),
              longitude: item.geometry.location.lng()
            }
          }));
        })
      },
      //This bit is executed upon selection of an address
      select: function(event, ui) {
        $("#latitude").val(ui.item.latitude);
        $("#longitude").val(ui.item.longitude);
        var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
        //marker.setPosition(location);
        //map.setCenter(location);
        $("#dirs").show();
                        calcRoute();
      }
    });
  });

var lista = {
                    init: function(config){

                        this.url=config.url;
                        this.template = config.template;
                        this.contaier = config.container;
                        this.fetch();
                    },
                    attachTemplate: function(){

                        var template = Handlebars.compile(this.template);

                        $('dl.nls').html( template(this.nls) ).bind( this.agregaEventos());

                    },
                    agregaEventos:function(){
                        $('dd').filter(':nth-child(n+4)').addClass('hide');
                        $('dd').filter(':nth-child(n+4)').css('display','');

                        $('dl').on('click','dt',function(){
                            $(this)
                            .next()
                            .slideDown(200)
                            .siblings('dd')
                            .slideUp(200);
                        })
                    },
                    fetch: function(){

                        var self = this;
                        $.ajax({
                            url: this.url,
                            dataType:'json',
                            success:function(data){
                                self.nls = $.map(data, function(nl){
                                    return {
                                        titulo : nl.titulo,
                                        texto: nl.texto,
                                        fecha: nl.fecha,
                                        fecha:nl.fecha_inicio
                                    }
                                })
                                self.attachTemplate();
                            }
                        });

                    }

                }

var cha = {

                    init: function( config ){

                        this.config = config;

                        this.positions();
                    },
                    positions: function(){
                        $("#titulo").animate({"right":"-300px"}, "slow", function(){
                            $.publish('animacionTitulo',this);
                        })

                    },
                    getSeccion: function(seccion){
                        $.ajax({
                                url:"<?php echo base_url(); ?>secciones/get_seccion/"+seccion,
                                dataType: 'json'

                            }).done(function(){

                            });
                    },
                    bindEvents: function(){

                    },
                    loadData: function(){},
                    gallery: function(){},
                    oculta:function(){},
                    muestra:function(){}

                }

                cha.init({
                        titulo: $('#titulo'),
                        listado: $('#listado'),
                        mapa: $('.map')

                    }
                );


(function($){
                    var o = $( {} );
                    $.each({
                        trigger: 'publish',
                        on: 'subscribe',
                        off: 'unsubscribe'
                    }, function( key,val ){
                        jQuery[val] = function(){
                            o[key].apply( o, arguments );
                        }
                    })



                    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'server/php/'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.com' ||
            window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            disableImageResize: false,
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function (result) {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
    }
                })(jQuery)





