<!DOCTYPE html>
<html>
    <head>
        <title>Administrador Mundo Sano</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link  href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        <link  href="<?php echo base_url(); ?>assets/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.6.2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script>
            $(document).ready(function() {
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
                $('#<?php echo $menusel; ?>').addClass('active');
                
            });
   
            


        
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

        <div id="main">
             <div class="top_logo">
               <a href="#" class="logo"><img src="<?php echo base_url(); ?>assets/img/logo.png"  alt="" height="150px;" /></a>
            </div>
            <div id="header">
                
                <!--menu top-->
                <?php $this->load->view($menu_top); ?>
            </div>
            <div id="middle">
                <div id="left-column">
                    
                </div>
                <div id="center-column">
                    <h1>Bienvenido!</h1>
                    
                    <!--form tipo-->
                </div>
                <!--col derecha-->
                
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
        
        $('.paginador').change(function() {
            <?php if(isset($criterio) && $criterio!=''){ ?>
          window.location.href = "<?php echo base_url(); ?>admin/admin/users/"+$(this).attr("value")+'/<?php echo $criterio; ?>';
          <?php }else{ ?>
              window.location.href = "<?php echo base_url(); ?>admin/admin/users/"+$(this).attr("value");
          <?php } ?>    
        });
        $('.paginador_campa').change(function() {
            <?php if(isset($criterio) && $criterio!=''){ ?>
          window.location.href = "<?php echo base_url(); ?>admin/admin/campaign/"+$(this).attr("value")+'/<?php echo $criterio; ?>';
          <?php }else{ ?>
              window.location.href = "<?php echo base_url(); ?>admin/admin/campaign/"+$(this).attr("value");
          <?php } ?>    
        });
        $('.paginador_cia').change(function() {
            <?php if(isset($criterio) && $criterio!=''){ ?>
          window.location.href = "<?php echo base_url(); ?>admin/admin/cia/"+$(this).attr("value")+'/<?php echo $criterio; ?>';
          <?php }else{ ?>
              window.location.href = "<?php echo base_url(); ?>admin/admin/cia/"+$(this).attr("value");
          <?php } ?>    
        });
        $(".buscar").click(function(e) {
            criterio = $('#busqueda').val();
            
            window.location.href = "<?php echo base_url(); ?>admin/admin/users/0/"+criterio;
        })
        $(".buscar_campa").click(function(e) {
            criterio = $('#busqueda_campa').val();
            if(criterio=='' || criterio=='undefined'){
                criterio='';
            }
            window.location.href = "<?php echo base_url(); ?>admin/admin/campaign/0/"+criterio;
        })
        $(".buscar_cia").click(function(e) {
            criterio = $('#busqueda_cia').val();
            if(criterio=='' || criterio=='undefined'){
                criterio='';
            }
            window.location.href = "<?php echo base_url(); ?>admin/admin/cia/0/"+criterio;
        })
        
    </script>
</html>
