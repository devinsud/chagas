<div class="table">
    <?php echo form_open_multipart(base_url().'admin/secciones/crea'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Creaci&oacute;n de Secciones</th>
        </tr>
        <tr>
            <td>
                Con rotador de imagenes? <?php echo form_checkbox('item[rotador]', '1', TRUE); ?>
            </td>
        </tr>
        <tr>
            <td width="172"><strong>Secci&oacute;n</strong></td>
            <td><input type="text" name="item[seccion]" class="text" /></td>
        </tr>
        <tr>
            <td width="172"><strong>T&iacute;tulo</strong></td>
            <td><input type="text" name="item[titulo]" class="text" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Subtitulo</strong></td>
            <td><input type="text" name="item[subtitulo]" class="text" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Texto</strong></td>
            <td>
               <?php $this->ckeditor->editor("item[texto]", "Valor inicial.",$config); ?>
                <!--<textarea name="item[texto]" class="text" ></textarea>--></td>
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
                
                echo form_dropdown('item[depende]', $seccion, '');
                ?></td>
        </tr>
        <tr>
            <td width="172"><strong>Tipo</strong></td>
            <td><?php
                $tipo['comun']='comun';
                $tipo['galeria']='galeria';
                $tipo['listado']='listado';
                $tipo['contacto']='contacto';
                $tipo['mapa']='mapa';
                
                
                
                echo form_dropdown('item[tipo]', $tipo, '');
                ?></td>
        </tr>
        <tr>
            <td>Galerias</td>
            <td><?php
                
                echo form_multiselect('item[galerias][]', $galerias, '');
            ?></td>
        </tr>
        
        
        
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>