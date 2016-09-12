<div class="table">
    <?php
    $attributes = array('id' => 'id-form');
    echo form_open_multipart(base_url().'admin/administradores/crear',$attributes); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        <tr>
            <th class="full" colspan="2">Registro de Administradores</th>
            <input type="hidden" name="user[admin]" value="<?php echo $this->session->userdata('nombre').' '.$this->session->userdata('apellido');?>"/>
        </tr>



        <tr>
            <td width="172"><strong>Nombre</strong></td>
            <td><input type="text" name="user[nombre]" class="inp-form" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Apellido</strong></td>
            <td><input type="text" name="user[apellido]" class="inp-form" /></td>
        </tr>
        <tr>
            <td width="172"><strong>Email</strong></td>
            <td><input type="text" name="user[email]" class="inp-form" /></td>
        </tr>


        <tr>
            <td width="172"><strong>Password</strong></td>
            <td><input type="password" name="user[password]" class="inp-form" /></td>
        </tr>




        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'Guardar'); ?></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>
