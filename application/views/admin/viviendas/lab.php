<h2>Id Vivienda: <?php echo $lab[0]->id_vivienda ?></h2>
<table id='example1' class='display datatable' >
	<thead>
		<tr>
			
			<th>Ciclo</th>
			<th>Nro Muestra</th>
			<th>Etapa</th>
			<th>Cantidad</th>
			<th>Fecha</th>
			<th>Especie</th>
			<th>Informe Laboratorio</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($lab as $l){ ?>
		<tr>
			
			<td><?php echo $l->ciclo; ?></td>
			<td><?php echo $l->codigo; ?></td>
			<td><?php echo $l->etapa; ?></td>
			<td>
				<?php if($l->cantidad==1){
					echo "1 a 10";
					}else if($l->cantidad==2){ 
					echo "11 a 50";	
					}else if($l->cantidad==3){ 
					echo "51 a 100";	
					}else if($l->cantidad==4){
					echo "100 o mas";
					} 




						?>
			</td>
			<td><?php echo $l->fecha_positiva; ?></td>
			<td>
				<?php echo ($l->que_en_lab!='')?$l->que_en_lab:'esperando informe'; ?>

			</td>
			<td>
				<?php echo ($l->insecto_infectado!='')?$l->insecto_infectado:'esperando informe'; ?>

			</td>
			<td><a href="<?php echo base_url(); ?>admin/viviendas/edita_lab/<?php echo $l->id; ?>/<?php echo $items[0]->id; ?>">editar</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>