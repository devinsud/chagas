<?php

$attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
echo form_open_multipart(base_url().'admin/ordenes/asienta',$attributes); ?>
	<h1>Resultado del rociado de la vivienda <?php echo $vivienda; ?></h1>
	<fieldset>
	
	<div style="width:700px;">
		<input type="hidden" name="idv" value="<?php echo $vivienda; ?>">
		<input type="hidden" name="orden" value="<?php echo $orden; ?>">
		<div class="control-group">  
		 <label class="control-label" for="quimico">Qu&iacute;mico:</label>
		
		 <input type="checkbox" name="quimico" value="Beta-Cipermetrina" checked  /> Beta-Cipermetrina
		 </div>
		 <div class="control-group">  
		  <label class="control-label" for="cant">Cantidad de monodosis x 100ml: </label>
		 <input type="text" name="cant" value=""  placeholder=""  class="form-control" />
		 </div>
		 <div class="control-group">  
		  <label class="control-label" for="motivo">Motivo del Rociado: </label>
		  					<select name="motivo"  class="form-control" >
	    						<option value=""></option>
	    						<option value="vivienda infectada">vivienda infestada</option>
	    						<option value="vivienda cercana">vivienda cercana</option>
	    						<option value="otros factores">otros factores</option>

	    					</select>
		</div>	    					
		<div class="control-group">  	
		 <label class="control-label" for="fecha_rociado"> Fecha de rociado: </label>
		 <input type="text" name="fecha_rociado" class="fecha_rociado form-control" id="canti"  />
		</div>
		<div class="control-group">  
		 <label class="control-label" for="observaciones">Observaciones:</label> 
		 <textarea name="observaciones"  cols="60" rows="15"  class="form-control" ></textarea>
		</div>
		<div class="control-group">  
		<input type="submit" value="Guardar"  class="btn btn-primary">
		</div>
	</div>
	</fieldset>
<?php echo form_close(); ?>