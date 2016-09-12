<div class="table">
    <?php echo form_open_multipart(base_url().'admin/noticias/edita'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        
        <tr>
            <th class="full" colspan="2">Edici&oacute;n de Noticias</th>
        </tr>
        <tr>
            <td width="172"><strong>Fecha</strong></td>
            <?php 
                $fec =  explode('-',$item->fecha1);
                $f1 = $fec[2].'/'.$fec[1].'/'.$fec[0];
            ?>
            <td><input type="text" name="item[fecha1]" id="fecha_nota" class="text" value="<?php echo $f1; ?>"  /></td>
        </tr>
        <tr>
            <td width="172"><strong>T&iacute;tulo</strong></td>
            <td>
                <input type="text" name="item[titulo]" class="text" value="<?php echo $item->titulo; ?>" />
                <input type="hidden" name="item[id]" class="text" value="<?php echo $item->id; ?>" />
            </td>
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