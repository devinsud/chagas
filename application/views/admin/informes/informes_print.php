

   
<h2>Informes de la sede <?php echo $sede[0]->localidad; ?></h2>

<a href="<?php echo base_url(); ?>admin/informes/informes_print/<?php //echo $form; ?>" target="_blank"> Imprimir </a>
<hr>
 <?php   

echo form_open_multipart(base_url().'admin/informes/index/');

?>
  
   <label for='fecha_desde'>Fecha desde </label>
    <input id="desde" name="desde" size="15" value="<?php echo $desde; ?>" />
    <label for='fecha_hasta'>Fecha hasta </label>
    <input id="hasta" name="hasta" size="15" value="<?php echo $hasta; ?>"  />
    <input type='hidden' name='id_sede' value='<?php echo $sede[0]->id;?>'>
    <label for='barrios'> Barrios </label>

    <select id="barrios" name="barrios">
        <option value="">Todos</option>
        <?php 

        foreach ($barrios as $b) {
        	if($barrio==$b->id){
        		echo '<option value="' . $b->id . '" selected>'. $b->nombre .'</option>';
        	}else{
            	echo '<option value="' . $b->id . '">'.  $b->nombre .'</option>';
        	}
        }
        ?>
                    
    </select>   
	<label for='ciclo'>Ciclo desde </label>
    <input id="ciclo" name="ciclo_desde" size="5" value="<?php echo (isset($ciclo_desde))?$ciclo_desde:'';?>" />
     
     <label for='ciclo'>Ciclo hasta </label>
    <input id="ciclo" name="ciclo_hasta" size="5" value="<?php echo (isset($ciclo_hasta))?$ciclo_hasta:'';?>" />
     
    
     <input type="submit" name="submit" value="Aplicar Criterios" /> 
   
</form>
<hr>




<?php


// $ivi = ($inf['iv']['positivos']/$inf['iv']['cant_iv'])*100;
// $ibi =($inf['ib']['criaderos_totales']/$inf['ib']['cant_ib'])*100;
// $iri =($inf['ir']['criaderos_totales']/$inf['ir']['rec_con_agua'])*100;
 /*$ivi = ($viviendas->viviendas_positivas/$viviendas->inspeccionadas)*100;
 $ibi =($viviendas->rec_positivos/$viviendas->inspeccionadas)*100;
 $iri =($viviendas->rec_positivos/$viviendas->rec_conagua)*100;
*/
?>
<div class="panel_informes">
<h2>Viviendas</h2>
<div class="container_indices">
	
	<div class="barra_indice" style=" background-color:#f58584; padding:5px;">
		<strong>Viviendas Inspeccionadas = <span class="ninfo"><?php echo $receptividad['receptiva']; ?></span></strong>
	</div>
	<div  class="barra_indice" style="background-color:#fecd67; padding:5px;">
		<strong>Viviendas Cerradas =  <span class="ninfo"><?php echo $receptividad['cerrada']; ?></span></strong>
	</div>
	<div  class="barra_indice" style="background-color:#6dab6a; padding:5px;">
		<strong>Viviendas Renuentes =  <span class="ninfo"><?php echo $receptividad['renuente']; ?></span></strong>
	</div>
	<div  class="barra_indice" style="background-color:#3e8ecd; padding:5px;">
		<strong>Viviendas Deshabitadas =  <span class="ninfo"><?php echo $receptividad['deshabitada']; ?></span></strong>
	</div>
	<div  class="barra_indice" style="background-color:#b285bc; padding:5px;">
		<strong>Viviendas Totales =  <span class="ninfo"><?php echo $receptividad['totales']; ?></span></strong>
	</div>
	
</div>

<h2>Indices de infestaci&oacute;n</h2>
<div class="container_indices">
	<div class="barra_indice" style=" background-color:#f58584; padding:5px;">
		<strong>Total de viviendas infestadas =</strong> <span class="ninfo"><?php echo $positivas['totales']; ?></span> 
	</div>
	<div  class="barra_indice" style="background-color:#fecd67; padding:5px;">
		<strong>Total infestaci&oacute;n peridomicilio = </strong> <span class="ninfo"><?php echo $positivas['peri']; ?></span><strong>
		
	</div>

	<div  class="barra_indice" style="background-color:#6dab6a; padding:5px;">
		<strong>Total infestaci&oacute;n intadomicilio = </strong> <span class="ninfo"><?php echo $positivas['intra']; ?></span>
	</div>

	
	<div class="barra_indice" style=" background-color:#3e8ecd; padding:5px;">
		<strong>Indice de infestaci&oacute;n =</strong> <span class="ninfo"><?php echo $idi; ?></span><strong>
	</div>
	<div  class="barra_indice" style="background-color:#b285bc; padding:5px;">
		<strong>Cobertura de acciones de campo = </strong> <span class="ninfo"><?php echo $cobertura; ?></span>
	</div>
	
</div>
<h2>Sitios de hallazgo</h2>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

</div>
	<?php foreach($porLugar as $k=>$v){?>
	    <span> <b> <?php echo $k; ?> :</b></span>  <?php echo $v; ?> ,
	<?php } ?>




</div>
