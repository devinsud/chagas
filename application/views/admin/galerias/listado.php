
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/galerias/crea" class="button nuevo">Nueva Galeria</a>
    <?php } ?>
    <h1>Galerias</h1>
    <div class="breadcrumbs">
        <a href="<?php echo base_url(); ?>admin/admin">Homepage</a> / <a href="<?php echo base_url(); ?>admin/galerias/index">Galerias</a> 
    </div>
</div>

<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table">
    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
           

            <th>T&iacute;tulo</th>
            
            
            <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
            <th>Editar</th>
            <th>Imagenes y videos </th>
            <th>Tipo </th>
            
            <th>Borrar</th>
            <?php } ?>

        </tr>

        <?php
        if (isset($items) && count($items) > 0) {
            foreach ($items as $u) {
                ?>
                <tr>
                    <td class="style1"> <?php echo $u->titulo; ?> </td>
                    
                    

                    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
                    
                    <td><a href="<?php echo base_url(); ?>admin/galerias/edita/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /></td>
                    <td><a href="<?php echo base_url(); ?>admin/galerias/imagenes/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /></td>
                    <td><?php echo $u->tipo; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/galerias/borra/<?php echo $u->id; ?>" class="borrasec"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /></a></td>
                    <?php } ?>
                </tr>
    <?php }
} else { ?>
            <tr><td>No hay criterios cargados actualmente</td></tr>
        <?php } ?>

    </table>
    
</div>
