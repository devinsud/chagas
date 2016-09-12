var baseurl = "<?php print base_url(); ?>";
            $(document).ready(function() {
                $('#calc_id').on('click', function(){
                    barrio = parseInt($("#barrio").val());
                    manzana = parseInt($("#manzana").val());
                    vivienda = parseInt($("#vivienda").val());
                    if(barrio>0 && manzana >0 && vivienda >0){
                        codigo = (barrio * 1000000)+(manzana*1000)+vivienda;
                        $('#idvivienda').val(codigo);
                    }else{
                        alert( 'Faltan datos para calcular');
                    }
                })

                $( "#acordeon" ).accordion();

                $( ".listado_viviendas li" ).draggable({
                  appendTo: "body",
                  helper: "clone"
                });

                $( "#listado_barrios li" ).draggable({
                  appendTo: "body",
                  helper: "clone"
                });

                
                $( "#cart ol" ).droppable({
                  activeClass: "ui-state-default",
                  hoverClass: "ui-state-hover",
                  accept: ":not(.ui-sortable-helper)",
                  drop: function( event, ui ) {
                    $( this ).find( ".placeholder" ).remove();
                    //$( "<li></li>" ).text( ui.draggable.text()+' <a href="#">X</a>' ).appendTo( this );
                    //existe = $('#cart li:contains:('+ui.draggable.text()+')');
                    //alert(ui.draggable.attr('bel'))
                    existe=$('#'+ui.draggable.attr('rel')).text();
                    if(existe==''){
                        if(ui.draggable.attr('bel')=='barrio'){
                            $( "<li id='"+ ui.draggable.attr('rel') +"'></li>" ).html( ui.draggable.text()+' <a href="#" stylr="color:#f00;" onclick="eliminaBarrio('+ui.draggable.attr('rel') +')"><img src="<?php echo base_url();?>assets/img/hr.gif" alt=""></a>' ).appendTo( this );
                            textoBarrios = $('#cajaBarrios').val() + '-' + ui.draggable.attr('rel');
                            $('#cajaBarrios').val(textoBarrios);
                        }else if(ui.draggable.attr('bel')=='vivienda'){
                            $( "<li id='"+ ui.draggable.attr('rel') +"'></li>" ).html( ui.draggable.text()+' <a href="#" stylr="color:#f00;" onclick="elimina('+ui.draggable.attr('rel') +')"><img src="<?php echo base_url();?>assets/img/hr.gif" alt=""></a>' ).appendTo( this );
                            texto = $('#caja').val() + '-' + ui.draggable.attr('rel');
                            
                            $('#caja').val(texto);
                        }
                    }else{
                            alert('ya esta en la lista');
                    }
                  }
                }).sortable({
                  items: "li:not(.placeholder)",
                  sort: function() {
                    // gets added unintentionally by droppable interacting with sortable
                    // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
                    $( this ).removeClass( "ui-state-default" );
                  }
                });

                 /*$('#calc_id').on('click', function(){
                barrio = parseInt($("#barrio").val());
                manzana = parseInt($("#manzana").val());
                vivienda = parseInt($("#vivienda").val());
                if(barrio>0 && manzana >0 && vivienda >0){
                    codigo = (barrio * 1000000)+(manzana*1000)+vivienda;
                    $('#idvivienda').val(codigo);
                }else{
                    alert( 'Faltan datos para calcular');
                }
            })*/
            $('#submit_inspeccion').prop('disabled',true);

            $('#receptividad').on('change', function(){
                $sel = $(this).val();
                
                if($sel != ''){
                    $('#submit_inspeccion').prop('disabled',false);
                    if($sel != 'receptiva'){
                        //$('#vigilancia').prop('disabled', true);
                        //$('#jefeflia').prop('disabled', true);
                        $('#receptiva').hide();
                        
                    }else{
                        //$('#vigilancia').prop('disabled', false);
                        //$('#jefeflia').prop('disabled', false);
                         $('#receptiva').show();
                        
                    }
                }
            });

            $('#vigilancia').on('change', function(){
                $sel1 = $(this).val();
                if($sel1 != ''){
                    if($sel1 != 'positiva'){
                        $('.positiva').hide();
                    }else{
                        $('#mas').show();
                        $('.positiva').show();
                    }
                }
            });

            $('#mas').on('click', function(e){
                e.preventDefault();
                var clonedPack =  $('.linea_lugar').filter(':last').clone().appendTo(".positiva");
            });


                 
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
                        "iDisplayLength": 50
                    });

                 
                $( "#post_date" ).datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true
                });

                $( "#fecha_orden" ).datepicker({
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true
                });

                $( "#fecha_inspeccion" ).datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true
                });
                if($('#inicio')){

                }

                $.datepicker.setDefaults({

                    dateFormat: 'dd/mm/yy'

                });

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
                $( "#fecha_nota" ).datepicker();
		        if($('#ciaSel')){
                    chequeaTipo();
                }
                $('#<?php echo $menusel; ?>').addClass('active');

            });

            function agregaBarrioCompleto(id){
                $( "#cart ol" ).find( ".placeholder" ).remove();
                $('#listado_viviendas'+id+' li').each(function(){
                    existe=$('#'+$(this).attr('rel')).text();
                    if(existe==''){
                        $( "<li id='"+ $(this).attr('rel') +"'></li>" ).html( $(this).text()+' <a href="#" stylr="color:#f00;" onclick="elimina('+$(this).attr('rel') +')"><img src="<?php echo base_url();?>assets/img/hr.gif" alt=""></a>' ).appendTo( $( "#cart ol" ) );
                        texto = $('#caja').val() + '-' + $(this).attr('rel');
                        $('#caja').val(texto);
                        
                    }
                })
            }
            
            //-28.4658 -62.8365


            function chequeaTipo(){
                valor = $('#ciaSel').val();
                //alert(valor);
                if(valor=='0'){
                    $('#selTipo').val(2);
                }
            };
            
            function muestraPos(pos){
                
                    $('#'+pos).toggle('slow');
                
            }

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

            function elimina(id){

            

               texto = $('#caja').val().replace('-'+id, '');
               
               $('#caja').val(texto);
                  $('#'+id).remove();
            }

            function eliminaBarrio(id){

            

               texto = $('#cajaBarrios').val().replace('-'+id, '');
               
               $('#cajaBarrios').val(texto);
                  $('#'+id).remove();
            }

            function limpia(){

            }
            function traeNombreBarrio(){
                var id = $('#barrio').val();               
                var id_sede = $('#sede').val();               
                $.ajax({
                    type:'post',
                    url: '<?php echo base_url(); ?>admin/barrios/getBarrioById/'+id+'/<?php echo (isset($sede))?$sede:''; ?>',
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
