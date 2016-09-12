<div class="top-bar">
<?php if ($this->session->userdata('type') == 1 || $this->session->userdata('type') == 10) {?>
										    <a href="<?php echo base_url();?>admin/viviendas/crea" class="button nuevo">Nueva Vivienda</a>


	<?php }?>
    <h1 class="titulo">Administraci&oacute;
n de viviendas del barrio <?php echo $barrio[0]->nombre;
?></h1>
    <strong>Sedes: </strong>


<?php

foreach ($sedes as $se) {
	if ($sede == $se->id) {
		?>
					<a href="<?php echo base_url();?>admin/viviendas/index/<?php echo $se->id;?>" style="font-weight:bold;"><?php echo $se->localidad;
		?></a> |
		<?php } else {?>
																				              <a href="<?php echo base_url();?>admin/viviendas/index/<?php echo $se->id;?>" ><?php echo $se->localidad;
		?></a> |
		<?php
	}
}?>
<br>
    <br>
    <br>

</div>
<?php
if ($this->session->flashdata('message')) {
	echo "<div class='message'>".$this->session->flashdata('message')."</div> ";
}
?>
<div class="table1">
   <table id='example1' class='display datatable' border='0' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>
                <th>Sede</th>
                 <th>Id Vivenda</th>
                 <th>Barrio</th>
                 <th>Inspec. en ciclos</th>
                 <th>Positiva en ciclos</th>



               <th>Acciones</th>

                <th style="width:180px;">Herramientas</th>
            </tr>
        </thead>
        <tbody>
<?php

if (!is_null($items)) {
	if (isset($items) && count($items) > 0) {
		foreach ($items as $u) {

			?>
																														                <tr>
																														                        <td> <?php echo $u->id_sede;?></td>
																														                        <td class="nombre_fuente"> <?php echo $u->idv;?> </td>
																														                        <td><?php

			$barrio = $this->barrio->getbarrioId($u->id_barrio);
			if (isset($barrio[0])) {
				echo $barrio[0]->nombre;
			} else {
				echo "barrio no cargado";
			}
			?></td>

			<?php
			$inspeccion = $this->vivienda->inspecciones($u->idv);

			if (isset($inspeccion[0])) {
				$lnk = '';
				$ca  = count($inspeccion);
				$cc  = 0;
				foreach ($inspeccion as $ins) {
					$cc++;
					$separador1 = ($cc < $ca)?', ':'';
					$cic        = $this->ciclo->getCicloById($ins->ciclo, $u->id_sede);
					if (isset($cic[0]->ciclo)) {
						$lnk .= $cic[0]->ciclo.' '.$separador1;
					}
				}

				?>
																																								                        <td class="nombre_fuente"> <?php echo $lnk;?></td>
				<?php } else {?><td class="nombre_fuente"> &nbsp; </td>
				<?php }?>

			<?php
			$positiva = $this->vivienda->esPositiva($u->idv);
			if (isset($positiva[0])) {
				$links = '';
				$cant  = count($positiva);
				$c     = 0;
				foreach ($positiva as $pos) {
					$c++;
					$separador = ($c < $cant)?', ':'';
					$cic1      = $this->ciclo->getCicloById($pos->ciclo, $u->id_sede);

					if (isset($cic1[0]->ciclo)) {
						$links .= $cic1[0]->ciclo.' '.$separador;
					}
				}?>
																																								                            <td class="nombre_fuente"> <?php echo $links;?></td>
				<?php } else {?><td class="nombre_fuente"> &nbsp; </td>
				<?php }?>

																														                        <td>


																														                            <a href="<?php echo base_url();?>admin/viviendas/grupo/<?php echo $u->id;?>" ><img src="<?php echo base_url();?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Familia </a> |
			<?php

			if (count($positiva) > 0) {?>
																																								                            <a href="<?php echo base_url();?>admin/viviendas/lab/<?php echo $u->id;?>" ><img src="<?php echo base_url();?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Lab </a> |
				<?php }?>
																														                            <a href="<?php echo base_url();?>admin/viviendas/verVivienda/<?php echo $u->id;?>" ><img src="<?php echo base_url();?>assets/img/ojo.png" width="16" height="16" alt="" /> Ver </a>

																														                        </td>
																														                        <td class="herramientas_fuentes">
																														                        <a href="<?php echo base_url();?>admin/viviendas/edita/<?php echo $u->id;?>" ><img src="<?php echo base_url();?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Editar </a>
			<?php if ($admin == 1) {?>
																																								                        <a href="<?php echo base_url();?>admin/viviendas/borra/<?php echo $u->id;?>/<?php echo $u->idv;?>" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url();?>assets/img/hr.gif" width="16" height="16" alt="" /> </a> Borrar</td>
				<?php }?>
			</tr>
			<?php }
	} else {?>
		<tr><td>No hay viviendas cargados actualmente</td></tr>
		<?php }

} else {?>
	<tr><td>No hay viviendas cargados actualmente</td></tr>
	<?php }
?>
</tbody>
    </table>

</div>
