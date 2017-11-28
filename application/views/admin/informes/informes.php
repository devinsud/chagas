



 
<h2>Criterios</h2>
<strong>Fecha desde:</strong> <?php echo ($desde != '')?$desde:''; ?> &nbsp;|&nbsp; 
<strong>Fecha hasta:</strong> <?php echo ($hasta != '')?$hasta:''; ?> &nbsp;|&nbsp; 
<strong>Barrio:</strong> <?php echo ($barrio != '')?$barrio:''; ?> &nbsp;|&nbsp; 
<strong>Manzana:</strong> <?php echo ($manzana != '')?$manzana:''; ?> &nbsp;|&nbsp; 
<strong>Zona:</strong> <?php echo ($zona != '')?$zona:''; ?> &nbsp;|&nbsp; 
<strong>Filtro x ciclos: </strong>

<?php
//var_dump($filtro_ciclos);

if (is_array($filtro_ciclos)) {
	if (($key = array_search('', $filtro_ciclos)) !== false) {
		unset($filtro_ciclos[$key]);
	}
	foreach ($filtro_ciclos as $fc) {

		$ciclo = $this->ciclo->getcicloId($fc);
		echo $ciclo[0]->ciclo . ' ' . $ciclo[0]->tipo . '  &nbsp;|&nbsp; ';
	}
}
?>

<?php

if (count($viviendas) > 0) {
 		 
		?>
		<div class="panel_informes">
		<h2>Viviendas</h2>
		<div class="container_indices">
 
			<div class="barra_indice" style=" background-color:#f58584; padding:5px;">
                            <strong>Viviendas Inspeccionadas = <span class="ninfo"><?php echo   $receptividad["receptiva"]["cantidad"]." (".$receptividad["receptiva"]["porcentaje"]."%)";?></span></strong>
			</div>
			<div  class="barra_indice" style="background-color:#fecd67; padding:5px;">
				<strong>Viviendas Cerradas =  <span class="ninfo"><?php echo $receptividad["cerrada"]["cantidad"]." (".$receptividad["cerrada"]["porcentaje"]."%)";?></span></strong>
			</div>
			<div  class="barra_indice" style="background-color:#6dab6a; padding:5px;">
				<strong>Viviendas Renuentes =  <span class="ninfo"><?php echo $receptividad["renuente"]["cantidad"]." (".$receptividad["renuente"]["porcentaje"]."%)";?></span></strong>
			</div>
			<div  class="barra_indice" style="background-color:#3e8ecd; padding:5px;">
				<strong>Viviendas Deshabitadas =  <span class="ninfo"><?php echo $receptividad["deshabitada"]["cantidad"]." (".$receptividad["deshabitada"]["porcentaje"]."%)";?></span></strong>
			</div>
			<div  class="barra_indice" style="background-color:#3e8ecd; padding:5px;">
				<strong>Viviendas Desarmadas =  <span class="ninfo"><?php echo $receptividad["desarmada"]; /*.$sobre_relevadas_desarmadas;*/?></span></strong>
			</div>
<!--			<div  class="barra_indice" style="background-color:#b285bc; padding:5px;">
				<strong>Viviendas Relevadas=  <span class="ninfo"></span><?php /*echo $receptividad['totales'];*/?></strong>
			</div>-->
			<div  class="barra_indice" style="background-color:#b285bc; padding:5px;">
				<strong>Viviendas Totales =  <span class="ninfo"><?php echo $receptividad['totales'];?></span></strong>
			</div>

			<!--<div  class="barra_indice" style="background-color:#F9690E; padding:5px;">
			</div>-->
 

		</div>

		<h2>Indices de infestaci&oacute;n</h2>
			<div class="container_indices">
				<div class="barra_indice" style=" background-color:#f58584; padding:5px;">
					<strong>Total de viviendas infestadas =</strong> <span class="ninfo"><?php echo $positivas['totales'];?></span>
				</div>
				<div  class="barra_indice" style="background-color:#fecd67; padding:5px;">
					<strong>Total de viviendas con infestación en peridomicilio = </strong> <span class="ninfo"><?php echo $positivas['peri'];
		?></span><strong>

				</div>

				<div  class="barra_indice" style="background-color:#6dab6a; padding:5px;">
					<strong>Total de viviendas con infestación en intradomicilio = </strong> <span class="ninfo"><?php echo $positivas['intra'];
		?></span>
				</div>

				<div  class="barra_indice" style="background-color:#6dab6a; padding:5px;">
					<strong>Total de viviendas con infestación en intra y peridomicilio = </strong> <span class="ninfo"><?php echo $positivas['intra-peri'];
		?></span>
				</div>

				<div class="barra_indice" style=" background-color:#3e8ecd; padding:5px;">
					<strong>Indice de infestaci&oacute;n =</strong> <span class="ninfo"><?php echo $indice_infestacion . ' %';
		?></span><strong>
				</div>

				<div class="barra_indice" style=" background-color:#3e8ecd; padding:5px;">
					<strong>Indice de infestaci&oacute;n intradomiciliar =</strong> <span class="ninfo"><?php echo $indice_infestacion_intradomiciliar . ' %';
		?></span><strong>
				</div>
 
 

			</div>
                <style>
                    .borderGraficos{
                        border: 1px solid #d2d2d2;
                        padding: 10px
                    }
                    .graficas-sinculares{
                            min-height: 560px;
                    }
                </style>
			<h2>Sitios de hallazgo</h2>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 borderGraficos">
                                    <div id="container3"></div>
                                </div>
                                <div class="col-md-5 borderGraficos graficas-sinculares">
                                    <div id="container" ></div>
                                    <?php foreach ($porLugar_intra as $k => $v) {?>
                                    <button style="margin-top: 10px" type="button" class="btn btn-primary"><?php echo strtoupper($k); ?> - <?php echo $v; ?></button>
                                <?php }?>
                                </div>
                                <div class="col-md-7 borderGraficos graficas-sinculares">
                                    <div id="container1" ></div>
                                    <?php foreach ($porLugar_peri as $k1 => $v1) {?> 
                                    <button style="margin-top: 10px" type="button" class="btn btn-primary"><?php echo strtoupper($k1); ?> - <?php echo $v1; ?></button>
			<?php }?>
                                </div>
                            </div>
                            
  			</div>
			
                        
			 
 
	<hr>
		<div class="panel_informes">
		<h2>Tabla de viviendas positivas</h2>
		
	<?php
	echo form_open_multipart(base_url().'admin/informes/exportar_excel_vivienda/'.$sede[0]->id);
 
	?>
                <div class="container" style="display:none">
                    <div class="row">
                        <div class="col-xs-2">
                             <label for='fecha_desde'>Desde </label>
                             <input id="desde_v" class="form-control" name="desde_v" size="10" />
                        </div>
                        
                        <div class="col-xs-2">
                            <label for='fecha_hasta'>Hasta </label>
                            <input id="hasta_v"  class="form-control"   name="hasta_v" size="10" />
                        </div>
                        
                        <div class="col-xs-2">
                            <input type='hidden'  class="form-control" name='id_form' value='<?php echo $form;?>'>
                            <label for='barrios'> Barrios </label>
                             <select id="barrios"  class="form-control" name="barrios">
                                  <option value="">Todos</option>
                                      <?php
                                      foreach ($barrios as $b) {
                                              if ($barrio == $b->id) {
                                                      echo '<option value="'.$b->id.'" selected>'.$b->codigo." - ".$b->nombre.'</option>';
                                              } else {
                                                      echo '<option value="'.$b->id.'">'.$b->codigo." - ".$b->nombre.'</option>';
                                              }
                                      }
                                      ?>

                              </select>
                            
                        </div>
                        <div class="col-xs-2">
                            <label for='manzana'>Manzana </label>
                            <input id="manzana" class="form-control" name="manzana" size="5" value="<?php echo (isset($cmanzana))?$manzana:'';?>" />
                        </div>     
                        <div class="col-xs-2">

                             <label for='ciclo'>Ciclo/Muestreo </label>.
                             <select  class="form-control" id="ciclos" name="ciclos">
                                    <option value="">Todos</option>
                            <?php

                            foreach ($ciclos as $ciclo) {
                                    if ($ciclo == $ckey) {
                                            echo '<option value="'.$ciclo->id.'" selected>'.$ciclo->ciclo.' '.$ciclo->tipo.'</option>';
                                    } else {
                                            echo '<option value="'.$ciclo->id.'">'.$ciclo->ciclo.' '.$ciclo->tipo.'</option>';
                                    }
                            }
                            ?>
                            </select>
                            
                        </div>  
                    </div>
                    <div class="row">
                        <input type="submit" name="submit" class="btn btn-default" value="Exportar excel"  />
                        <input type="submit" name="submit" class="btn btn-success" value="Exportar dbf"  />
                    </div>
                </div>
	   
                
               

	</form>
	<hr>
		<div style="width:100%; padding: 10px; height:300px; overflow-y:scroll; border:1px solid #000;">
                    <table class="table table-bordered  table-hover">
                            <thead>
                                    <th>ID</th>
                            </thead>
                            <tbody>
                                <?php foreach ($positivas["data"] as $viv_pos) {?>
                                <tr>
                                    <td><?php echo $viv_pos->id_vivienda;?></td>
                                </tr>
                                <?php }?>
                            </tbody>
			</table>
		</div>
		<br>


	</div>
	<?php } else {?>
	<span>No hay datos para generar el informe, al menos debe haber una vivienda inspeccionada</span>
	<?php }?>

<script>

                $.datepicker.setDefaults({
                    dateFormat: 'dd/mm/yy'
                });

                if($( "#desde_v" )){
                    $( "#desde_v" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        onClose: function( selectedDate ) {
                            $( "#desde_v" ).datepicker( "option", "minDate", selectedDate );
                        }
                    });
                }
                if($( "#hasta_v" )){
                    $( "#hasta_v" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        onClose: function( selectedDate ) {
                            $( "#hasta_v" ).datepicker( "option", "maxDate", selectedDate );
                        }
                    });
                }

</script>
