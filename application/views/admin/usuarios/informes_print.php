 <div class="top_logo_print">
               <img src="<?php echo base_url(); ?>assets/img/logo.png"  alt=""  height="86" />
               <?php if(isset($sede) && $sede!=''){ ?>
                <h2 style="margin-left:140px;margin-top:-112px;">Informes de la sede <?php echo $sede; ?></h2>
                <?php }else{?>
                		<h2 style="margin-left:140px;margin-top:-112px;">Informe de usuarios de todas las sedes <?php echo $sede; ?></h2>
                <?php } ?>
 				<div style="width:337px; margin-left:135px; border:1px solid #000; padding:10px;">
				 <?php   

				echo form_open_multipart(base_url().'admin/usuarios/informes_print');

				?>
				  
				   <label for='fecha_desde'>Fecha Desde </label>
				    <input id="desde" name="desde" size="10" value="<?php echo $desde; ?>" />
				    &nbsp;&nbsp;&nbsp;&nbsp;
				    <label for='fecha_hasta'>Fecha Hasta </label>
				    <input id="hasta" name="hasta" size="10" value="<?php echo $hasta; ?>"  />

				    <br><br>
				    
				    
				     <label for='ciclo'>Ciclo </label>
				    <input id="ciclo" name="ciclo" size="7" value="<?php echo $ciclo; ?>" />
				    
				     <input type="submit" name="submit" value="Filtrar" /> 
				     <a href="#" onclick="javascript:window.print()" style="position:relative;top:7px;left:5px;"> <img src="<?php echo base_url(); ?>assets/img/print.jpg"  width="20"/> </a>
				   
				</form>


				</div>

				 </div>







<div style="width:500px; margin-bottom:10px;">
<h2>Usuarios</h2>
<?php if(count($usuarios)>0){ ?>
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
			<td><?php echo $val->sede; ?></td>
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
