<div class="table">
    <?php echo form_open_multipart(base_url().'admin/secciones/edita'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Creaci&oacute;n de Secciones</th>
        </tr>
        <tr>
            <td>
                Con rotador de imagenes? <?php echo form_checkbox('item[rotador]', '1', TRUE); ?>
                <?php //var_dump($item);die;?>
            </td>
        </tr>
        <tr>
            <td width="172"><strong>Secci&oacute;n</strong></td>
            <td>
                <input type="text" name="item[seccion]" class="text" value="<?php echo $item->seccion; ?>" />
                <input type="hidden" name="item[id]" class="text" value="<?php echo $item->id; ?>" />
            </td>
        </tr>
        <tr>
            <td width="172"><strong>T&iacute;tulo</strong></td>
            <td><input type="text" name="item[titulo]" class="text" value="<?php echo $item->titulo; ?>" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Subtitulo</strong></td>
            <td><input type="text" name="item[subtitulo]" class="text" value="<?php echo $item->subtitulo; ?>" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Texto</strong></td>
            <td>
               <?php $this->ckeditor->editor("item[texto]", $item->texto,$config); ?>
                <!--<textarea name="item[texto]" class="text" ></textarea>--></td>
        </tr>
        <tr>
            <td width="172"><strong>Tipo</strong></td>
            <td><?php
                $tipo['comun']='comun';
                $tipo['galeria']='galeria';
                $tipo['listado']='listado';
                $tipo['contacto']='contacto';
                $tipo['mapa']='mapa';
                
                echo form_dropdown('item[tipo]', $tipo, $item->tipo);
                ?></td>
        </tr>
        <tr>
            <td width="172"><strong>Secci&oacute;n</strong></td>
            <td><?php
                $seccion[0]='sin seccion';
                if(is_array($secciones)){
                    foreach($secciones as $sec){
                        $seccion[$sec->id] = $sec->titulo;
                    }
                }
                
                echo form_dropdown('item[depende]', $seccion, $item->id_seccion);
                ?></td>
        </tr>
        
        <tr>
            <td>Galerias</td>
            <td><?php
                
                echo form_multiselect('item[galerias][]', $galerias, $gals);
            ?></td>
        </tr>
        
        
        
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>