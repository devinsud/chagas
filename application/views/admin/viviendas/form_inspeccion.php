<div class="table" style="width:700px;margin:0 auto;">
<?php
$attributes = array('id' => 'id-form');
echo form_open_multipart(base_url().'admin/viviendas/inspeccion', $attributes);?>
<h2>Inspecci&oacute;n de viviendas</h2>

<?php
//dump($item);
$datos = $this->vivienda->explode_id($item->id_vivienda);?>

    <input type="hidden" name="item[ciclo]" value="<?php echo $ciclo_orden?>">
    <input type="hidden" name="item[orden]" value="<?php echo $orden?>">

    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title">Datos de la vivienda</h3>
          </div>
          <div class="panel-body">
                <table class="datos_vivienda">
                    <tr>
                        <td style="width:230px;"><label class="control-label" for="id">Id de la vivienda : </label><?php echo $item->id_vivienda;
?></td>
                        <td style="width:230px;"><label class="control-label" for="barrio">Barrio : </label><?php echo $datos['nombre_barrio'];
?></td>
                        <td style="width:230px;"><label class="control-label" for="id">Tipo de vivienda : </label><?php echo $item->tipo;
?></td>
                    </tr>
                    <tr>
                        <td style="width:230px;"><label class="control-label" for="id">Latitud : </label><?php echo $item->latitud;
?></td>
                        <td style="width:230px;"><label class="control-label" for="id">Longitud : </label><?php echo $item->longitud;
?></td>
                        <td style="width:230px;"><label class="control-label" for="id">Cantidad de habitantes : </label><?php echo $item->habitantes;
?></td>
                    </tr>
                </table>
          </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Formulario de inspecci&oacute;n</h3>
        </div>
        <div class="panel-body">

            <div class="control-group">
                    <label class="control-label" for="jefe">Jefe de Familia </label>
                    <input type="text" name="item[jefe]" class="form-control" id="jefe">

                    <label class="control-label" for="ciclo">Cantidad de Habitantes </label>
                    <input type="text" name="item[habitantes]" class="form-control" id="jefe">

                    <label class="control-label" for="ciclo">Ciclo </label>
                    <select name="item[ciclo]" class="form-control"  id="ciclo">
                    <option value=""></option>
<?php foreach ($ciclos as $cic) {?>
									                                <option value="<?php echo $cic->id;?>"><?php echo $cic->ciclo.' ( '.$cic->tipo.' ) ';
	?></option>
	<?php }?>
</select>
                    <label class="control-label" for="operador">Operador </label>
                    <select name="item[operador][]" class="form-control" multiple>
<?php foreach ($operadores as $ope) {
	if ($ope->nombre != '') {
		?>
																		                                <option value="<?php echo $ope->id;?>"><?php echo $ope->nombre.', '.$ope->apellido;
		?></option>
		<?php }
}?>
                    </select>
                     <input type="hidden" name="item[id_vivienda]" value="<?php echo $item->id_vivienda;?>" >
                     <input type="hidden" name="item[usuario]" value="<?php echo $usuario;?>" >
            </div>

            <div class="control-group">
                    <label class="control-label" for="jefeflia">Fecha </label>
                    <input type="text" class="form-control" id="fecha_inspeccion" placeholder="Fecha" name="item[fecha_inspeccion]" value=""  >
            </div>

            <div class="control-group">
                    <label class="control-label" for="receptividad">Receptividad de vivienda </label>
                    <select class="form-control" name="item[receptividad]" id="receptividad">
                        <option value=""></option>
                        <option value="receptiva">inspeccionada</option>
                        <option value="cerrada">cerrada</option>
                        <option value="renuente">renuente</option>
                        <option value="deshabitada">deshabitada</option>
                         <option value="desarmada">desarmada</option>
                    </select>
            </div>

            <div id="receptiva" style="display:none;">


                <div class="control-group">
                    <label class="control-label" for="vigilancia">Vigilancia Entomol&oacute;gica</label>
                        <select  class="form-control"  name="item[vigilancia]" id="vigilancia">
                            <option value=""></option>
                            <option value="negativa">Negativa</option>
                            <option value="positiva">Positiva</option>
                        </select>
                </div>
            </div>

            <div class="positiva"  style="display:none;">
                <div class="linea_lugar">
                    <div class="control-group" >
                        <label class="control-label" for="vigilancia">Lugar: </label>
                            <select name="etim[]" id="lugar">
                                <option value=""></option>
<?php foreach ($lugares as $lugar) {?>
									                                    <option value="<?php echo $lugar->id;?>"><?php echo $lugar->nombre;
	?></option>
	<?php }?>
</select>
                             <label class="control-label" for="vigilancia">Etapa: </label>

                            <select name="etapa[]" id="edad">
                                <option value="huevos">huevos</option>
                                <option value="ninfas">ninfas</option>
                                <option value="adultos">adultos</option>
                            </select>

                            <label class="control-label" for="vigilancia">Cantidad: </label>

                            <select name="cantidad[]" id="edad">
                                <option value="1">1 a 10</option>
                                <option value="2">11 a 50</option>
                                <option value="3">51 a 100</option>
                                <option value="4">+ 100</option>
                            </select>

                        <label class="control-label" for="cod">Codigo muestra: <input type="text" class="form-control" style="width:250px;" id="cod" placeholder="Codigo muestra" name="cod[]" value=""  ></label>

                    </div>
                </div>

            </div>
            <button type="button" class="btn btn-lg btn-primary btn-block" id="mas" style="display:none;"> + </button>

    </div>
    <label  class="control-label" >Observaciones:</label>
     <textarea  class="form-control"  name="item[observaciones]"></textarea>
    <div class="control-group">
        <input type="hidden" name="submit" value="Guardar" />
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit_inspeccion" value="Guardar">Guardar</button>
    </div>

<?php

echo form_close();?>
</div>

