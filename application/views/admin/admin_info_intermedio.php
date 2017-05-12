<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
	$base = base_url();
	$js = $base.'assets/js/';
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Fundacion Mundo Sano ( chagas )</title>
<link rel="stylesheet" href="<?php echo $base;?>assets/css/screen.css" type="text/css" media="screen" title="default" />
<link rel="stylesheet" href="<?php echo $base;?>assets/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" title="default" />

<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
<![endif]-->

<!--  jquery core -->
<script src="<?php echo $js;?>jquery-1.4.1.min.js" type="text/javascript"></script>
<!--  checkbox styling script -->
<script src="<?php echo $js;?>ui.core.js" type="text/javascript"></script>
<script src="<?php echo $js;?>jquery.bind.js" type="text/javascript"></script>
<![if !IE 7]>
<!--  styled select box script version 1 -->
<script src="<?php echo $js;?>jquery.selectbox-0.5.js" type="text/javascript"></script>
<![endif]>
<!--  styled select box script version 2 -->
<script src="<?php echo $js;?>jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
<!--  styled file upload script -->
<script src="<?php echo $js;?>jquery.filestyle.js" type="text/javascript"></script>
<!-- Custom jquery scripts -->
<script src="<?php echo $js;?>custom_jquery.js" type="text/javascript"></script>
<!-- Tooltips -->
<script src="<?php echo $js;?>jquery.tooltip.js" type="text/javascript"></script>
<script src="<?php echo $js;?>jquery.dimensions.js" type="text/javascript"></script>
<!--  date picker script -->
<link rel="stylesheet" href="<?php echo $base;?>assets/css/datePicker.css" type="text/css" />
<script src="<?php echo $js;?>date.js" type="text/javascript"></script>
<script src="<?php echo $js;?>jquery.datePicker.js" type="text/javascript"></script>
<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="<?php echo $js;?>jquery.pngFix.pack.js" type="text/javascript"></script>
<link  href="<?php echo $base; ?>assets/js/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
<link  href="<?php echo $base; ?>assets/datatables/media/css/demo_table.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base; ?>assets/js/jquery-1.9.1.js"></script>
<script src="<?php echo $base; ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $base; ?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>assets/js/jquery-ui-timepicker-addon.js"></script>
<script src="<?php echo $base; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/scripts.js"></script>


<script>

            var baseurl = "<?php print base_url(); ?>";
            $(document).ready(function() {

            

                $.datepicker.setDefaults({
                    dateFormat: 'dd/mm/yy'
                });

                if($( "#desde" )){
                    $( "#desde" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        onClose: function( selectedDate ) {
                            $( "#hasta" ).datepicker( "option", "minDate", selectedDate );
                        }
                    });
                }
                if($( "#hasta" )){
                    $( "#hasta" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        onClose: function( selectedDate ) {
                            $( "#desde" ).datepicker( "option", "maxDate", selectedDate );
                        }
                    });
                }
               


                $('#<?php echo $menusel; ?>').addClass('active');

                //$('table#lugares').visualize({type: 'pie', height: '300px', width: '420px'});

            });
           
            //-28.4658 -62.8365

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

         

        </script>

</head>
<body>
<!-- Start: page-top-outer -->
<div id="page-top-outer">
    <div id="page-top">
	   <div id="logo" style="margin-top:5px;">
	       <a href=""><img src="<?php echo $base; ?>assets/img/logo2.png" width="113" height="85" alt="" /></a>
    </div>
       <div class="clear"></div>
    </div>
</div>

<div class="clear">&nbsp;</div>



<div class="clear"></div>
<div id="content-outer">
<div id="content">
	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?php echo $base; ?>assets/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?php echo $base; ?>assets/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
	       	<div id="content-table-inner">
    		  <table border="0" width="100%" cellpadding="0" cellspacing="0">
		          <tr valign="top">
		              <td>
			             <?php if (isset($listado)) { ?>
                            <!--listado-->
                            <?php $this->load->view($listado); ?>
                         <?php } ?>
			             <div class="clear">&nbsp;</div>

		              </td>
		          </tr>
		          <tr>
		              <td><img src="<?php echo $base; ?>assets/images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
		              <td></td>
		          </tr>
		      </table>
		      <div class="clear"></div>
              <div class="clear"></div>
		  </div>
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
		</table>
</div>
<div class="clear">&nbsp;</div>
</div>
<div class="clear">&nbsp;</div>
<div id="footer">
	<div class="clear">&nbsp;</div>
</div>
<script>
        $('#<?php echo $menusel;?>').parent().parent().removeClass('select');
        $('#<?php echo $menusel;?>').parent().parent().addClass('current');
</script>

<script src="<?php echo $base;?>assets/highcharts/js/highcharts.js"></script>
<script src="<?php echo $base;?>assets/highcharts/js/modules/exporting.js"></script>
</body>
</html>
