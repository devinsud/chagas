<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/ciclos/edita',$attributes); ?>

    <fieldset>  
          <legend>Edici&oacute;n de Barrios</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Ciclo</label>  
            <div class="controls">  
             <input type="text" name="item[ciclo]" class="form-control"  value="<?php echo $item->ciclo;?>" />
             <input type="hidden" name="item[id]" class="inp-form"  value="<?php echo $item->id; ?>" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Tipo</label>  
            <div class="controls">

             Rural: <input id="tipo" name="item[tipo]" value="rural" type="radio" <?php echo ($item->tipo=='rural')?'checked':'';?> >
             &nbsp;Urbano<input id="tipo" name="item[tipo]" value="urbano" type="radio" <?php echo ($item->tipo=='urbano')?'checked':'';?>>
            </div>  
          </div>  
          <div class="control-group">
          <label class="control-label" for="input01">Sede</label>  
            <div class="controls">
              <select id="sede" class="form-control" name="item[id_sede]">
                    <option value=""></option>
                    <?php

                    foreach ($sedes as $value) {
                        if($item->id_sede == $value->id ){
                            echo '<option value="' . $value->id . '" selected>'. $value->localidad .'</option>';
                        }else{
                            echo '<option value="' . $value->id . '">'. $value->localidad .'</option>';
                        }
                    }
                    ?>

                </select>
                </div>
          </div>
           <br >
          <div class="form-actions">  
          <input type="hidden" name="submit" value="Guardar">
            <button type="submit" class="btn btn-primary">Guardar</button>  
            <button class="btn">Cancelar</button>  
          </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>
