<div class="table">
    <?php echo form_open_multipart(base_url().'admin/sitios/crea'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Incorporacion de sitios</th>
        </tr>
       
        
          <tr>
            <td width="172"><strong>Nombre del sitio</strong></td>
            <td><input type="text" name="item[nombre]" class="text" /></td>
        </tr>
        <tr>
            <td width="172"><strong>URL del sitio</strong></td>
            <td><input type="text" name="item[url]" class="text" /></td>
        </tr>
        
      
        
        <tr>
            <td width="172"><strong>Ip del Sitio</strong></td>
            <td><input type="text" name="item[ip]" class="text" /></td>
        </tr>
         
        <tr>
            <td width="172"><strong>Proveedor de noticias</strong></td>
            <td><input type="text" name="item[proveedor]" class="text" /></td>
        </tr> 

        <tr>
            <td width="172"><strong>Codigo del proveedor</strong></td>
            <td><input type="text" name="item[codigo_proveedor]" class="text" /></td>
        </tr> 
        <tr>
            <td width="172"><strong>url del Servicio</strong></td>
            <td><input type="text" name="item[url_servicio]" class="text" /></td>
        </tr> 
        <tr>
            <td><strong>Sitios que consume:</strong></td>
            <td>
                <?php 
                    foreach($canales as $can){  
                            echo '<input type="checkbox" name="canales[]" value="'.$can->id.'"  />'.$can->nombre.' | ';
                    }
                ?>
            </td>
        </tr>
       <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>