<div class="table" style="width:400px;margin:0 auto;">
    <?php 

    $attributes = array('id' => 'id-form', 'class'=>'form-horizontal');
    echo form_open_multipart(base_url().'admin/viviendas/edita_lab',$attributes); ?>

    <fieldset>  
          <legend>Edición Positivos</legend>  
          <div class="control-group">
            <label class="control-label" for="vigilancia">Lugar: </label>
            <select class="form-control" name="item[lugar]" id="lugar">
                <option value=""></option>
                <?php foreach ($lugares as $lugar) { 

                  ?>
                    <option value="<?php echo $lugar->id; ?>" <?php echo ($lugar->id == $lab[0]->donde)?'selected':'';?> ><?php echo $lugar->nombre; ?></option>    
                <?php } ?>
                
            </select>
          </div>
          <div class="control-group">  
            <label class="control-label" for="input01">Nro. Muestra</label>  
            <div class="controls">  
             <input type="text" name="item[codigo]" class="form-control" value="<?php echo $lab[0]->codigo; ?>"/>
             <input type="hidden" name="item[id]" class="form-control" value="<?php echo $lab[0]->id; ?>"/>
             <input type="hidden" name="item[idv]" class="form-control" value="<?php echo $idv; ?>"/>
             <input type="hidden" name="item[usuario]" class="form-control" value="<?php echo $usuario; ?>"/>
             
             <input type="hidden" name="submit" value="Guardar">

            </div>  
          </div>

          <div class="control-group">  
            <label class="control-label" for="input01">Etapa</label>  
            <div class="controls">  
              <select class="form-control" name="item[etapa]" id="edad">
                  <option value="huevos">huevos</option>
                  <option value="ninfas">ninfas</option>
                  <option value="adultos">adultos</option>
              </select>
            </div>  
          </div>  

          <div class="control-group">
          <label class="control-label" for="input01">Cantidad</label>  
            <div class="controls">
              <select class="form-control" name="item[cantidad]" id="edad">
                  <option value="1" <?php echo ($lab[0]->cantidad==1)?'selected':''; ?> >1 a 10</option>
                  <option value="2" <?php echo ($lab[0]->cantidad==2)?'selected':''; ?>>11 a 50</option>
                  <option value="3" <?php echo ($lab[0]->cantidad==3)?'selected':''; ?>>51 a 100</option>
                  <option value="4" <?php echo ($lab[0]->cantidad==4)?'selected':''; ?>>+ 100</option>
              </select>
                </div>
          </div>
           <div class="control-group">
          <label class="control-label" for="input01">Especie</label>  
            <div class="controls">
              <select class="form-control" name="item[informe]" id="edad">
                  <option value=""></option>
                  <option value="Triatoma infestans" <?php echo ($lab[0]->que_en_lab=="Triatoma infestans")?'selected':''; ?> >Triatoma infestans</option>
                  <option value="Triatoma guasayana" <?php echo ($lab[0]->que_en_lab=="Triatoma guasayana")?'selected':''; ?> >Triatoma guasayana</option>
                  <option value="Triatoma sordida" <?php echo ($lab[0]->que_en_lab=="Triatoma sordida")?'selected':''; ?> >Triatoma sordid</option>
                 
              </select>
            </div>
          </div>
          <br />
          <div class="control-group">
          <label class="control-label" for="input01">Infectado</label>  
            <div class="controls">
              <select  class="form-control" name="item[infectado]" id="edad">
                  <option value=""></option>
                  <option value="positivo" <?php echo ($lab[0]->insecto_infectado=="positivo")?'selected':''; ?> >Positivo</option>
                  <option value="negativo" <?php echo ($lab[0]->insecto_infectado=="negativo")?'selected':''; ?> >Negativo</option>
                  
                 
              </select>
            </div>
          </div>
          <br />
          <div class="form-actions">  
          <input type="hidden" name="submit" value="Guardar">
            <button type="submit" class="btn btn-primary">Guardar</button>  
            <button class="btn">Cancelar</button>  
          </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>


