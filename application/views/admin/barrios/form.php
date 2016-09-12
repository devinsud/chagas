<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/barrios/crea',$attributes); ?>

    <fieldset>  
          <legend>Incorporaci&oacute;n de Barrios/parajes</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">C&oacute;digo</label>  
            <div class="controls">  
             <input type="text" name="item[codigo]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Nombre del Barrio</label>  
            <div class="controls">  
             <input type="text" name="item[nombre]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">
          <label class="control-label" for="input01">Sede</label>  
            <div class="controls">
              <select id="sede" name="item[id_sede]">
                    <option value=""></option>
                    <?php

                    foreach ($sedes as $value) {
                        echo '<option value="' . $value->id . '">'. $value->localidad .'</option>';
                    }
                    ?>

                </select>
                </div>
          </div>
           
          <br />
          <div class="form-actions">  
          <input type="hidden" name="submit" value="Guardar">
            <button type="submit" class="btn btn-primary">Guardar</button>  
            <button class="btn">Cancelar</button>  
          </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>