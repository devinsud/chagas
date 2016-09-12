<div class="table">
    <?php echo form_open(base_url() . 'sessions/authenticate_user'); ?>
    <?php
    if ($this->session->flashdata('message')) {
        echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
    }
    ?>
    <table class="listing form" cellpadding="0" cellspacing="0">
        <tr>
            <th class="full" colspan="2">Login</th>
        </tr>
        <tr>
            <td width="172"><strong>Email</strong></td>
            <td><input type="text" name="user[email]" class="text" /></td>
        </tr>
        <tr>
            <td><strong>Password</strong></td>
            <td><input type="password" name="user[password]" class="text" /></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><?php echo form_submit('submit', 'LOGIN'); ?><!--<a href="#" class="orange">LOGIN</a>--></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
   
</div>