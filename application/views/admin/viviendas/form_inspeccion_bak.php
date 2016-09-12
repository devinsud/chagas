<div class="table">
    <?php
    $attributes = array('id' => 'id-form');
    echo form_open_multipart(base_url().'admin/viviendas/inspeccion',$attributes); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">

        <tr>
            <th class="full" colspan="2">Inspeccion de Viviendas</th>
        </tr>
            

          <tr class="row1" style="border:1px solid #000;">
              <td> 
                <input name="id" value="<?php echo $item->id; ?>" type="hidden" />
                <?php 
                    $datos = $this->vivienda->explode_id($item->id_vivienda);
                ?>
                 <div class="field">
                    <div class="eti">ID Vivienda:</div><?php echo $item->id_vivienda; ?>
                    </div>
              </td>
              <td>
                <div class="field"> 
                    <div class="eti">Nombre:</div> <?php echo $datos['nombre_barrio']; ?>
                </div>
              </td>
              <td>
                <div class="field"> 
                    <div class="eti">Tipo:</div> <?php echo $item->tipo; ?>
                </div>
              </td>
            </tr>
            <tr class="row1" style="border:1px solid #000;">
                     <tr class="row1" style="border:1px solid #000;">
            
            <td>
                <div class="field">
                    <div class="eti"> Latitud:</div><?php echo $item->latitud; ?>" 
                </div>
            </td>
            <td>
                <div class="field">
                    <div class="eti"> Longitud:</div><?php echo $item->longitud; ?>
                </div>
            </td>
            <td>
                <div class="field">
                    <div class="eti"> Habitantes:</div><?php echo $item->habitantes;?>
                </div>
            </td>
        </tr>
        <tr class="row1" style="border:1px solid #000;">
            <td>
                <div class="field">
                    <div class="eti">Receptividad de vivienda</div>
                    <select name="receptividad" id="receptividad">
                        <option value=""></option>
                        <option value="receptiva">receptiva</option>
                        <option value="cerrada">cerrada</option>
                        <option value="renuente">renuente</option>
                        <option value="desarmada">desarmada</option>
                    </select>
                </div>
            </td>
            <td>
                <div class="field">
                    <div class="eti">Vigilancia Entomol&oacute;gica</div>
                    <select name="vigilancia" id="vigilancia">
                        <option value=""></option>
                        <option value="negativa">Negativa</option>
                        <option value="positiva">Positiva</option>
                    </select>
                </div>
            </td>
            <td>
                <div class="field">
                    <div class="eti">Nombre del Jefe de Flia.</div><input type="text" name="jefeflia" id="jefeflia" class="inp-form" >
                </div>
            </td>
        </tr>


       <tr class="row1" style="border:1px solid #000;">
           
            <td>
                <input type="hidden" name="submit" value="Guardar" />
                <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit_inspeccion" value="Guardar">Guardar</button>
               
           </td>
            <td>&nbsp;</td>
             <td>&nbsp;</td>
        </tr>
        <tr style="height:200px;"><td>&nbsp;</td><td>&nbsp;</td></tr>

    </table>
    <?php

    echo form_close(); ?>
</div>

