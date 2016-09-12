<div class="table">
    <?php echo form_open_multipart(base_url().'admin/proyectos/edita'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Edici&oacute;n de Proyecto </th>
        </tr>
        



       <tr>
            <td width="172"><strong>Sede</strong></td>
            <td><?php echo form_dropdown('item[id_sede]', $sedes, $item->id_sede); ?>
                <input type="hidden" name="item[id_proyecto]" value="<?php echo $item->id; ?>">
            </td>
        </tr>

        <tr>
            <td width="172"><strong>Nombre del proyecto</strong></td>
            <td><input type="text" name="item[nombre]" class="text" value="<?php echo $item->nombre; ?>" /></td>
        </tr>
        
        <tr>
            <td width="172"><strong>Descripcion</strong></td>
            <td><textarea  name="item[descripcion]" cols="50"  ><?php echo $item->descripcion; ?></textarea></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>