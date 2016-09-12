<div class="table">
    <?php echo form_open_multipart(base_url().'admin/galerias/crea'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Creaci&oacute;n de Galerias</th>
        </tr>
        
        <tr>
            <td width="172"><strong>Nombre de la Galería</strong></td>
            <td><input type="text" name="item[titulo]" class="text" /></td>
        </tr>
        
        <tr>
            <td width="172"><strong>Tipo de Galería</strong></td>
            <td><?php
                $tipo['foto']='foto';
                $tipo['video']='video';
                echo form_dropdown('item[tipo]', $tipo, '');
                ?></td>
        </tr>
        
        <tr>
            <td width="172"><strong>Texto</strong></td>
            <td>
               <?php $this->ckeditor->editor("item[texto]", "Valor inicial.",$config); ?>
                
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>