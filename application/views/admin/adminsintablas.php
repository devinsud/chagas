<!DOCTYPE html>
<html>
    <head>
        <title>Administrador Mundo Sano</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link  href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        <link  href="<?php echo base_url(); ?>assets/js/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
        <link  href="<?php echo base_url(); ?>assets/datatables/media/css/demo_table.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatables/media/js/jquery.dataTables.js"></script>
        
            
            <script>
            
          
            
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
            
            function actualizaCant(id){
                cant = $('#cant'+id).val();
                 $.post("<?php echo base_url(); ?>admin/stock_bar/actualiza_cant/"+id+"/"+cant, 
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
            
            function sale(id,tipo){
                precio = $('#bar'+id).val();
                 $.post("<?php echo base_url(); ?>admin/ventas/sale/"+id+"/"+precio+"/"+tipo, 
                 function(data) {
                     alert("cantidad actualizada"); 
                  
                  
                 }, "json");
            }
            
            function actualizaPrecio(id){
                cant = $('#precio'+id).val();
                 $.post("<?php echo base_url(); ?>admin/stock_bar/actualiza_precio/"+id+"/"+cant, 
                 function(data) {
                     alert("cantidad actualizada"); 
                  
                  
                 }, "json");
            }
            
        
        </script>
    </head>
    <body>
       
        <div id="main">
             <div style="position:relative; margin-left: 320px; text-align: center;height:120px; width:136px;">
                <a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/img/logo.png"  alt=""  height="150px;" /></a>
            </div>
            <div id="header">
                
                <!--menu top-->
                <?php $this->load->view($menu_top); ?>
                <div style="margin-left:800px;width:400px;">
                    <a href="<?php echo base_url(); ?>admin/noticias/importFromService/capin" class="boton"> Importar Noticias Capin </a>
                    &nbsp;<a href="<?php echo base_url(); ?>admin/noticias/getNoticiasByEmpresa/capin/5" class="boton" target="_blank">Json Capin</a>
                    <a href="<?php echo base_url(); ?>admin/noticias/getNoticiasByEmpresa/Insud/5" class="boton" target="_blank">Json Insud</a>
                </div>
            </div>
            <div id="middle">
               
                <div id="center-column">
                    <?php if (isset($listado)) { ?>
                        <!--listado-->
                        <?php $this->load->view($listado); ?>
                    <?php } ?>
                
                </div>
                  


                  
            </div>
           
           
        </div>
            
    </body>
    <script>
       
       
        
        
        
        
        
    </script>
</html>
