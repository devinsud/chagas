<div style="width:290px; height:300px; padding:10px; border:1px solid #000; float: left;">

	<div>
		<label>
			Id Vivienda
		</label>
<?php echo $items[0]->id_vivienda;?>
</div>
	<br>
	<div>
		<label>
			Tipo
		</label>
<?php echo $items[0]->tipo;?>
</div>
	<br>

	<div>
		<label>
			Latitud
		</label>
<?php echo $items[0]->latitud;?>
</div>
	<br>
	<div>
		<label>
			Longitud
		</label>
<?php echo $items[0]->longitud;?>
</div>

	<br>
	<div>
		<label>
			Habitantes
		</label>
<?php

$hab = $this->vivienda->getHabitantes($items[0]->id_vivienda);
echo $hab;?>
</div>
</div>
<div id="map" style="left:10px;width:400px; height:300px;border:1px solid #000;"></div>


<h2>Inspecci&oacute;n</h2>
<table border="1" style="width:700px;" id="example1">
	<tr>
		<th>Ciclo</th>
		<th>Receptividad</th>
		<th>Vigilancia</th>

		<th>Fecha Inspección</th>
<th>Fecha carga</th>
		<th>Operador</th>
		<th>Jefe de familia</th>
		<th>Observaciones de la inspección</th>

<?php if ($admin) {?>
	<th>Acciones</th>
	<?php }?>
</tr>

<?php

foreach ($inspecciones as $in) {

	$ciclo = $this->ciclo->getCicloById($in->ciclo, $items[0]->id_sede);
	?>
						<tr>
							<td> <?php
	if (isset($ciclo[0])) {
		echo $ciclo[0]->ciclo;
	} else {
		echo '&nbsp;';
	}?>
							</td>
							<td> <?php echo $in->receptividad_vivienda;?></td>
							<td> <?php echo $in->vigilancia_entomologica;?></td>

							<td> <?php echo $in->fecha_inspeccion;?></td>
					<td> <?php echo $in->fecha_carga_inspeccion;?></td>
							<td><?php
	$ops = explode('&&', $in->id_operador);

	foreach ($ops as $op) {

		$usr = $this->vivienda->getOperadorById($op);

		if (isset($usr[0])) {
			echo $usr[0]->nombre.', '.$usr[0]->apellido;
			echo " - ";
		}
	}
	?>

							</td>
							<td> <?php
	if (isset($jefe[0]->nombre)) {
		echo $jefe[0]->nombre;
	} else {
		echo 'no cargado';
	}
	?></td>
							<td>
	<?php
	if (isset($in->observaciones)) {
		echo $in->observaciones;
	} else {
		echo 'no cargado';
	}
	?>
	</td>
	<?php if ($admin) {?>
													<td> <a href="<?php echo base_url();?>admin/viviendas/eliminaInspeccion/<?php echo $in->id_inspeccion;?>/<?php echo $idv;?>"><img src="<?php echo base_url();?>assets/img/hr.gif"></a>
		<?php if ($in->vigilancia_entomologica == 'positiva') {?>
																		|
																				<a href="#" onclick="muestraPos('pos<?php echo $in->id_inspeccion;?>')"><img src="<?php echo base_url();?>assets/img/FlechaAbajo.png" height="32" ></a>
			<?php }?>
		</td>

		<?php } else {
		$fecha           = $in->fecha_inspeccion;
		$segundos        = strtotime($fecha)-strtotime('now');
		$diferencia_dias = intval($segundos/60/60/24);

		if ($diferencia_dias == 0) {?>
																			<td> <a href="<?php echo base_url();?>admin/viviendas/eliminaInspeccion/<?php echo $in->id_inspeccion;?>/<?php echo $idv;?>"><img src="<?php echo base_url();?>assets/img/hr.gif"></a>
			<?php if ($in->vigilancia_entomologica == 'positiva') {?>
																								|
																										<a href="#" onclick="muestraPos('pos<?php echo $in->id_inspeccion;?>')"><img src="<?php echo base_url();?>assets/img/FlechaAbajo.png" height="32" ></a>
				<?php }?>
																			|
																			 <a href="<?php echo base_url();?>admin/viviendas/editarInspeccion/<?php echo $in->id_inspeccion;?>/<?php echo $idv;?>"><img src="<?php echo base_url();?>assets/img/lista.png"></a>
																			</td>
			<?php	} else {
			if ($in->vigilancia_entomologica == 'positiva') {?>
																								<td><a href="#" onclick="muestraPos('pos<?php echo $in->id_inspeccion;?>')"><img src="<?php echo base_url();?>assets/img/FlechaAbajo.png" height="32" ></a></td>
				<?php }
		}

	}?>
	</tr>

	<?php if ($in->vigilancia_entomologica == 'positiva') {?>
														<tr  id="pos<?php echo $in->id_inspeccion;?>" style="display:none;">
															<td colspan="7">
																<table style="width:500px;" border="1">


																	<tr>
																		<th>Donde</th>
																		<th>Estadio</th>
																		<th>Fecha</th>
		<?php if ($admin) {?>
			<th>Acciones</th>
			<?php }?>
		</tr>
		<?php
		$positivas = $this->vivienda->getPositivasByIdInspeccionYVivienda($in->id_inspeccion, $in->id_vivienda);

		foreach ($positivas as $pos) {
			$lugar       = (isset($pos->donde))?$pos->donde:$pos[0]->donde;
			$nombreLugar = $this->lugar->getLugarById($lugar);
			?>
																							<tr>
																								<td><?php echo $nombreLugar;?></td>
																								<td><?php echo $pos->etapa;?></td>
																								<td><?php echo $pos->fecha_positiva;?></td>
			<?php if ($admin) {?>
																														<td><a href="<?php echo base_url();?>admin/viviendas/eliminaPositiva/<?php echo $pos->id;?>/<?php echo $idv;?>"><img src="<?php echo base_url();?>assets/img/hr.gif"></a></td>
				<?php }?>
			</tr>
			<?php }?>
		</table>
															</td>
														</tr>

		<?php }
}?>
</table>
<br><br>
<h2>Grupo Familiar</h2>
<table border="1" style="width:700px;">
	<tr>
		<th>Ciclo</th>
		<th>Nombre</th>
		<th>Fecha</th>
		<th>Relacion</th>
<?php if ($admin) {?>
	<th>Acciones</th>
	<?php }?>
</tr>

<?php foreach ($grupo as $g) {
	$g_nom   = (isset($g->nombre))?$g->nombre:'';
	$g_relac = (isset($g->relacion))?$g->relacion:'';

	$cic = (isset($ciclo[0]))?$ciclo[0]->ciclo:0;

	?>

						<tr>
							<td> <?php echo $cic;?></td>
							<td> <?php echo $g_nom;?></td>
							<td> <?php echo $g->fecha;?></td>
							<td> <?php
	$rela = $this->vivienda->getRelacionById($g_relac);
	echo $rela;?></td>
	<?php if ($admin) {?>
													 <td> <a href="<?php echo base_url();?>admin/viviendas/eliminaGrupo/<?php echo $g->id;?>/<?php echo $idv;?>"><img src="<?php echo base_url();?>assets/img/hr.gif"></a> </td>
		<?php }?>
	</tr>
	<?php }?>
</table>

<div>
<h2>Observaciones Generales</h2>
<?php
$attributes = array('id' => 'id-form', 'class' => 'form-horizontal');
echo form_open_multipart(base_url().'admin/viviendas/observaciones', $attributes);?>
			<input type="hidden" id='idv' name="idv" value="<?php echo $idv;?>">
			<textarea name="observacion" id="" cols="107" rows="20"><?php echo $items[0]->observaciones;?></textarea>
			<br>
			<input type="submit" value="Guardar Observaciones">
<?php form_close();?>
</div>



<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>


	function initialize() {
	  var myLatlng = new google.maps.LatLng(<?php echo $items[0]->latitud;?>,<?php echo $items[0]->longitud;?>);
	  var mapOptions = {
	    zoom: 10,
	    center: myLatlng
	 }
  var map = new google.maps.Map(document.getElementById('map'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map
  });
}

google.maps.event.addDomListener(window, 'load', initialize);


</script>
