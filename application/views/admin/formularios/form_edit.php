<div class="table">
    <?php echo form_open_multipart(base_url().'admin/formularios/edita'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Edici&oacute;n de formularios </th>
        </tr>
        



           
        
          <tr>
            <td width="172"><strong>Sede</strong></td>
            <td>
                <select id="sede" name="item[id_sede]" onchange="llenaDrop()">
                    <option value=""></option>
                    <?php 
                    foreach ($sedes as $key => $value) {
                        if($key==$item->id_sede){
                            echo '<option value="' . $key . '" selected>'. $value .'</option>';
                         }else{
                            echo '<option value="' . $key . '">'. $value .'</option>';
                         }
                    }
                    ?>
                    
                </select>    
                <input type="hidden" name="item[id]" value="<?php echo $item->id;?>" />
            </td>
        </tr>
        
         <tr>
            <td width="172"><strong>Proyecto</strong></td>
            <td>
                <select id="proyecto" name="item[id_proyecto]">
                    <option value=""></option>
                    <?php 
                    foreach ($proyectos as $key1 => $value1) {
                        if($key1==$item->id_proyecto){
                            echo '<option value="' . $key1 . '" selected>'. $value1 .'</option>';
                        }else{
                            echo '<option value="' . $key1 . '">'. $value1 .'</option>';
                        }
                    }
                    ?>
                    
                </select>    
            </td>
        </tr>
         
        <tr>
            <td width="172"><strong>Nombre del Formulario</strong></td>
            <td><input type="text" name="item[nombre]" class="text" value="<?php echo $item->nombre;?>"  /></td>
        </tr>
        <tr>
            <td width="172"><strong>HTML del Formulario</strong></td>
            <td><textarea name="item[formulario]"><?php echo $item->formulario;?></textarea></td>
        </tr>
        <tr>
             <td width="172"><strong>Status</strong></td>
            <td>
                <select name="item[status]">
                    <?php if($item->status =='activo'){ ?>
                        <option value="activo" selected> activo</option>
                        <option value="inactivo" > inactivo</option>
                    <?php }else{ ?>
                        <option value="activo"> activo</option>
                        <option value="inactivo"  selected> inactivo</option>
                    <?php } ?>
                </select>
            </td>
        </tr>
         
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>