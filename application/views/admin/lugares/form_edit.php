<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/lugares/edita',$attributes); ?>

    <fieldset>  
          <legend>Edici&oacute;n de Lugares</legend>  
          <div class="control-group">  
            <label class="control-label" for="input01">Lugar</label>  
            <div class="controls">  
             <input type="text" name="item[nombre]" class="form-control" value="<?php echo $item->nombre; ?>" />
             <input type="hidden" name="item[id]" class="text"  value="<?php echo $item->id; ?>" />
            </div>  
          </div>  
          <div class="control-group">  
            <label class="control-label" for="input01">Tipo</label>  
            <select id="tipo" name="item[tipo]">

                    <?php
                    if ($item->tipo =='intradomicilio'){ ?>
                        <option value="intradomicilio" selected>Intradomicilio</option>
                        <option value="peridomicilio">Peridomicilio</option>
                    <?php }else{ ?>
                            <option value="intradomicilio" >Intradomicilio</option>
                            <option value="peridomicilio" selected>Peridomicilio</option>
                   <?php } ?>

                </select>
          </div>  
          
           <br >
          <div class="form-actions">  
          <input type="hidden" name="submit" value="Guardar">
            <button type="submit" class="btn btn-primary">Guardar</button>  
            <button class="btn">Cancelar</button>  
          </div>
    </fieldset>
</div>


