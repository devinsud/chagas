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
            
           var baseurl = "<?php print base_url(); ?>";
            $(document).ready(function() {
                 <?php if(isset($items) && !is_null($items)){ ?>
                     var oTable = $('#example').dataTable({
                        "aoColumns": [ 
                           null,null,null,{ "bVisible":    false },{ "bVisible":    false },null,null, null, null
                        ],
                        "aLengthMenu": [[ 50, -1], [50, "Todas"]],
                        "iDisplayLength": 50
                        
                    });

                     $("#example1 tbody tr").click( function( e ) {
                        if ( $(this).hasClass('row_selected') ) {
                            $(this).removeClass('row_selected');
                        }
                        else {
                            oTable.$('tr.row_selected').removeClass('row_selected');
                            $(this).addClass('row_selected');
                        }
                    });


                     $('#example1').dataTable({
                        "aLengthMenu": [[ 50, -1], [50, "Todas"]],
                        "iDisplayLength": 50,
                        "aaSorting": [[ 2, "desc" ]]
                    });

                 <?php } ?>
                $( "#post_date" ).datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true
                });
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
        
        </script>
    </head>
    <body>
       
        <div id="main">
             <div class="top_logo">
                <a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/img/logo.png"  alt=""  /></a>
            </div>
            <div id="header">
                
                <!--menu top-->
                <?php $this->load->view($menu_top); ?>
               
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
