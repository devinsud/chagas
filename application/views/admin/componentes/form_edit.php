<div class="table">
    <?php echo form_open_multipart(base_url().'admin/sedes/edita'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Edici&oacute;n de Sede </th>
        </tr>
        



           
        
          <tr>
            <td width="172"><strong>Localidad</strong></td>
            <td><input type="text" name="item[localidad]" class="text"  value="<?php echo $item->localidad; ?>"  /></td>
        </tr>
        
        <tr>
            <td width="172"><strong>Provincia</strong></td>
            <td><input type="text" name="item[provincia]" class="text"  value="<?php echo $item->provincia; ?>" /></td>
        </tr>

        <tr>
            <td width="172"><strong>Direcci&oacute;n</strong></td>
            <td><input type="text" name="item[direccion]" class="text"  value="<?php echo $item->direccion; ?>" /></td>
        </tr>

        <tr>
            <td width="172"><strong>C&oacute;digo Postal</strong></td>
            <td><input type="text" name="item[codpos]" class="text"  value="<?php echo $item->codpos; ?>" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Tel&eacute;fono</strong></td>
            <td><input type="text" name="item[telefono]" class="text"  value="<?php echo $item->telefono; ?>" /></td>
        </tr>
        
        <tr>
            <td width="172"><strong>Responsable de la sede</strong></td>
            <td><input type="text" name="item[responsable]" class="text"  value="<?php echo $item->responsable; ?>" /></td>
        </tr>
         
        <tr>
            <td width="172"><strong>Email</strong></td>
            <td><input type="text" name="item[email]" class="text"  value="<?php echo $item->email; ?>" /></td>
        </tr>
      
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>