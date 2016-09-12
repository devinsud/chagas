<div class="table">
    <?php echo form_open(base_url().'sessions/recover_password'); ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        <tr>
            <th class="full" colspan="2">Olvid&oacute; su contrase&ntilde;a?</th>
        </tr>
        <tr>
            <td width="172"><strong>Introduzca su Email</strong></td>
            <td><input type="text" name="user[email]" class="text" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'LOGIN'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>