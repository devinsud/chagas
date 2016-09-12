<div class="table">
    <?php echo form_open_multipart(base_url().'admin/newsletters/edita'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Edici&oacute;n de newsletters</th>
        </tr>
        <tr>
            <td width="172"><strong>T&iacute;tulo</strong></td>
            <td>
                <input type="text" name="item[titulo]" class="text" value="<?php echo $item->titulo; ?>" />
                <input type="hidden" name="item[id]" class="text" value="<?php echo $item->id; ?>" />
            </td>
        </tr>
        <tr>
            <td width="172"><strong>Asunto</strong></td>
            <td><input type="text" name="item[subject]" class="text" value="<?php echo $item->subject; ?>" /></td>
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