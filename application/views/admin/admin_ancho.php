<!DOCTYPE html>
<html>
    <head>
        <title>Administrador Mundo Sano</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link  href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        
        <link  href="<?php echo base_url(); ?>assets/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.6.2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.js"></script>
        
        <script src="<?php echo base_url(); ?>assets/js/ui.dropslide.js"></script>
        <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
        

        <script>
            $(document).ready(function() {
                $( "#fecha_inicio" ).datetimepicker({
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'hh:mm:ss',
                    changeMonth: true
                });
                $( "#fecha_fin" ).datetimepicker({
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'hh:mm:ss',
                    changeMonth: true
                }); 
                $("#dialog").dialog({
                    autoOpen: false,
                    modal: true
                });
                $("#dialog1").dialog({
                    autoOpen: false,
                    modal: true
                });
                 $("#dialog2").dialog({
                    autoOpen: false,
                    modal: true
                });
                $.datepicker.setDefaults({
                    
                    dateFormat: 'dd/mm/yy'
                    
                });

                var dates = $( "#from, #to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
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
        <div id="dialog" title="Confirmation Required" style="display:none;">
            esta seguro de borrar al usuario?
        </div>
        <div id="dialog1" title="Confirmation Required" style="display:none;">
            esta seguro de borrar la campa&ntilde;a?
        </div>
        <div id="dialog2" title="Confirmation Required" style="display:none;">
            esta seguro de borrar la campa&ntilde;&iacute;a?
        </div>
        <div id="dialog3" style="display:none;" title="Confirmation Required">
            esta seguro de borrar este concepto?
        </div>
        <div id="dialog4" style="display:none;" title="Confirmation Required">
            esta seguro de borrar esta categoria?
        </div>
        <div id="dialog5" style="display:none;" title="Confirmation Required">
            esta seguro de borrar esta seccion?
        </div>
        <div id="dialog6" style="display:none;" title="Confirmation Required">
            esta seguro de borrar esta imagen?
        </div>

        <div id="main">
            <div class="top_logo">
                <a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/img/logo.png"  alt="" height="150px;"  /></a>
            </div>
            <div id="header">
                
                <!--menu top-->
                <?php $this->load->view($menu_top); ?>
            </div>
            <div id="middle" style="width:900px;">
                
                <div id="center-column" style="width:800px; margin-left: 35px;">
                    <?php if (isset($listado)) { ?>
                        <!--listado-->
                        <?php $this->load->view($listado); ?>
                    <?php } ?>
                    <!--form tipo-->
                </div>
                
            </div>
            <div id="footer"></div>
        </div>
    </body>
    <script>
       
        $(".borrausuario").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog").dialog("open");
        });
        $(".borracampa").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog1").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog1").dialog("open");
        });
        
        $(".borracat").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog4").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog4").dialog("open");
        });
        $(".borrasec").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog5").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog5").dialog("open");
        });
        $(".borracia").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog2").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog2").dialog("open");
        });
        
        $(".borra_criterio_driving").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog3").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog3").dialog("open");
        });
        $(".borra_imagen_rotador").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog6").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog6").dialog("open");
        });
        $(".borra_imagen_galeria").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog6").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog6").dialog("open");
        });
        
        $(".borra_criterio_bar").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog3").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog3").dialog("open");
        });
        
        $(".borra_concepto").click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");

            $("#dialog3").dialog({
                buttons : {
                    "Confirmar" : function() {
                        window.location.href = targetUrl;
                    },
                    "Cancelar" : function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog3").dialog("open");
        });
        
        $('.paginador').change(function() {
            <?php if(isset($criterio) && $criterio!=''){ ?>
          window.location.href = "<?php echo base_url(); ?>admin/usuarios/index/"+$(this).attr("value")+'/<?php echo $criterio; ?>';
          <?php }else{ ?>
              window.location.href = "<?php echo base_url(); ?>admin/usuarios/index/"+$(this).attr("value");
          <?php } ?>    
        });
        
        $('.paginador_cia').change(function() {
            <?php if(isset($criterio) && $criterio!=''){ ?>
          window.location.href = "<?php echo base_url(); ?>admin/cias/index/"+$(this).attr("value")+'/<?php echo $criterio; ?>';
          <?php }else{ ?>
              window.location.href = "<?php echo base_url(); ?>admin/cias/index/"+$(this).attr("value");
          <?php } ?>    
        });
        
        $('.paginador_criterios_driving').change(function() {
            <?php if(isset($criterio) && $criterio!=''){ ?>
          window.location.href = "<?php echo base_url(); ?>admin/criterios/driving/"+$(this).attr("value")+'/<?php echo $criterio; ?>';
          <?php }else{ ?>
              window.location.href = "<?php echo base_url(); ?>admin/criterios/driving/"+$(this).attr("value");
          <?php } ?>    
        });
        
        $('.paginador_conceptos').change(function() {
            <?php if(isset($criterio) && $criterio!=''){ ?>
          window.location.href = "<?php echo base_url(); ?>admin/conceptos/index/"+$(this).attr("value")+'/<?php echo $criterio; ?>';
          <?php }else{ ?>
              window.location.href = "<?php echo base_url(); ?>admin/conceptos/index/"+$(this).attr("value");
          <?php } ?>    
        });
        
        $('.paginador_criterios_bar').change(function() {
            <?php if(isset($criterio) && $criterio!=''){ ?>
          window.location.href = "<?php echo base_url(); ?>admin/criterios/bar/"+$(this).attr("value")+'/<?php echo $criterio; ?>';
          <?php }else{ ?>
              window.location.href = "<?php echo base_url(); ?>admin/criterios/bar/"+$(this).attr("value");
          <?php } ?>    
        });
        
        
        
        $(".buscar").click(function(e) {
            criterio = $('#busqueda').val();
            
            window.location.href = "<?php echo base_url(); ?>admin/usuarios/index/0/"+criterio;
        })
        
        
        
        
        $(".buscar_cia").click(function(e) {
            criterio = $('#busqueda_cia').val();
            if(criterio=='' || criterio=='undefined'){
                criterio='';
            }
            window.location.href = "<?php echo base_url(); ?>admin/cias/index/0/"+criterio;
        })
        
        
        $(".buscar_conceptos").click(function(e) {
            criterio = $('#busqueda_conceptos').val();
            if(criterio=='' || criterio=='undefined'){
                criterio='';
            }
            window.location.href = "<?php echo base_url(); ?>admin/conceptos/index/0/"+criterio;
        })
        
        
        $(".buscar_criterio_driving").click(function(e) {
            criterio = $('#busqueda_criterios_driving').val();
            if(criterio=='' || criterio=='undefined'){
                criterio='';
            }
            window.location.href = "<?php echo base_url(); ?>admin/criterios/driving/0/"+criterio;
        })
        
        $(".buscar_criterio_bar").click(function(e) {
            criterio = $('#busqueda_criterios_bar').val();
            if(criterio=='' || criterio=='undefined'){
                criterio='';
            }
            window.location.href = "<?php echo base_url(); ?>admin/criterios/bar/0/"+criterio;
        })
        
    </script>
</html>
