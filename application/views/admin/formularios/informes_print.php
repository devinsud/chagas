 <div class="top_logo_print">
               <img src="<?php echo base_url(); ?>assets/img/logo.png"  alt=""  height="86" />
                <h2 style="margin-left:140px;margin-top:-112px;">Informes de la sede <?php echo $sede->localidad; ?></h2>
 				<div style="width:400px; margin-left:135px; border:1px solid #000; padding:10px;">
				 <?php   

				echo form_open_multipart(base_url().'admin/formularios/informes_print/'.$form);

				?>
				  
				   <label for='fecha_desde'>Fecha Desde </label>
				    <input id="desde" name="desde" size="10" value="<?php echo $desde; ?>" />
				    &nbsp;&nbsp;&nbsp;&nbsp;
				    <label for='fecha_hasta'>Fecha Hasta </label>
				    <input id="hasta" name="hasta" size="10" value="<?php echo $hasta; ?>"  />
				    <input type='hidden' name='id_form' value='<?php echo $form;?>'>
				    <br><br>
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
				    
				     <label for='ciclo'>Ciclo </label>
				    <input id="ciclo" name="ciclo" size="7" value="<?php echo $ciclo; ?>" />
				    
				     <input type="submit" name="submit" value="Filtrar" /> 
				     <a href="#" onclick="javascript:window.print()" style="position:relative;top:7px;left:5px;"> <img src="<?php echo base_url(); ?>assets/img/print.jpg"  width="20"/> </a>
				   
				</form>


				</div>

				 </div>
<?php

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
		<strong>Viviendas Inspeccionadas =</strong> <?php echo $viviendas->inspeccionadas; ?><strong>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67;">
		<strong>Viviendas Cerradas = </strong> <?php echo $viviendas->cerradas; ?>
	</div>
	<div  class="barra_indice" style="background-color:#6dab6a;">
		<strong>Viviendas Renuentes = </strong> <?php echo $viviendas->renuentes; ?>
	</div>
	<div  class="barra_indice" style="background-color:#3e8ecd;">
		<strong>Viviendas Totales = </strong> <?php echo $viviendas->totales; ?>
	</div>
	<div  class="barra_indice" style="background-color:#b285bc;">
		<strong>Viviendas Positivas = </strong> <?php echo $viviendas->viviendas_positivas; ?>
	</div>
</div>

<h2>Indices de infestaci&oacute;n</h2>
<div class="container_indices">
	<div class="barra_indice" style=" background-color:#f58584;">
		<strong>Índice de Vivienda (IV) =</strong> <?php echo round($ivi,2); ?><strong>%</strong> <span class="mini">( <?php echo $viviendas->viviendas_positivas;?> viviendas positivas / <?php echo $viviendas->inspeccionadas;?> viviendas inspeccionadas )</span>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67;">
		<strong>Índice de Breteau  (IB) = </strong> <?php echo round($ibi); ?><strong>
		 </strong> <span class="mini">( <?php echo $viviendas->rec_positivos;?> criaderos de A. aegypti / <?php echo $viviendas->inspeccionadas;?> viviendas inspeccionadas )</span>
	</div>

	<div  class="barra_indice" style="background-color:#6dab6a;">
		<strong>Índice de Recipientes (IR) = </strong> <?php echo round($iri,2); ?><strong>%</strong> <span class="mini">( <?php echo $viviendas->rec_positivos;?> criaderos de A. aegypti / <?php echo $viviendas->rec_conagua;?> recipientes con agua )</span>
	</div>
</div>

<h2>Recipientes</h2>
<div class="container_indices">
	
	<div class="barra_indice" style=" background-color:#f58584;">
		<strong>Recipientes Totales =</strong> <?php echo $viviendas->rec_totales; ?><strong>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67;">
		<strong>Recipientes con agua = </strong> <?php echo $viviendas->rec_conagua; ?>
	</div>
	<div  class="barra_indice" style="background-color:#6dab6a;">
		<strong>Recipientes con larvas/pupas = </strong> <?php echo $viviendas->rec_conlarvas; ?>
	</div>
	<div  class="barra_indice" style="background-color:#3e8ecd;">
		<strong>Recipientes positivos = </strong> <?php echo $viviendas->rec_positivos; ?>
	</div>
</div>

<h2>Viviendas tratadas</h2>
<div class="container_indices">
	
	<div class="barra_indice" style=" background-color:#f58584;">
		<strong>Viviendas tratadas = </strong> <?php echo $viviendas->tratadas; ?><strong>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67;">
		<strong>Larvicida aplicado (gr) = </strong> <?php echo $viviendas->larvicida; ?>
	</div>
	
</div>
<br><br><br><br><br>
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
			<td> <?php echo $inf['recipientes']['pos_t']; ?> </td>
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
			<td> <?php echo $inf['porcentajes']['porc_h']; ?></td>
		
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

