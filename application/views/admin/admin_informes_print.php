<!DOCTYPE html>
<html>
    <head>
        <title>Administrador Mundo Sano</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/js/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/datatables/media/css/demo_table.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/basic.css" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/visualize.css" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/visualize-dark_print.css" type="text/css" rel="stylesheet" />
        

        <style type="text/css">
          .label {width:100px;text-align:right;float:left;padding-right:10px;font-weight:bold;}
          #form1 label.error {color:#FB3A3A;font-weight:bold;}
        </style>
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/excanvas.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/visualize.jQuery.js"></script>
        
        
       
        
         
        
        
        
            
            <script>
          
           var baseurl = "<?php print base_url(); ?>";
            $(document).ready(function() {   

                $('#container').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: 'Indice de infestación por lugares'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                color: '#000000',
                                connectorColor: '#000000',
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                            }
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: 'Cantidad de infecciones',
                        data: [
                            <?php foreach($porLugar as $k=>$v){?>
                                ['<?php echo $k; ?>', <?php echo $v; ?>],
                            <?php } ?>
                            
                        ]
                    }]
                });
                   $('#perfil_criaderos1').visualize({
                    type: 'bar', 
                    height: '162px', 
                    width: '420px',
                    pieLabelPos: 'inside'

                    });

                if($('#fecha')){
                    $( "#fecha" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true
                    });
                }
                if($( "#desde" )){
                    $( "#desde" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true
                    });
                }
                if($( "#hasta" )){
                    $( "#hasta" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true
                    }); 
                }

                if($( "#desde_v" )){
                    $( "#desde_v" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true
                    });
                }
                if($( "#hasta_v" )){
                    $( "#hasta_v" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true
                    }); 
                }

                if($( "#desde_r" )){
                    $( "#desde_r" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true
                    });
                }
                if($( "#hasta_r" )){
                    $( "#hasta_r" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true
                    }); 
                }

                if($('#inicio')){
                
                }
               
                $.datepicker.setDefaults({
                    
                    dateFormat: 'dd/mm/yy'
                    
                });

                
                $( "#fecha_nota" ).datepicker();
		        if($('#ciaSel')){
                    chequeaTipo();
                }
                $('#<?php echo $menusel; ?>').addClass('active');
                
            });
            
            function chequeaTipo(){
                valor = $('#ciaSel').val();
                //alert(valor);
                if(valor=='0'){
                    $('#selTipo').val(2);
                }
            };
            
            function checkAdmin(){
                valor = $('#selTipo').val();
                if(valor==1 || valor==10){
                    $('#trSelCia').css('visibility','hidden');
                    $('#passBlock').css('visibility','visible');
                
                }else if(valor==3){
                    $('#trSelCia').css('visibility','visible');
                    $('#passBlock').css('visibility','hidden');
                }else{
                    $('#trSelCia').css('visibility','hidden');
                    $('#passBlock').css('visibility','hidden');
                }
            }
            
            function actualizaDrop(id){
                cant = $('#cant'+id).val();
                 $.post("<?php echo base_url(); ?>admin/proyectos/get_proyectos_by_sede/"+id, 
                 function(data) {
                     alert("cantidad actualizada"); 
                  
                  
                 }, "json");
            }


            function cambiaEstado(id){
            
                $.ajax({
                    type:'post',
                    url: '<?php echo base_url(); ?>admin/noticias/cambiaEstado/'+id,
                    //data: $("#postentry").serialize(),
                    success:function(data){
                        $('#link'+id).text(data);
                    }
                });
             
            }
            
            
            
            function llenaDrop(){
                var id = $('#sede').val();
                $.ajax({
                    type:'post',
                    url: '<?php echo base_url(); ?>admin/proyectos/getProyectosBySede/'+id,
                    success: function(proyectos) //we're calling the response json array 'cities'
                      {
                        $('#proyecto').empty();
                       // $('#f_city, #f_city_label').show();
                           $.each(proyectos,function(id,nombre) 
                           {
                            var opt = $('<option />'); // here we're creating a new select option for each group
                              opt.val(id);
                              opt.text(nombre);
                              $('#proyecto').append(opt); 
                        });
                       } //end success
                });
            }
            function traeNombreBarrio(){
                var id = $('#barrio').val();               
                $.ajax({
                    type:'post',
                    url: '<?php echo base_url(); ?>admin/barrios/getBarrioById/'+id,
                    success: function(barrio) //we're calling the response json array 'cities'
                      {
                        $('#nombre_barrio').empty();
                        
                         if(barrio != '[]'){
                        datos = $.parseJSON(barrio);
                       
                          $('#nombre_barrio').val(datos[0].nombre);
                        }else{
                          $('#nombre_barrio').val('sin nombre');
                        }
                       } //end success
                    
                });
            }
        </script>
        <style type="text/css">
        /*some demo styles*/
        body { font-size: 62.5%; }
        .enhanced h2, .enhanced pre { margin: 3em 20px .5em; }
        .enhanced pre { width: 50%; overflow: auto; font-size: 1.4em; margin-top: 0; background: #444; padding: 15px; color: #fff; }
    </style>
    </head>
    <body>
       
        <div id="main">
             
            


            <div id="middle_print">
                <div id="center-column-print">
                  
                    <?php if (isset($listado)) { ?>
                        <!--listado-->
                        <?php $this->load->view($listado); ?>
                    <?php } ?>

                           


                
                </div>
           </div>
        </div>
        

            
    </body>
   <script src="<?php echo base_url();?>assets/highcharts/js/highcharts.js"></script>
<script src="<?php echo base_url();?>assets/highcharts/js/modules/exporting.js"></script>
</html>
