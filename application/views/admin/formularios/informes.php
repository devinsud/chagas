

   
<h2>Informes de la sede <?php echo $sede->localidad; ?></h2>

<a href="<?php echo base_url(); ?>admin/formularios/informes_print/<?php echo $form; ?>" target="_blank"> Imprimir </a>
<hr>
 <?php   

echo form_open_multipart(base_url().'admin/formularios/informes/'.$form);

?>
  
   <label for='fecha_desde'>Fecha desde </label>
    <input id="desde" name="desde" size="15" value="<?php echo $desde; ?>" />
    <label for='fecha_hasta'>Fecha hasta </label>
    <input id="hasta" name="hasta" size="15" value="<?php echo $hasta; ?>"  />
    <input type='hidden' name='id_form' value='<?php echo $form;?>'>
    <label for='barrios'> Barrios </label>

    <select id="barrios" name="barrios">
        <option value="">Todos</option>
        <?php 

        foreach ($barrios as $key => $value) {
        	if($barrio==$key){
        		echo '<option value="' . $key . '" selected>'. $value .'</option>';
        	}else{
            	echo '<option value="' . $key . '">'. $value .'</option>';
        	}
        }
        ?>
                    
    </select>   

     <label for='ciclo'>Ciclo/Muestreo </label>
    <input id="ciclo" name="ciclo" size="15" value="<?php echo $ciclo; ?>" />
     <input type="submit" name="submit" value="Aplicar Criterios" /> 
   
</form>
<hr>
<?php
if($viviendas->inspeccionadas>0){
if($inf!==false){
// $ivi = ($inf['iv']['positivos']/$inf['iv']['cant_iv'])*100;
// $ibi =($inf['ib']['criaderos_totales']/$inf['ib']['cant_ib'])*100;
// $iri =($inf['ir']['criaderos_totales']/$inf['ir']['rec_con_agua'])*100;
 $ivi = ($viviendas->viviendas_positivas/$viviendas->inspeccionadas)*100;
 $ibi =($viviendas->rec_positivos/$viviendas->inspeccionadas)*100;
 $iri =($viviendas->rec_positivos/$viviendas->rec_conagua)*100;

?>
<div class="panel_informes">
<h2>Viviendas</h2>
<div class="container_indices">
	
	<div class="barra_indice" style=" background-color:#f58584;">
		<strong>Viviendas Inspeccionadas = <span class="ninfo"><?php echo $viviendas->inspeccionadas; ?></span></strong>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67;">
		<strong>Viviendas Cerradas =  <span class="ninfo"><?php echo $viviendas->cerradas; ?></span></strong>
	</div>
	<div  class="barra_indice" style="background-color:#6dab6a;">
		<strong>Viviendas Renuentes =  <span class="ninfo"><?php echo $viviendas->renuentes; ?></span></strong>
	</div>
	<div  class="barra_indice" style="background-color:#3e8ecd;">
		<strong>Viviendas Totales =  <span class="ninfo"><?php echo $viviendas->totales; ?></span></strong>
	</div>
	<div  class="barra_indice" style="background-color:#b285bc;">
		<strong>Viviendas Positivas =  <span class="ninfo"><?php echo $viviendas->viviendas_positivas; ?></span></strong>
	</div>
</div>

<h2>Indices de infestaci&oacute;n</h2>
<div class="container_indices">
	<div class="barra_indice" style=" background-color:#f58584;">
		<strong>Índice de Vivienda (IV) =</strong> <span class="ninfo"><?php echo round($ivi,2); ?></span><strong>%</strong> <span class="mini">( <?php echo $viviendas->viviendas_positivas;?> viviendas positivas / <?php echo $viviendas->inspeccionadas;?> viviendas inspeccionadas )</span>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67;">
		<strong>Índice de Breteau  (IB) = </strong> <span class="ninfo"><?php echo round($ibi,2); ?></span><strong>
		 </strong> <span class="mini">( <?php echo $viviendas->rec_positivos;?> criaderos de A. aegypti / <?php echo $viviendas->inspeccionadas;?> viviendas inspeccionadas )</span>
	</div>

	<div  class="barra_indice" style="background-color:#6dab6a;">
		<strong>Índice de Recipientes (IR) = </strong> <span class="ninfo"><?php echo round($iri,2); ?></span><strong>%</strong> <span class="mini">( <?php echo $viviendas->rec_positivos;?> criaderos de A. aegypti / <?php echo $viviendas->rec_conagua;?> recipientes con agua)</span>
	</div>
</div>

<h2>Recipientes</h2>
<div class="container_indices">
	
	<div class="barra_indice" style=" background-color:#f58584;">
		<strong>Recipientes Totales =</strong> <span class="ninfo"><?php echo $viviendas->rec_totales; ?></span><strong>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67;">
		<strong>Recipientes con agua = </strong> <span class="ninfo"><?php echo $viviendas->rec_conagua; ?></span>
	</div>
	<div  class="barra_indice" style="background-color:#6dab6a;">
		<strong>Recipientes con larvas/pupas = </strong> <span class="ninfo"><?php echo $viviendas->rec_conlarvas; ?></span>
	</div>
	<div  class="barra_indice" style="background-color:#3e8ecd;">
		<strong>Recipientes positivos = </strong> <span class="ninfo"><?php echo $viviendas->rec_positivos; ?></span>
	</div>
</div>

<h2>Viviendas tratadas</h2>
<div class="container_indices">
	
	<div class="barra_indice" style=" background-color:#f58584;">
		<strong>Viviendas tratadas = </strong><span class="ninfo"> <?php echo $viviendas->tratadas; ?></span>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67;">
		<strong>Larvicida aplicado (gr) = </strong> <span class="ninfo"><?php echo $viviendas->larvicida; ?></span>
	</div>
	
</div>

<div style="width:500px; margin-bottom:10px;">
<h2>Perfil de criaderos</h2>
<table id="perfil_criaderos" style="margin:10px;">
	<thead>
		<th> &nbsp; </th>
		<th> A </th>
		<th> B </th>
		<th> C </th>
		<th> D </th>
		<th> E </th>
		<th> F </th>
		<th> G </th>
		<th> H </th>
		<th> Total </th>
	</thead>
	<tbody>
		<tr>
			<td>Cantidad</td>
			<td> <?php echo $inf['recipientes']['pos_a']; ?> </td>
			<td> <?php echo $inf['recipientes']['pos_b']; ?> </td>
			<td> <?php echo $inf['recipientes']['pos_c']; ?> </td>
			<td> <?php echo $inf['recipientes']['pos_d']; ?> </td>
			<td> <?php echo $inf['recipientes']['pos_e']; ?> </td>
			<td> <?php echo $inf['recipientes']['pos_f']; ?> </td>
			<td> <?php echo $inf['recipientes']['pos_g']; ?> </td>
			<td> <?php echo $inf['recipientes']['pos_h']; ?> </td>

			<?php 
				if(($inf['recipientes']['pos_a']+$inf['recipientes']['pos_b']+$inf['recipientes']['pos_c']+$inf['recipientes']['pos_d']+$inf['recipientes']['pos_e']+$inf['recipientes']['pos_f']+$inf['recipientes']['pos_g']+$inf['recipientes']['pos_h'])>0){

					$total_recipientes = $inf['recipientes']['pos_a']+$inf['recipientes']['pos_b']+$inf['recipientes']['pos_c']+$inf['recipientes']['pos_d']+$inf['recipientes']['pos_e']+$inf['recipientes']['pos_f']+$inf['recipientes']['pos_g']+$inf['recipientes']['pos_h'];
			?>
			<td> <?php echo $total_recipientes; ?></td>
			<?php }else{ ?>
			<td>  0 </td>
			<?php } ?>
		</tr>
		<tr>
			<td> % </td>
			<td> <?php echo $inf['porcentajes']['porc_a']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_b']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_c']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_d']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_e']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_f']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_g']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_h']; ?> </td>
			<td> 100  </td>
		</tr>
	</tbody>
</table>

<table id="perfil_criaderos1" style="margin:10px; display:none;">
	<thead>
		<th> &nbsp; </th>
		<th> A </th>
		<th> B </th>
		<th> C </th>
		<th> D </th>
		<th> E </th>
		<th> F </th>
		<th> G </th>
		<th> H </th>
		<th>Total (<?php echo $total_recipientes; ?>) </th>
		
	</thead>
	<tbody>
		
		<tr>
			<td> % </td>
			<td> <?php echo $inf['porcentajes']['porc_a']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_b']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_c']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_d']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_e']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_f']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_g']; ?> </td>
			<td> <?php echo $inf['porcentajes']['porc_h']; ?> </td>
			<td>100</td>
		
		</tr>
	</tbody>
</table>
<div style="width:500px; padding:10px;">
<strong>A:</strong> Neumáticos; <strong>B:</strong> Tanques – Tambores – Barriles; <strong>C:</strong> Floreros – Planteras; <strong>D:</strong> Materiales de construcción – Piezas de automóviles; <strong>E:</strong> Botellas – Latas – Plásticos; <strong>F:</strong> Pozos – Cisternas; <strong>G:</strong> Naturales; <strong>H:</strong> Otros (lavarropas, heladeras, sanitarios, lonas, canoas, etc.)
</div>
</div>
<?php }else{
	?>
	<div style="width:250px;  padding:20px; border:1px solid #000; margin-top:100px; margin-left:150px;"><h2>El Criterio no devolvi&oacute; resultados</h2></div>
	<?php
} ?>
</div>

<div class="panel_informes">
	<h2>Tabla de viviendas positivas</h2>
	<hr>
 <?php   
echo form_open_multipart(base_url().'admin/formularios/exportar_excel_vivienda/'.$form);

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

        foreach ($barrios as $key => $value) {
        	if($barrio==$key){
        		echo '<option value="' . $key . '" selected>'. $value .'</option>';
        	}else{
            	echo '<option value="' . $key . '">'. $value .'</option>';
        	}
        }
        ?>
                    
    </select>   
    <br>
    <label for='ciclo'>Ciclo/Muestreo </label>
    <input id="ciclo" name="ciclo_v" size="15" value="<?php echo $ciclo_v; ?>" />
    <input type="submit" name="submit" value="Exportar excel"  /> 
    <input type="submit" name="submit" value="Exportar dbf"  /> 
   
</form>
<hr>
	<div style="width:550px; height:300px; overflow-y:scroll; border:1px solid #000;">
		<table>
			<thead>
				<th>ID</th>
				<th>Criaderos</th>

			</thead>
			<tbody>

				<?php foreach($datos as $k_datos=>$v_datos){ ?>
						<tr>
							<td><?php echo $v_datos->idvivienda; ?></td>
							<td><?php echo $v_datos->positivos_total; ?></td>
						</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<br>
	<h2>Tabla de recipientes positivos</h2> 
	 <?php   
		echo form_open_multipart(base_url().'admin/formularios/exportar_excel_recipiente/'.$form);

		?>
		  
		   <label for='fecha_desde'>Desde </label>
		    <input id="desde_r" name="desde" size="10" value="<?php echo $desde; ?>" />
		    <label for='fecha_hasta'>Hasta </label>
		    <input id="hasta_r" name="hasta" size="10" value="<?php echo $hasta; ?>"  />
		    <input type='hidden' name='id_form' value='<?php echo $form;?>'>
		    <label for='barrios'> Barrios </label>
		    <select id="barrios" name="barrios">
		        <option value="">Todos</option>
		        <?php 

		        foreach ($barrios as $key => $value) {
		        	if($barrio==$key){
		        		echo '<option value="' . $key . '" selected>'. $value .'</option>';
		        	}else{
		            	echo '<option value="' . $key . '">'. $value .'</option>';
		        	}
		        }
		        ?>
		                    
		    </select>   
		    <br>
		    <label for='ciclo_r'>Ciclo/Muestreo </label>
            <input id="ciclo_r" name="ciclo_r" size="15" value="<?php echo $ciclo_r; ?>" />
		     <input type="submit" name="submit" value="Exportar excel"  /> 
    			<input type="submit" name="submit" value="Exportar dbf"  /> 
		   
		</form>
		<hr>
	<div style="width:550px; height:300px; overflow-y:scroll; border:1px solid #000;">
		
		<table style="margin-left:5px;">
			<thead>
				<th>ID</th>
				<th> A </th>
				<th> B </th>
				<th> C </th>
				<th> D </th>
				<th> E </th>
				<th> F </th>
				<th> G </th>
				<th> H </th>

			</thead>
			<tbody>

				<?php foreach($datos as $k_datos=>$v_datos){ ?>
						<tr>

							<td><?php echo $v_datos->idvivienda; ?></td>
							<td><?php echo $v_datos->positivos_A; ?></td>
							<td><?php echo $v_datos->positivos_B; ?></td>
							<td><?php echo $v_datos->positivos_C; ?></td>
							<td><?php echo $v_datos->positivos_D; ?></td>
							<td><?php echo $v_datos->positivos_E; ?></td>
							<td><?php echo $v_datos->positivos_F; ?></td>
							<td><?php echo $v_datos->positivos_G; ?></td>
							<td><?php echo $v_datos->positivos_H; ?></td>
						</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php }else{ ?>
	<span>No hay datos para generar el informe, al menos debe haber una vivienda inspeccionada</span>
<?php } ?>