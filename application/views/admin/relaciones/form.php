<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/relaciones/crea',$attributes); ?>

    <fieldset>  
          <legend>Incorporaci&oacute;n de Relaciones Familiares</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Relaci&oacute;n familiar</label>  
            <div class="controls">  
             <input type="text" name="item[relacion]" class="form-control" />
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

