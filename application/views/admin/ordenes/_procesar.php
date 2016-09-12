

<h3><b>Procesar Orden N°</b> <?php 
	$sede =$this->orden->getNombreSede($orden[0]->id_sede);
	echo $orden[0]->id. ' de '.$sede; ?>
</h3>

<h4><b>Tipo de orden: </b><?php echo $orden[0]->tipo; ?></h4>
<h5><b>Fecha de la orden: </b><?php echo $orden[0]->fecha; ?></h5>
<h4>Observaciones:</h4>
<div style="min-height: 100px;width: 1000px; border:1px solid #000; background-color:#eee;padding:10px; overflow-y:scroll;">
	<?php echo $orden[0]->observaciones; ?>
</div>
<br>
<?php if($orden[0]->tipo=='Inspección'){ 

            $attributes = array('id' => 'id-form');
            echo form_open_multipart(base_url().'admin/ordenes/observaciones_inspeccion',$attributes); ?>
            <input type="hidden" name="id_orden" value="<?php echo $orden[0]->id; ?>" />
            <input type="hidden" name="tipo" value="<?php echo $orden[0]->tipo; ?>" />
	
		<div class="table1">
			   <table id='example1' class='display datatable' border='0' cellspacing='0' cellpadding='0' style="width:1000px; margin-left:1px;" >
			        <thead>
			            <tr>
			                 <th>Id Vivienda</th>
			                 <th>Observaciones</th>
			                
			            </tr>
			        </thead>
			        <tbody>
			        		<tr>
			        		<?php 
			        		$viviendas = explode('-',$orden[0]->orden);
			        		
			        		foreach ($viviendas as $v) { 
			        			if($v!=''){
			        			?>

			        			<tr>
			        				<td><?php echo $v; ?></td>
			        				<td><textarea name="viv[]"  cols="30" rows="2"></textarea></td>
			        			</tr>
			        		<?php 
			        	}
			        		} ?>
							
			        </tbody>
			    </table>
			    <input type="submit" value="Guardar">
		</div>
	<?php form_close(); ?>	
<?php } elseif($orden[0]->tipo=='Rociado'){ 

            $attributes = array('id' => 'id-form');
            echo form_open_multipart(base_url().'admin/ordenes/observaciones_inspeccion',$attributes); ?>
            <input type="hidden" name="id_orden" value="<?php echo $orden[0]->id; ?>" />
            <input type="hidden" name="tipo" value="<?php echo $orden[0]->tipo; ?>" />
	
		<div class="table1">
			   <table id='example1' class='display datatable' border='0' cellspacing='0' cellpadding='0'  >
			        <thead>
			            <tr>
			                 <th>Id Vivienda</th>
			                 <th>Quimico</th>
			                 <th>Monodosis x 100ml</th>
			                 <th>Motivo</th>
			                 <th>Fecha de rociado</th>
			                 <th>Observaciones</th>
			                
			            </tr>
			        </thead>
			        <tbody>
			        		
			        		<?php 
			        		$viviendas = explode('-',$orden[0]->orden);
			        		$canti = 0;
			        		foreach ($viviendas as $v) { 
			        			if($v!=''){

			        			?>

			        			<tr>
			        				<td><div style="margin:3px;padding:3px;">
			        					<?php echo $v; ?></td>
			        				</div>
			        				<td>
			        					<select name="quimico[]" class="form-control" >
			        						<option value="Beta-Cipermetrina">Beta-Cipermetrina</option>
			        					</select>
			        				</td>
			        				<td><input type="text" name="cant[]" value="" class="form-control" placeholder="Cant. MD x 100ml" /> </td>
			        				<td>
			        					<select name="motivo[]" class="form-control" >
			        						<option value="vivienda infectada">vivienda infectada</option>
			        						<option value="vivienda cercana">vivienda cercana</option>
			        						<option value="otros factores">otros factores</option>

			        					</select>
			        				</td>
			        				<td> <input type="text" name="fecha_rociado[]" class="form-control fecha_rociado" id="canti<?php echo $canti;?>"  /></td>
			        				<td><textarea name="viv[]"  cols="30" rows="1" class="form-control" ></textarea></td>
			        			</tr>
			        		<?php
			        		$canti++; 
			        	}
			        		} ?>
							
			        </tbody>
			    </table>
			    <input type="submit" value="Guardar">
		</div>
	<?php form_close(); ?>	
<?php } ?>
