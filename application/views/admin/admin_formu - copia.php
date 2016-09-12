<!DOCTYPE html>
<html>
    <head>
        <title>Administrador Mundo Sano</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link  href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        <link  href="<?php echo base_url(); ?>assets/js/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
        <link  href="<?php echo base_url(); ?>assets/datatables/media/css/demo_table.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
          .label {width:100px;text-align:right;float:left;padding-right:10px;font-weight:bold;}
          #form1 label.error {color:#FB3A3A;font-weight:bold;}
        </style>
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.js"></script>
         
        <!--<script src="<?php echo base_url(); ?>assets/js/validation-rules.js"></script>-->
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatables/media/js/jquery.dataTables.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
            
            <script>
            
           var baseurl = "<?php print base_url(); ?>";
            $(document).ready(function() {   
                  
                 <?php if(isset($datos) && !is_null($datos)){ ?>
                     $('#example1').dataTable({
                        "aLengthMenu": [[ 50, -1], [50, "Todas"]],
                        "iDisplayLength": 50
                    });

                 <?php } ?>
                 if($('#fecha')){
                    $( "#fecha" ).datepicker({
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
    </head>
    <body>
       
        <div id="main">
             <div style="position:relative; margin-left: 320px; text-align: center;height:90px; width:136px;">
                <a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/img/logo.png"  alt=""  height="150px;" /></a>
            </div>
            <div id="header">
                
                <!--menu top-->
                <?php $this->load->view($menu_top); ?>
               
            </div>


            <div id="middle">
                <div id="center-column">
                  <div id="errorContainer">
                    <p>Por favor corrija los siguientes errores:</p>
                    <ul />
                </div>
                    <?php if (isset($listado)) { ?>
                        <!--listado-->
                        <?php $this->load->view($listado); ?>
                    <?php } ?>

                            <?php /***************************************/ ?>


                    
                   



                            <?php /***************************************/ ?>




                
                </div>
           </div>
        </div>
        

            
    </body>
   
</html>
