<h2>Informes de la sede <?php echo $sede[0]->localidad;?></h2>

<!--<a href="<?php echo base_url();?>admin/informes/informes_print/<?php echo $sede[0]->id;?>" target="_blank"> Imprimir </a>-->
<hr>
<?php

echo form_open_multipart(base_url().'admin/informes/index/');

?>

   <label for='desde'>Fecha desde</label>
    <input id="desde" name="desde" size="15" value="<?php echo $desde;?>" />
    <label for='hasta'>Fecha hasta</label>
    <input id="hasta" name="hasta" size="15" value="<?php echo date('Y-m-d');?>"  />
    <input type='hidden' name='id_sede' value='<?php echo $sede[0]->id;?>'>
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
    <input id="manzana" name="manzana" size="5" value="<?php echo (isset($manzana))?$manzana:'';?>" />
    <label for='ciclo'>Ciclo/Muestreo </label>.

    <select id="ciclos" name="filtro_ciclos[]" multiple="multiple">
        <option value="">Todos</option>
<?php

foreach ($ciclos as $ciclo) {
	if (in_array($ciclo, $filtro_ciclos)) {
		echo '<option value="'.$ciclo->id.'" selected>'.$ciclo->ciclo.' '.$ciclo->tipo.'</option>';
	} else {
		echo '<option value="'.$ciclo->id.'">'.$ciclo->ciclo.' '.$ciclo->tipo.'</option>';
	}
}
?>
</select>
    <select name="zona" id="zona">
        <option value="">Todas</option>
<?php if ($zona == 'rural') {?>
	<option value="rural" selected>Rural</option>
	            <option value="urbano">Urbana</option>
	<?php } else if ($zona == 'urbano') {?>
	<option value="rural">Rural</option>
	            <option value="urbano" selected>Urbana</option>
	<?php } else {?>
	<option value="rural">Rural</option>
	            <option value="urbano">Urbana</option>
	<?php }?>
</select>
	<input type="submit" name="submit" value="Aplicar Criterios" />

</form>