<div class="table" style="width:700px;margin:0 auto;">
    <?php
    $attributes = array('id' => 'id-form');
    echo form_open_multipart(base_url().'admin/viviendas/grupo',$attributes); ?>
    <h2>Inspecci&oacute;n de viviendas</h2>
    <?php $datos = $this->vivienda->explode_id($item->id_vivienda); ?>
    <div class="panel panel-primary">
       
        <div class="panel-heading">
            <h3 class="panel-title">Datos de la vivienda</h3>
          </div>
          <div class="panel-body">
                <table class="datos_vivienda" >
                    <tr>
                        <td style="width:230px;"><label class="control-label" for="id">Id de la vivienda : </label><?php echo $item->id_vivienda; ?></td>
                        <td style="width:230px;"><label class="control-label" for="barrio">Barrio : </label><?php echo $datos['nombre_barrio']; ?></td>
                        <td style="width:230px;"><label class="control-label" for="id">Tipo de vivienda : </label><?php echo $item->tipo; ?></td>
                    </tr>
                    <tr>
                        <td style="width:230px;"><label class="control-label" for="id">Latitud : </label><?php echo $item->latitud; ?></td>
                        <td style="width:230px;"><label class="control-label" for="id">Longitud : </label><?php echo $item->longitud; ?></td>
                        <td style="width:230px;"><label class="control-label" for="id">Cantidad de habitantes : </label><?php echo $item->habitantes; ?></td>
                    </tr>
                </table>
          </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Formulario de inspecci&oacute;n</h3>
        </div>
        <div class="panel-body">

            <div class="control-group">  
                    <label class="control-label" for="ciclo">Ciclo </label>  
                    <select name="item[ciclo]" class="form-control"  id="ciclo">
                        <option value=""></option>
                        <?php foreach($ciclos as $cic){ ?>
                                <option value="<?php echo $cic->id; ?>"><?php echo $cic->ciclo.' ( '.$cic->tipo.' ) '; ?></option>
                        <?php } ?>
                    </select>
                     <input type="hidden" name="item[id_vivienda]" value="<?php echo $item->id_vivienda; ?>" >
            </div>

            <div class="control-group">  
                    <label class="control-label" for="jefeflia">Fecha </label>  
                    <input type="text" class="form-control" id="fecha_inspeccion" placeholder="Fecha" name="item[fecha_inspeccion]" value=""  >
            </div>

            

            <div class="positiva">
                <div class="linea_lugar">
                    <div class="control-group" >
                        <label class="control-label" for="vigilancia">Relaci&oacute;n Familiar </label>
                            <select name="relac[]" id="lugar">
                                <option value=""></option>
                                <?php foreach ($relaciones as $relacion) { ?>
                                    <option value="<?php echo $relacion->id; ?>"><?php echo $relacion->relacion; ?></option>    
                                <?php } ?>
                                
                            </select>
                    
                    
                        <label class="control-label" for="cod">Nombre: <input type="text" class="form-control" style="width:250px;" id="nombre" placeholder="Nombre de la persona" name="nom[]" value=""  ></label>  
                        <label class="control-label" for="cod">Edad: <input type="text" class="form-control" style="width:100px;" id="edad" placeholder="Edad" name="edad[]" value=""  ></label>  
                        <label class="control-label" for="cod">Sexo: <select name="sex[]" class="form-control">
                            <option value="f">Femenino</option>
                            <option value="m">Masculino</option>
                        </select></label>  
                        
                        
                    </div>
                </div>
                
            </div>
            <button type="button" class="btn btn-lg btn-primary btn-block" id="mas" > + </button>
            
    </div>
     
    <div class="control-group">
        <input type="hidden" name="submit" value="Guardar" />
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit_grupo" value="Guardar">Guardar</button>
    </div>
    
    <?php

    echo form_close(); ?>
</div>

