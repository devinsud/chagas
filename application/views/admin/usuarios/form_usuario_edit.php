<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/usuarios/editar',$attributes); ?>

    <fieldset>  
          <legend>Edici&oacute;n de Usuarios</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Nombre</label>  
            <div class="controls">  
             <input type="text" name="item[nombre]" class="form-control" value="<?php echo $item->nombre; ?>"  />
             <input type="hidden" name="item[admin]" value="<?php echo $this->session->userdata('nombre').' '.$this->session->userdata('apellido');?>"/>
             <input type="hidden" name="item[id]"  value="<?php echo $item->id; ?>"  />

            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Apellido</label>  
            <div class="controls">  
             <input type="text" name="item[apellido]" class="form-control" value="<?php echo $item->apellido; ?>" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Email</label>  
            <div class="controls">  
             <input type="text" name="item[email]" class="form-control" value="<?php echo $item->email; ?>"  />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Password</label>  
            <div class="controls">  
                <input type="password" name="item[password]" class="form-control"  value="<?php echo $item->pass; ?>"  />
            </div>  
          </div>  
           <div class="control-group">  
            <label class="control-label" for="input01">Sede</label>  
            <div class="controls">  
             <select id="sede" name="item[id_sede]" >
                   
                        <option value=""></option>
                        <?php
                        foreach ($sedes as $key => $value) {

                            if((int)$item->sede == $key){
                                echo '<option value="' . $key . '" selected>'. $value .'</option>';
                            }else{
                                echo '<option value="' . $key . '">'. $value .'</option>';
                            }
                        }
                        ?>

                    </select>

                
            </div>  
          </div> 
           <div class="control-group">  
            <label class="control-label" for="input01">Tipo de Usuario</label>  
            <div class="controls">  
             <select name='item[type]'>
            <?php

                    if($item->type == 1){ ?>
                        <option value="1" selected>Usuario con capacidad de edicion</option>
                        <option value="0">Usuario sin capacidad de edicion</option>
                    <?php }else{ ?>
                        <option value="1">Usuario con capacidad de edicion</option>
                        <option value="0" selected>Usuario sin capacidad de edicion</option>
                    <?php } ?>
              </select>
            </div>  
          </div> 
           <div class="control-group">  
            
             <div class="checkbox">
                <label><input type="checkbox" name="item[isadmin]" value="1" <?php echo ($item->isadmin==1)?'checked':''; ?> > Es administrador?</label>
            </div><br><div class="checkbox">
                <label><input type="checkbox" name="item[issuper]" value="1" <?php echo ($item->issuper==1)?'checked':''; ?> > Es Superusuario?</label>
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

