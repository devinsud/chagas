<div class="table">
    <?php echo form_open_multipart(base_url().'admin/componentes/crea'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Incorporaci&oacute;n de Componentes</th>
        </tr>
       
        
          <tr>
            <td width="172"><strong>Nombre</strong></td>
            <td><input type="text" name="nombre" class="text" /></td>
        </tr>
        
        <tr>
            <td width="172"><strong>C&oacute;digo</strong></td>
            <td><input type="text" name="codigo" class="text" /></td>
        </tr>

        <tr>
            <td width="172" height="25"><strong>Icono</strong></td>
            <td height="25"><input type="file" name="fileField" class="text" style="height:25px;"/></td>
        </tr>

        
        
        
       <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>