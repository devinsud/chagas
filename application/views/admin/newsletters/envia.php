<div class="table">
    <?php echo form_open_multipart(base_url().'admin/newsletters/enviar'); ?>
    <table style="background-color: #fff;">
                    <tr>
                        <td style="text-align:center;"><image src="http://localhost/comarcas/assets/imagenes/logocomarcas.jpg" /></td>
                    </tr>
                    <tr>
                        <td>
                            <?php

                            if($item->texto){
                                echo $item->texto; 
                            }
                            ?>
                        </td>
                    </tr>
                    
                </table>
    <table class="listing form" cellpadding="0" cellspacing="0" style="background-color: #fff;">
        
        <tr>
            <th class="full" colspan="2">Envio de newsletters</th>
        </tr>
        
        
        
        
        
        <tr>
            <td width="172"><strong>T&iacute;tulo</strong></td>
            <td>
                <input type="text" name="item[titulo]" class="text" value="<?php echo $item->titulo;?>" />
                <input type="hidden" name="item[id]" class="text" value="<?php echo $item->id;?>" />
            </td>
        </tr>
        <tr>
            <td width="172"><strong>Asunto</strong></td>
            <td>
               
                <input type="text" name="item[subject]" class="text" value="<?php echo $item->subject;?>"/></td>
        </tr>
        
        <tr>
            <td width="172"><strong>A quien se lo enviamos</strong></td>
            <td>
                <?php
                $barrios[0]='todos';
               
                echo form_dropdown('item[barrios]', $barrios, 0);
                ?>
            </td>   
                
        </tr>
        
        
        
        
        
        
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Enviar'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>