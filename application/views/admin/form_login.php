<div class="table">
    <?php echo form_open(base_url() . 'sessions/authenticate'); ?>
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
            <td><input type="text" name="user[email]" class="login-inp"  /></td>
        </tr>
        <tr>
            <td><strong>Password</strong></td>
            <td><input type="password" name="user[password]" class="login-inp"  /></td>
        </tr>
        <tr>
            <th></th>
            <td valign="top"></td>
        </tr>
        <tr>
           <th></th>
            <td><input type="submit" class="submit-login"  /></td>
        </tr>
    </table>
    <?php echo form_close(); ?>

</div>
