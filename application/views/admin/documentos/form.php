<div class="table">
    <?php echo form_open_multipart(base_url().'admin/documentos/crea'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Documentaci&oacute;n</th>
        </tr>
        <tr>
            <td width="172"><strong>T&iacute;tulo</strong></td>
            <td><input type="text" name="item[titulo]" class="text" /></td>
        </tr>
        
        <tr>
            <td width="172"><strong>Archivo</strong></td>
            <td><input type="file" name="userfile"  /></td>
        </tr>
        
       
        
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>