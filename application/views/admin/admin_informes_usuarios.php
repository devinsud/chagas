<!DOCTYPE html>
<html>
    <head>
        <title>Administrador Mundo Sano</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/js/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/datatables/media/css/demo_table.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/basic.css" type="text/css" rel="stylesheet" />
        <style type="text/css">
          .label {width:100px;text-align:right;float:left;padding-right:10px;font-weight:bold;}
          #form1 label.error {color:#FB3A3A;font-weight:bold;}
            #Usuarios table {width: 800px; height: 200px; margin-left: 30px; }
            #Usuarios table.accessHide { position: absolute; left: -999999px; }
            #Usuarios td, th {  font-size: 1.2em; padding: 2px;  }
            #Usuarios th { background-color:#f4f4f4; } 
            caption { font-size: 1.5em;  }
        </style>
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/excanvas.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.jqplot.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugins/jqplot.pieRenderer.min.js"></script>
        
         
        <link href="<?php echo base_url(); ?>assets/js/jquery.jqplot.min.css" type="text/css" rel="stylesheet" />
  
            <script>
          
           var baseurl = "<?php print base_url(); ?>";
            $(document).ready(function() {   
                data='';
                $.post("<?php echo base_url(); ?>admin/usuarios/getDatosCantidad/<?php echo $sede; ?>", 
                 function(data) {
                     
                    var plot1 = jQuery.jqplot ('user', [data], 
                    { 
                      seriesDefaults: {
                        // Make this a pie chart.
                        renderer: jQuery.jqplot.PieRenderer, 
                        rendererOptions: {
                          // Put data labels on the pie slices.
                          // By default, labels show the percentage of the slice.
                          showDataLabels: true
                        }
                      }, 
                      legend: { show:true, location: 'e' }
                    }
                  );  
                  
                 }, "json");
             
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

                if($('#inicio')){
                
                }
               
                $.datepicker.setDefaults({
                    
                    dateFormat: 'dd/mm/yy'
                    
                });
      
            });
         
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
              <div class="top_logo" style="margin-left:190px;">
                <a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/img/logo.png"  alt=""  height="150px;" /></a>
            </div>
            <div id="header" style="width:600px;">
                
                <!--menu top-->
                <?php $this->load->view($menu_top); ?>
               
            </div>


            <div id="middle_print" >
                <div id="center-column-print" style="width:498px;">
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
