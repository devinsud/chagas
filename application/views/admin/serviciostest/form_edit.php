<div class="table">
    <?php echo form_open_multipart(base_url().'admin/sitios/edita'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Edici&oacute;n de Sitios</th>
        </tr>
        



           
        
          <tr>
            <td width="172"><strong>Nombre del sitio</strong></td>
            <td><input type="text" name="item[nombre]" class="text" value="<?php echo $item->nombre; ?>"  />

<input type="hidden" name="item[id]" class="text" value="<?php echo $item->id; ?>" />
            </td>

        </tr>
        <tr>
            <td width="172"><strong>URL del sitio</strong></td>
            <td><input type="text" name="item[url]" class="text" value="<?php echo $item->url; ?>"  /></td>
        </tr>
        
      
        
         <tr>
            <td width="172"><strong>Ip del Sitio</strong></td>
            <td><input type="text" name="item[ip]" class="text" value="<?php echo $item->ip; ?>" /></td>
        </tr>
         <tr>
            <td width="172"><strong>Proveedor de noticias</strong></td>
            <td><input type="text" name="item[proveedor]" class="text" value="<?php echo $item->proveedor; ?>"  /></td>
        </tr> 

        <tr>
            <td width="172"><strong>Codigo del proveedor</strong></td>
            <td><input type="text" name="item[codigo_proveedor]" class="text" value="<?php echo $item->codigo_proveedor; ?>"  /></td>
        </tr> 
        <tr>
            <td><strong>Sitios que consume:</strong></td>
            <td>
                <?php 
                    $canales1 = explode('q', str_replace ('qq','q',$item->canales));

                    foreach($canales as $can){
                        if(in_array($can->id, $canales1)){
                            echo '<input type="checkbox" name="canales[]" value="'.$can->id.'" checked />'.$can->nombre.' | ';
                        }else{
                            echo '<input type="checkbox" name="canales[]" value="'.$can->id.'"  />'.$can->nombre.' | ';
                        }
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