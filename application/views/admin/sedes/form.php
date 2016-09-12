<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/sedes/crea',$attributes); ?>

    <fieldset>  
          <legend>Incorporacion de Sedes</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Localidad</label>  
            <div class="controls">  
             <input type="text" name="item[localidad]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Provincia</label>  
            <div class="controls">  
             <input type="text" name="item[provincia]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Direcci&oacute;n</label>  
            <div class="controls">  
             <input type="text" name="item[direccion]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">C&oacute;digo Postal</label>  
            <div class="controls">  
             <input type="text" name="item[codpos]" class="form-control" />
            </div>  
          </div>  
           <div class="control-group">  
            <label class="control-label" for="input01">Tel&eacute;fono</label>  
            <div class="controls">  
             <input type="text" name="item[telefono]" class="form-control" />
            </div>  
          </div> 
           <div class="control-group">  
            <label class="control-label" for="input01">Responsable de la sede</label>  
            <div class="controls">  
             <input type="text" name="item[responsable]" class="form-control" />
            </div>  
          </div> 
           <div class="control-group">  
            <label class="control-label" for="input01">Email</label>  
            <div class="controls">  
             <input type="text" name="item[email]" class="form-control" />
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