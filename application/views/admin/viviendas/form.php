<div class="table" style="width:800px;margin:0 auto;">
    <?php 
    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/viviendas/crea',$attributes); ?>
    <fieldset>  
            <legend>Incorporaci&oacute;n de Viviendas</legend>  
            <div class="row">
                <div class="col-xs-3">
                     <div class="control-group">  
                        <label class="control-label" for="input01">N° de Barrio/Paraje:</label>  
                        <div class="controls">  
                            <input type="text" name="item[id_barrio]" id="barrio" value="<?php echo $vivienda ?>"  class="form-control" onchange="traeNombreBarrio()" />
                         <input type="hidden" name="item[id_sede]" id="id_sede"  class="form-control" value="<?php echo $sede; ?>" />
                        </div>  
                      </div> 
                </div>
                <div class="col-xs-4">
                     <div class="control-group">  
                        <label class="control-label" for="input01">Nombre Barrio/Paraje:</label>  
                        <div class="controls">  
                         <input type="text" name="item[nombre]"   class="form-control"  id="nombre_barrio" readonly />
                        </div>  
                      </div> 
                </div>
                <div class="col-xs-5">
                     <div class="control-group">  
                        <label class="control-label" for="input01">N° de Manzana/Sector:</label>  
                        <div class="controls">  
                         
                         <input type="text"  class="form-control" id="manzana" name="item[manzana]" />

                        </div>  
                      </div> 
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3">
                     <div class="control-group">  
                        <label class="control-label" for="input01">N° de Vivienda:</label>  
                        <div class="controls">  
                         <input type="text"  class="form-control" id="vivienda" name="item[vivienda]" />
                        </div>  
                      </div> 
                </div>
                <div class="col-xs-4">
                     <div class="control-group">  
                        <label class="control-label" for="input01">&nbsp;</label>
                        <div class="controls">  
                         <button type="button" id="calc_id" >Calcular id de la vivienda</button>
                        </div>  
                      </div> 
                </div>
                <div class="col-xs-5">
                     <div class="control-group">  
                        <label class="control-label" for="input01">ID Vivienda:</label>  
                        <div class="controls">  
                            <input type="text" id="idvivienda" name="item[idvivienda]"  class="form-control" readonly />
                        </div>  
                      </div> 
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3">
                     <div class="control-group">  
                        <label class="control-label" for="input01">Zona:</label>  
                        <div class="controls">  
                         
                         <select name="item[tipo]" class="form-control" >
                            <option value="rural">Rural</option>
                            <option value="urbano">Urbano</option>
                        </select>
                        </div>  
                      </div> 
                </div>
                <div class="col-xs-4">
                     <div class="control-group">  
                        <label class="control-label" for="input01">Latitud:</label>
                        <div class="controls">  
                        <input type="text"  class="form-control" id="latitud" name="item[latitud]" />
                         
                        </div>  
                      </div> 
                </div>
                <div class="col-xs-5">
                     <div class="control-group">  
                        <label class="control-label" for="input01">Longitud:</label>  
                        <div class="controls">  
                            
                            <input type="text" class="form-control" id="longitud" name="item[longitud]" />

                        </div>  
                      </div> 
                </div>
            </div>
            <br>
            <div class="row">
                
                         
                        <input type="hidden" id="habitantes" name="item[habitantes]" value='0' />
                          
                
                <div class="col-xs-4">
                     <div class="control-group">  
                        <label class="control-label" for="input01">&nbsp;</label>
                        <div class="controls">  
                        <input type="hidden" name="submit" value="Guardar">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                         
                        </div>  
                      </div> 
                </div>
                <div class="col-xs-5">
                     <div class="control-group">  
                        <label class="control-label" for="input01">&nbsp;</label>
                        <div class="controls">  
                            
                            <button class="btn">Cancelar</button>

                        </div>  
                      </div> 
                </div>
            </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>

<script>
    traeNombreBarrio();
    </script>

