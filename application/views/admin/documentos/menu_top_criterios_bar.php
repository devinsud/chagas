 
<ul id="top-navigation">
        <li><a href="#">Home</a></li>
        <li><a href="<?php echo base_url(); ?>admin/admin/cia">Compa&ntilde;&iacute;as</a></li>
        <?php 
        $tipo_usuario = $this->session->userdata('type');
        if($tipo_usuario==1 || $tipo_usuario==10){ ?>
        
            <li><a href="<?php echo base_url(); ?>admin/admin/users" >Usuarios</a></li>
            <li><a href="<?php echo base_url(); ?>admin/criterios/driving" >Criterios Driving</a></li>
            <li><a href="<?php echo base_url(); ?>admin/criterios/bar" class="active" >Criterios Bar</a></li>
            <?php if($tipo_usuario==10){ ?>
                <li><a href="<?php echo base_url(); ?>admin/compraventa_driving" >Movimientos Driving</a></li>
                <li><a href="<?php echo base_url(); ?>admin/compraventa_bar">Movimientos Bar</a></li>
         <?php   }
         } ?>
        
        <li><a href="<?php echo base_url() ?>sessions/logout">Logout</a></li>
        
</ul>
