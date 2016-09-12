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
                
                 var oTable = $('#example').dataTable({
                    "aoColumns": [ 
                       null,null,null,{ "bVisible":    false },{ "bVisible":    false },null,null, null, null
                    ],
                    "aLengthMenu": [[ 50, -1], [50, "Todas"]],
                    "iDisplayLength": 50
                    
                });

                 $("#example tbody tr").click( function( e ) {
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
                    "iDisplayLength": 50
                });


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
            function muestraNota(id){
                
                 $.getJSON("<?php echo base_url(); ?>admin/noticias/getNoticiaById/"+id)
                 .done( function(data){
                        
                        empresa = (data[0].empresa == null)?'':data[0].empresa;
                        fecha_creacion = (data[0].fecha_creacion == null)?'':data[0].fecha_creacion;
                        creada_por = (data[0].creada_por == null)?'':data[0].creada_por;
                        fecha1 = (data[0].fecha1 == null)?'':data[0].fecha1;
                        volanta = (data[0].volanta == null)?'':data[0].volanta;
                        titulo = (data[0].titulo == null)?'':data[0].titulo;
                        autor = (data[0].autor == null)?'':data[0].autor;
                        copete = (data[0].copete == null)?'':data[0].copete;
                        texto = (data[0].texto == null)?'':data[0].texto;
                        fuente = (data[0].fuente == null)?'':data[0].fuente;
                        permalink = (data[0].permalink == null)?'':data[0].permalink;
                        fecha = (data[0].fecha == null)?'':data[0].fecha;
                        galerias = (data[0].galerias == null)?'':data[0].galerias;
                        lang = (data[0].lang == null)?'':data[0].lang;
                        canales = (data[0].canales == null)?'':data[0].canales;
                       
                        
                        var tlc = '';
                       
                        

                        $('#showcase').empty();
                        
                        template = "<div class='ficha generica'><span class='negrita'>La nota pretenece a: </span>"+empresa+" <br><span class='negrita'>Fecha en que se cargo la nota: </span>"+fecha_creacion+" <br><span class='negrita'>Subida por: </span>"+creada_por+" </div><div class='generica'><br><span class='negrita'>Fecha de la nota:</span><br> <span class='fecha' >"+fecha1+"</span><br><br><span class='negrita'>Volanta:</span><br> <span class='volanta' >"+volanta+"</span><br><br><span class='negrita'>Titulo:</span><br> <span class='titulo' >"+titulo+"</span><br><span class='negrita'>Autor:</span><br> <span class='autor' >"+autor+"</span><br><br><span class='negrita'>Copete:</span><br><br> <span class='copete' >"+copete+"</span><br><span class='negrita'>Nota:</span><br><br> <span class='nota' >"+texto+"</span><br><br><br><hr><span class='negrita'>Fuente:</span><br> <span class='fuente' >"+fuente+"</span><br><br><span class='negrita'>Permalink:</span><br> <span class='permalink' ><a href='"+permalink+"'>"+permalink+"</a></span><br></div>";

                        
                        if(data[0].imgs!=''){
                            link = '';
                            cc=1;
                             
                             var mistr = new String();
                             mistr = data[0].imgs;
                             var images = mistr.split(',');
                             
                            $.each( images, function(k,v){
                                if(v!=''){
                                    link += "<a href='"+v+"' target='_blank'>scan "+ cc + "</a><br>";
                                    cc++;
                                }
                            });
                            
                            template += "<div><span class='negrita'>Scans de la nota: </span><br>"+link+"</div>";
                        }
                        $('#showcase').append(template);
                         var tlc= '';
                        $.getJSON("<?php echo base_url(); ?>admin/noticias/getAllCanales")
                        .done( function(data1){
                            cana = data[0].canales;
                            canas = cana.split('q');

                            
                            $.each(data1, function(i, item) {
                               
                             if($.inArray(data1[i].id,canas)>-1){
                                tlc += '<input type="checkbox" name="canales[]" value="'+data1[i].id+'" checked />'+data1[i].nombre+' &nbsp;|&nbsp;';
                             }else{
                              tlc += '<input type="checkbox" name="canales[]" value="'+data1[i].id+'" />'+data1[i].nombre+' &nbsp;|&nbsp;';
                             }
                            })


                            ancho = 72; 
                            formu = '<div class="table"><form action="'+baseurl+'admin/noticias/editaAlVuelo" name="edit" method="post"  enctype="multipart/form-data" ><table class="listing form" cellpadding="0" cellspacing="0"><tr><th class="full" colspan="2">Edici&oacute;n de Noticias</th></tr><tr><td>Canales</td><td>'+tlc+'</td></tr><tr><td width="'+ancho+'"><strong>Volanta</strong></td><td><input type="text" name="item[volanta]" class="text"  value="'+volanta+'" /></td></tr><tr><td width="'+ancho+'"><strong>T&iacute;tulo</strong></td><td><input type="text" name="item[titulo]" class="text" value="'+titulo+'" /><input type="hidden" name="item[id]" class="text" value="'+data[0].id+'" /></td></tr><tr><td width="'+ancho+'"><strong>Autor</strong></td><td><input type="text" name="item[autor]" class="text" value="'+autor+'"  /></td></tr><tr><td width="'+ancho+'"><strong>Copete</strong></td><td><textarea id="copete" name="item[copete]">'+copete+'</textarea></td></tr><tr><td width="'+ancho+'"><strong>Texto</strong></td><td><textarea id="texto" name="item[texto]">'+texto+'</textarea></td></tr><tr><td width="'+ancho+'"><strong>Fuente</strong></td><td><input type="text" name="item[fuente]" class="text"  value="'+fuente+'"  /></td></tr><tr><td width="'+ancho+'"><strong>Permalink</strong></td><td><input type="text" name="item[permalink]" class="text"  value="'+permalink+'"  /></td></tr><tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Guardar"/></td></tr></table></form></div>';


                            if (CKEDITOR.instances['copete']) { delete CKEDITOR.instances[ 'copete' ]; }
                            if (CKEDITOR.instances['texto']) { delete CKEDITOR.instances[ 'texto' ]; }
                            $('#edit').html(formu);
                            CKEDITOR.replace( 'item[copete]' ,{toolbar: [
                            { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] }, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                            [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo','Bold', 'Italic' ],          // Defines toolbar group without name.

                            ] });     
                            CKEDITOR.replace( 'item[texto]',{toolbar: [
                            { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] }, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                            [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo','Bold', 'Italic', 'Image' ],          // Defines toolbar group without name.

                            ] } ); 

                            });
                        
                        
                        
                                  
                        }
                    );

                 
                    $.getJSON("<?php echo base_url(); ?>admin/noticias/getImagenesByNoticiaId/"+id)
                     .done( function(data1){
                            if(data1 != null){

                                $('#imagenes').empty();
                                $('#imagenes').append('<br>');
                                imagenes = ''
                                 
                                $.each(data1, function(key,value){
                                    imagenes += "<img src='../../assets/imagenes/"+value.path+"' height='100' />";
                                    
                                });

                                gale = "<div><span class='negrita'>Imagenes: </span><br>"+imagenes+"</div>";

                                $('#imagenes').append(gale);
                            }
                           
                        }

                    );
            }
        
        </script>
    </head>
    <body>
       
        <div id="main">
            <div class="top_logo">
                <a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/img/logo.png"  alt=""  height="150px;" /></a>
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
            <div id="edit_wrapper" >
                <div id="edit">




                </div>
               
                
            </div>
             <div id="showcase_wrapper" >
                <div id="showcase"></div>
                <div id="imagenes"></div>    
                
            </div>
    </body>
    <script>
       
       
        
        
        
        
        
    </script>
</html>
