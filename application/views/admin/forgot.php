<!DOCTYPE html>
<html>
<head>
    <title>Admin - Olvido de contrase&ntilde;</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link  href="<?php echo base_url();?>assets/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="main">
        <div id="header">
            <a href="#" class="logo"><img src="<?php echo base_url();?>assets/img/logo-starcom-interno.png" width="110" height="60" alt="" /></a>
            <!--menu top-->
            <?php $this->load->view($menu_top); ?>
        </div>
        <div id="middle">
            <div id="left-column">
            <?php $this->load->view($menu_iz); ?>
            </div>
           <div id="center-column">
               <!--listado-->
                <!--form tipo-->
                <?php $this->load->view($form_login); ?>
            </div>
            <!--col derecha-->
            <?php //$this->load->view($col_derecha); ?>
        </div>
        <div id="footer"></div>
    </div>
</body>
</html>
