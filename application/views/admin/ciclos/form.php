<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/ciclos/crea',$attributes); ?>

    <fieldset>  
          <legend>Incorporaci&oacute;n de Ciclos</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Ciclo</label>  
            <div class="controls">  
             <input type="text" name="item[ciclo]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Tipo</label>  
            <div class="controls">  
             Rural: <input id="tipo" name="item[tipo]" value="rural" type="radio" checked>
             &nbsp;Urbano<input id="tipo" name="item[tipo]" value="urbano" type="radio">

            </div>  
          </div>  
          <div class="control-group">
          <label class="control-label" for="input01">Sede</label>  
            <div class="controls">
              <select id="sede" class="form-control" name="item[id_sede]">
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