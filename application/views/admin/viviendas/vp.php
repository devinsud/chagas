
    <div id="print">
    
    
        <img src="<?php echo base_url();?>assets/img/logo1.png" alt="">
        <h2>Orden de trabajo de <?php echo $tipo; ?></h2>
        
            <h5> <b>Fecha:</b> <?php echo $fecha; ?></h5>
            <h5> <b>Ciclo:</b> <?php echo $ciclo[0]->ciclo; ?></h5>
            

            <h5> <b>Operadores:</b> </h5>
            <ul style="list-style:none;">
            <?php 
            if( isset($operadores)){
                foreach($operadores as $op){ ?>
                    <li><?php echo $op; ?></li>
               <?php  }} ?>
                
            </ul>

            <div id="map_canvas"></div>
            <br /><br /><br /><br />
            <table border="1" class="vp">
                <tr>
                    <th>Vivienda</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Barrio</th>
                    <th>Jefe de Flia</th>
                    <th>Receptividad Ultima Visita</th>
                    
                </tr>
                <input type="hidden" name="viviendas" value="">
                <?php foreach ($viviendas as $u) { 
                    if($u!=''){
                    $viv = $this->vivienda->getDatosLista($u);
                    $ins = $this->vivienda->getDatosUltimaInspeccion($u);
                    $jefe = $this->vivienda->getUltimoJefedeFamilia($u);
                    
                    ?>

                    <tr>
                        <td><?php echo $u; ?></td>
                        <td><?php echo $viv[0]->latitud; ?></td>
                        <td><?php echo $viv[0]->longitud; ?></td>
                        <td><?php $id_barrio = substr($u,0,3);
                                  $nombre = $this->vivienda->getNombreBarrioByCodigo((int)$id_barrio);
                                  echo $nombre; ?></td>
                        <td><?php  echo (isset($jefe[0]->nombre))?$jefe[0]->nombre:'n/d'; ?></td>
                        <td><?php  echo (isset($ins[0]->receptividad_vivienda))?$ins[0]->receptividad_vivienda:'no se registran visitas'; ?></td>
                        
                    </tr>
                    
                    
                <?php 
            }
                } ?>
            </table>
            <textarea name="observaciones" id="" cols="63" rows="10"><?php echo $observaciones; ?></textarea>
            <br><br>
            
        
</div>

<br><br>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script>

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'print', 'height=1000,width=600');

        var mapa = window.document.getElementById("map_canvas");

        mywindow.document.write('<html><head><title>Fundacion Mundo Sano</title>');
        mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body>');

        mywindow.document.write(data + '<div id="mapa">' +  mapa.innerHTML + '</div>');
        

        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

    function drawCircle(center, radius, nodes, liColor, liWidth, liOpa, fillColor, fillOpa){
        nodes = nodes||40;
        // Convert radius miles to km
        // comment out line below if inputting km
        radius *= 1.609344;
        var points = [];
        var step = parseInt(360/nodes)||10;
        var p1 = new LatLon(center.lat(), center.lng());
        for(var i=0; i<=360; i+=step){
            returned = p1.destinationPoint(i, radius);
            var pint = new google.maps.LatLng(returned._lat,returned._lon);
            points.push(pint);
        }
        points.push(points[0]);
        circle = new google.maps.Polygon({
            paths: points,
            strokeColor: liColor||"#990000",
            strokeOpacity: liOpa||.7,
            strokeWeight: liWidth||2,
            fillColor: fillColor||"#ff0000",
            fillOpacity: fillOpa||.4
        });
        circle.setMap(map);
    }



    var locations = [
    <?php 
    $cc=1;
    foreach ($viviendas as $v) { 
                    if($v!=''){
                    $vivs = $this->vivienda->getDatosLista($v);
                    $esPos = $this->vivienda->esPos($v);
                    $infesacionesPorVivienda = $this->vivienda->getInfestByViv($v);
                    $cc++;
                    ?>
                    ['<div style="width:200px;height:60px;">&nbsp;&nbsp;&nbsp;<strong>Id Vivienda:</strong> <?php echo $vivs[0]->id_vivienda; ?>&nbsp;&nbsp;&nbsp;&nbsp;<br/>&nbsp;&nbsp;&nbsp;<strong>Latitud:</strong> <?php echo $vivs[0]->latitud; ?>&nbsp;&nbsp;&nbsp;&nbsp;<br/>&nbsp;&nbsp;&nbsp;<strong>Longitud:</strong> <?php echo $vivs[0]->longitud; ?>&nbsp;&nbsp;&nbsp;&nbsp;</div>',<?php echo $vivs[0]->latitud; ?>,<?php echo $vivs[0]->longitud; ?>,<?php echo $cc; ?>, <?php echo $esPos; ?>, <?php echo $infesacionesPorVivienda; ?> ],
    <?php           }
        } ?>

    ];

    var map = new google.maps.Map(document.getElementById('map_canvas'), {
      zoom: 12,
      center: new google.maps.LatLng(locations[0][1], locations[0][2]),
      //center: new google.maps.LatLng(-28.4658, -62.8365),
      mapTypeId: google.maps.MapTypeId.HYBRID
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    var positivo = '../../assets/img/vinchu2.png';
    var negativo = '../../assets/img/negativo.png';
    for (i = 0; i < locations.length; i++) {  
        if(locations[i][4]){
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon : positivo
          });
          drawCircle(new google.maps.LatLng(locations[i][1], locations[i][2]), (locations[i][5]*0.05));
        }else{
            var myLatlng = new google.maps.LatLng(locations[i][1], locations[i][2]);
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon : negativo
              });

            
        }

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
    

    </script>

