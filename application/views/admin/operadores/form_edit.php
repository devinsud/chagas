<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/operadores/editar',$attributes); ?>

    <fieldset>  
          <legend>Edici&oacute;n de Operadores</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Nombre</label>  
            <div class="controls">  
             <input type="text" name="item[nombre]" class="form-control" value="<?php echo $item->nombre; ?>"  />
             
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
            <label class="control-label" for="input01">Fecha de Ingreso</label>  
            <div class="controls">  
             <input type="text" name="item[fecha_ingreso]" id="fecha_ingreso" class="form-control" value="<?php echo $item->fecha_ingreso; ?>" />
            </div>  
          </div>   
           <div class="control-group">  
            <label class="control-label" for="input01">Sede</label>  
            <div class="controls">  
             <select id="sede" name="item[id_sede]" >
                   
                        <option value=""></option>
                        <?php
                        foreach ($sedes as $key => $value) {

                            if((int)$item->id_sede == $key){
                                echo '<option value="' . $key . '" selected>'. $value .'</option>';
                            }else{
                                echo '<option value="' . $key . '">'. $value .'</option>';
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

