<div class="table">
    <?php echo form_open_multipart(base_url().'admin/formularios/crea'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Incorporacion de Sedes</th>
        </tr>
       
        
          <tr>
            <td width="172"><strong>Sede</strong></td>
            <td>
                <select id="sede" name="item[id_sede]" onchange="llenaDrop()">
                    <option value=""></option>
                    <?php 
                    foreach ($sedes as $key => $value) {
                        echo '<option value="' . $key . '">'. $value .'</option>';
                    }
                    ?>
                    
                </select>    
            </td>
        </tr>
        
        <tr>
            <td width="172"><strong>Proyecto</strong></td>
            <td>
                <select id="proyecto" name="item[id_proyecto]">
                    <option value=""></option>
                    
                    
                </select>
            </td>
        </tr>
         
        <tr>
            <td width="172"><strong>Nombre del Formulario</strong></td>
            <td><input type="text" name="item[nombre]" class="text"  /></td>
        </tr>
        <tr>
            <td width="172"><strong>HTML del Formulario</strong></td>
            <td><textarea name="item[formulario]"> </textarea></td>
        </tr>
        <tr>
             <td width="172"><strong>Status</strong></td>
            <td>
                <select name="item[status]">
                    <option value="activo" selected> activo</option>
                    <option value="inactivo" > inactivo</option>
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