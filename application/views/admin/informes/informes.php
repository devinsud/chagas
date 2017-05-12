



<hr>

<h2>Criterios<br></h2>
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
	if (1 == 1) {
		if ($total_viviendas_relevadas != 0) {
			if ($total_viviendas_relevadas > 0) {
				$sobre_relevadas_receptivas    = ' ('.round(($receptividad['receptiva']*100)/$receptividad['totales'], 2).'%) ';
				$sobre_totales_receptivas      = ' ( '.round(($receptividad['receptiva']*100)/$receptividad['totales'], 2).'% sobre totales)';
				$sobre_relevadas_cerradas      = ' ('.round(($receptividad['cerrada']*100)/$receptividad['totales'], 2).'%) ';
				$sobre_totales_cerradas        = ' ('.round(($receptividad['cerrada']*100)/$receptividad['totales'], 2).'% sobre totales)';
				$sobre_totales_desarmadas      = ' ('.round(($receptividad['desarmada']*100)/$receptividad['totales'], 2).'% sobre totales)';
				$sobre_relevadas_desarmadas    = ' ('.round(($receptividad['desarmada']*100)/$total_viviendas_relevadas, 2).'% sobre relevadas) ';
				$sobre_relevadas_renuentes     = ' ('.round(($receptividad['renuente']*100)/$receptividad['totales'], 2).'%) ';
				$sobre_totales_renuentes       = ' ('.round(($receptividad['renuente']*100)/$receptividad['totales'], 2).'% sobre totales)';
				$sobre_relevadas_deshabitadas  = ' ('.round(($receptividad['deshabitada']*100)/$receptividad['totales'], 2).'%) ';
				$sobre_totales_deshabitadas    = ' ('.round(($receptividad['deshabitada']*100)/$receptividad['totales'], 2).'% sobre totales)';
				$sobre_totales_total_relevadas = ' ('.round(($total_viviendas_relevadas*100)/$receptividad['totales'], 2).'% sobre totales)';
			} else {
				$sobre_relevadas_receptivas    = "&nbsp; faltan datos";
				$sobre_totales_receptivas      = "&nbsp; faltan datos";
				$sobre_relevadas_cerradas      = "&nbsp; faltan datos";
				$sobre_relevadas_desarmadas    = "&nbsp; faltan datos";
				$sobre_totales_cerradas        = "&nbsp; faltan datos";
				$sobre_relevadas_renuentes     = "&nbsp; faltan datos";
				$sobre_totales_renuentes       = "&nbsp; faltan datos";
				$sobre_relevadas_deshabitadas  = "&nbsp; faltan datos";
				$sobre_totales_deshabitadas    = "&nbsp; faltan datos";
				$sobre_totales_total_relevadas = "&nbsp; faltan datos";
			}

		} else {
			$sobre_relevadas_receptivas    = "";
			$sobre_totales_receptivas      = "";
			$sobre_relevadas_cerradas      = "";
			$sobre_totales_cerradas        = "";
			$sobre_relevadas_renuentes     = "";
			$sobre_totales_renuentes       = "";
			$sobre_relevadas_deshabitadas  = "";
			$sobre_totales_deshabitadas    = "";
			$sobre_totales_total_relevadas = "";

		}
		?>
		<div class="panel_informes">
		<h2>Viviendas</h2>
		<div class="container_indices">

			<div class="barra_indice" style=" background-color:#f58584; padding:5px;">
				<strong>Viviendas Inspeccionadas = <span class="ninfo"><?php echo $receptividad['receptiva'].$sobre_relevadas_receptivas;?></span></strong>
			</div>
			<div  class="barra_indice" style="background-color:#fecd67; padding:5px;">
				<strong>Viviendas Cerradas =  <span class="ninfo"><?php echo $receptividad['cerrada'].$sobre_relevadas_cerradas;?></span></strong>
			</div>
			<div  class="barra_indice" style="background-color:#6dab6a; padding:5px;">
				<strong>Viviendas Renuentes =  <span class="ninfo"><?php echo $receptividad['renuente'].$sobre_relevadas_renuentes;?></span></strong>
			</div>
			<div  class="barra_indice" style="background-color:#3e8ecd; padding:5px;">
				<strong>Viviendas Deshabitadas =  <span class="ninfo"><?php echo $receptividad['deshabitada'].$sobre_relevadas_deshabitadas;?></span></strong>
			</div>
			<div  class="barra_indice" style="background-color:#3e8ecd; padding:5px;">
				<strong>Viviendas Desarmadas =  <span class="ninfo"><?php echo $receptividad['desarmada']; /*.$sobre_relevadas_desarmadas;*/?></span></strong>
			</div>
<!--			<div  class="barra_indice" style="background-color:#b285bc; padding:5px;">
				<strong>Viviendas Relevadas=  <span class="ninfo"></span><?php /*echo $receptividad['totales'];*/?></strong>
			</div>-->
			<div  class="barra_indice" style="background-color:#b285bc; padding:5px;">
				<strong>Viviendas Totales =  <span class="ninfo"><?php echo $receptividad['totales'];?></span></strong>
			</div>

		</div>

		<h2>Indices de infestaci&oacute;n</h2>
			<div class="container_indices">
				<div class="barra_indice" style=" background-color:#f58584; padding:5px;">
					<strong>Total de viviendas infestadas =</strong> <span class="ninfo"><?php echo $positivas['totales'];?></span>
				</div>
				<div  class="barra_indice" style="background-color:#fecd67; padding:5px;">
					<strong>Total de viviendas con infestación en peridomicilio = </strong> <span class="ninfo"><?php echo $cant_infeccion_peri1;
		?></span><strong>

				</div>

				<div  class="barra_indice" style="background-color:#6dab6a; padding:5px;">
					<strong>Total de viviendas con infestación en intradomicilio = </strong> <span class="ninfo"><?php echo $cant_infeccion_intra1;
		?></span>
				</div>

				<div  class="barra_indice" style="background-color:#6dab6a; padding:5px;">
					<strong>Total de viviendas con infestación en intra y peridomicilio = </strong> <span class="ninfo"><?php echo $cant_infeccion_ambos;
		?></span>
				</div>

				<div class="barra_indice" style=" background-color:#3e8ecd; padding:5px;">
					<strong>Indice de infestaci&oacute;n =</strong> <span class="ninfo"><?php echo $idi . ' %';
		?></span><strong>
				</div>

				<div class="barra_indice" style=" background-color:#3e8ecd; padding:5px;">
					<strong>Indice de infestaci&oacute;n intradomiciliar =</strong> <span class="ninfo"><?php echo $idi_intra . ' %';
		?></span><strong>
				</div>

<!--				<div class="barra_indice" style=" background-color:#3e8ecd; padding:5px;">
					<strong>Indice de infestaci&oacute;n peridomicilio =</strong> <span class="ninfo"><?php /*echo $idi_peri;
		*/?></span><strong>
				</div>

				<div class="barra_indice" style=" background-color:#3e8ecd; padding:5px;">
					<strong>Indice de infestaci&oacute;n intra y peridomicilio =</strong> <span class="ninfo"><?php /*echo $idi_ambos;
		*/?></span><strong>
				</div>-->

				<div  class="barra_indice" style="background-color:#b285bc; padding:5px;">
					<strong>Cobertura de acciones de campo = </strong> <span class="ninfo"><?php echo $receptividad['totales']<>0 ? round(($receptividad['receptiva'] / $receptividad['totales'])*100, 2):0	 /*$cobertura*/ . ' %';?></span>
				</div>

			</div>
			<h2>Sitios de hallazgo</h2>
			<div style="width:1250px;height:350px; padding:10px; ">
				<div id="container3" style="width:1190px; float:left;  padding:10px;height: 300px; margin: 0 auto; border: 1px solid #000;"></div>
				<br>
				<div id="container" style="width:/*410px*/610px; float:left;  padding:10px;height: 300px; margin: 0 auto; border: 1px solid #000;"></div>
				<div id="container1" style="width:/*370px*/580px; float:left; padding:10px;height: 300px; margin: 0 auto; border: 1px solid #000;"></div>
				<!--<div id="container2" style="width:410px;  float:left;padding:10px;height: 300px; margin: 0 auto; border: 1px solid #000;"></div>-->
			</div>
			<br>
			<div style="width:1250px; padding:5px;  clear:both;">
				<div style="width:/*410px*/610px; float:left; border-right:1px solid #000;padding:5px;">
		<?php foreach ($porLugar_intra as $k => $v) {?>
					    <span> <b> <?php echo $k;
			?> :</b></span>  <?php echo $v;
			?>,
			<?php }?>
		</div>
				<div style="width:/*410px*/580px; float:left; border-right:1px solid #000;padding:5px;">
		<?php foreach ($porLugar_peri as $k1 => $v1) {?>
					    <span> <b> <?php echo $k1;
			?> :</b></span>  <?php echo $v1;
			?>,
			<?php }?>
		</div>
<!--				<div style="width:410px; float:left;padding:5px;">
		<?php /*foreach ($ambos as $k2 => $v2) {*/?>
					    <span> <b> <?php /*echo $k2;
			*/?> :</b></span>  <?php /*echo count($v2);
			*/?>,
			<?php /*}*/?>
		</div>-->
			</div>
		<?php }?>
	<br>
	<br>

	<hr>
		<div class="panel_informes">
		<h2>Tabla de viviendas positivas</h2>
		<hr>
	<?php
	echo form_open_multipart(base_url().'admin/informes/exportar_excel_vivienda/'.$sede[0]->id);

	?>

	   <label for='fecha_desde'>Desde </label>

	    <input id="desde_v" name="desde_v" size="10" />
	    <label for='fecha_hasta'>Hasta </label>
	    <input id="hasta_v" name="hasta_v" size="10" />
	    <input type='hidden' name='id_form' value='<?php echo $form;?>'>
	    <label for='barrios'> Barrios </label>
	   <select id="barrios" name="barrios">
	        <option value="">Todos</option>
	<?php

	foreach ($barrios as $b) {
		if ($barrio == $b->id) {
			echo '<option value="'.$b->id.'" selected>'.$b->nombre.'</option>';
		} else {
			echo '<option value="'.$b->id.'">'.$b->nombre.'</option>';
		}
	}
	?>

	    </select>
	    <label for='manzana'>Manzana </label>
	    <input id="manzana" name="manzana" size="5" value="<?php echo (isset($cmanzana))?$manzana:'';?>" />

	    <label for='ciclo'>Ciclo/Muestreo </label>.

	    <select id="ciclos" name="ciclos">
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
	   	<br>
	    <input type="submit" name="submit" value="Exportar excel"  />
	    <input type="submit" name="submit" value="Exportar dbf"  />

	</form>
	<hr>
		<div style="width:550px; height:300px; overflow-y:scroll; border:1px solid #000;">
			<table>
				<thead>
					<th>ID</th>


				</thead>
				<tbody>

	<?php foreach ($viviendas_positivas as $viv_pos) {?>
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

