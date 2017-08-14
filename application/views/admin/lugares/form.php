<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/lugares/crea',$attributes); ?>

    <fieldset>  
          <legend>Incorporaci&oacute;n de Lugares</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Lugar</label>  
            <div class="controls">  
             <input type="text" name="item[nombre]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Tipo</label>  
            <select id="sede" class="form-control" name="item[tipo]">

                    <option value="intradomicilio">Intradomicilio</option>
                    <option value="peridomicilio">Peridomicilio</option>


                </select>  
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



