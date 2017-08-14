<div class="table" style="width:400px;margin:20px auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/usuarios/crear',$attributes); ?>
    
    <fieldset>  
          <legend>Incorporaci&oacute;n de Usuarios</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Nombre</label>  
            <div class="controls">  
             <input type="text" name="item[nombre]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Apellido</label>  
            <div class="controls">  
             <input type="text" name="item[apellido]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Email</label>  
            <div class="controls">  
             <input type="text" name="item[email]" class="form-control" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Password</label>  
            <div class="controls">  
             <input type="text" name="item[password]" class="form-control" />
            </div>  
          </div>  
           <div class="control-group">  
            <label class="control-label" for="input01">Sede</label>  
            <div class="controls">  
             <select id="sede" class="form-control"  name="item[id_sede]" >
                    <option value=""></option>
                    <option value="0">Todas</option>

                    <?php
                    foreach ($sedes as $key => $value) {
                        echo '<option value="' . $key . '">'. $value .'</option>';
                    }
                    ?>

                </select>
            </div>  
          </div> 
           <div class="control-group">  
            <label class="control-label" for="input01">Tipo de Usuario</label>  
            <div class="controls">  
             <select name='item[type]' class="form-control" >
                    <option value="1">Usuario con capacidad de edicion</option>
                    <option value="0">Usuario sin capacidad de edicion</option>
                </select>
            </div>  
          </div> 
           <div class="control-group">  
            
             <div class="checkbox">
                <label><input type="checkbox" name="item[isadmin]" value="1"> Es administrador?</label>
            </div><br>
            <div class="checkbox">
                <label><input type="checkbox" name="item[issuper]" value="1"> Es Superusuario?</label>
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
