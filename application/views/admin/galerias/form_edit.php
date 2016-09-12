<div class="table">
    <?php echo form_open_multipart(base_url().'admin/galerias/edita');  ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Edici&oacute;n de Galer&iacute;as</th>
        </tr>
        
        <tr>
            <td width="172"><strong>Nombre de la Galer&iacute;a</strong></td>
            <td><input type="text" name="item[titulo]" class="text" value="<?php echo $item->titulo;?>" /></td>
            <td><input type="hidden" name="item[id]"  value="<?php echo $item->id;?>" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Tipo de Galería</strong></td>
            <td><?php
                $tipo['foto']='foto';
                $tipo['video']='video';
                echo form_dropdown('item[tipo]', $tipo, $item->tipo);
                ?></td>
        </tr>
        
        <tr>
            <td width="172"><strong>Texto</strong></td>
            <td>
               <?php $this->ckeditor->editor("item[texto]", $item->texto,$config); ?>
                
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>