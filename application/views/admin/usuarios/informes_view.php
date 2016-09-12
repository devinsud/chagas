 <div class="top_logo_print"></div>
<div style="width:500px; margin-bottom:10px;">
	<?php if(isset($nombre_sede) && $nombre_sede!=''){ ?>
			<h1 style="margin-left:10px;margin-top:-112px;">Informe de usuarios de la sede <?php echo $nombre_sede; ?></h1>
<?php }else{?>
			<h1 style="margin-left:10px;margin-top:-112px;">Informe de usuarios de todas las sedes </h1>
<?php } ?>
<h2 style="margin-left:10px;">Total de viviendas relevadas:  <?php echo $cant_total; ?></h2>
<?php if($desde !='' && $hasta !=''){?>
	<h2 style="margin-left:10px;">Para el periodo : <?php echo $desde; ?> | <?php echo $hasta; ?> :  </h2>
<?php } ?>

<?php if($ciclo !=''){?>
	<h2 style="margin-left:10px;">Ciclo : <?php echo $ciclo; ?> </h2>
<?php }else{ ?>
	<h2 style="margin-left:10px;">Ciclo : Todos  </h2>
<?php } ?>

<?php if(count($usuarios)>0){  ?>
<table id="Usuarios" style="margin:10px;">
	<thead>
		
		<th> Sede </th>
		<th> Nombre </th>
		<th> Apellido </th>
		<th> Cantidad de Viviendas Relevadas </th>
		
	</thead>
	<tbody>
		<?php foreach($usuarios as $val){ 
			
			$datos = $this->user->get_estadistica_by_user($val->id);
			//$data['datos'] = $datos['cargados'];
        	$cant = count($datos['cargados']);
			?>
		<tr>
			<td><?php 

			$se =  $this->sede->getSedeId($val->sede); 
			echo $se[0]->localidad; ?></td>
			<td> <?php echo $val->nombre; ?> </td>
			<td> <?php echo $val->apellido; ?> </td>
			<td> <?php echo $cant; ?> </td>
			
		</tr>
		<?php } ?>
	</tbody>
</table>
<div id="user"></div>

</div>
<?php }else{ ?>
<div style="width:250px;  padding:20px; border:1px solid #000; margin-top:100px; margin-left:150px;"><h2>El Criterio no devolvi&oacute; resultados</h2></div>
	
</div>
<?php } ?>
<a href="#" onclick="javascript:window.print()" style="position:relative;top:7px;left:5px;"> <img src="<?php echo base_url(); ?>assets/img/print.jpg"  width="20"/> </a>