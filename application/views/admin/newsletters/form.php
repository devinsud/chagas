<div class="table">
    <?php echo form_open_multipart(base_url().'admin/newsletters/crea'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Creaci&oacute;n de newsletters</th>
        </tr>
        
        <tr>
            <td width="172"><strong>T&iacute;tulo</strong></td>
            <td><input type="text" name="item[titulo]" class="text" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Asunto</strong></td>
            <td><input type="text" name="item[subject]" class="text" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Texto</strong></td>
            <td>
               <?php $this->ckeditor->editor("item[texto]", "",$config); ?>
                <!--<textarea name="item[texto]" class="text" ></textarea>--></td>
        </tr>
        
        
        
        
        
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>