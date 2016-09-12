<div class="top-bar">
    
    <h1>Rotador de imagenes para: <?php echo $item->seccion;?></h1>
    <div class="breadcrumbs">
        <a href="<?php echo base_url(); ?>admin/admin">Homepage</a> / <a href="<?php echo base_url(); ?>admin/secciones/index">Secciones</a> 
    </div>
    </br></br>
    <h1>Agregar Imagen</h1>
    <?php 
    echo form_open_multipart( base_url().'admin/secciones/add_imagen/');
    echo '<input type="hidden" name="id_sec" value="'.$item->id.'"  id="files"/>';
    echo '<input type="file" name="fileField" value=""  />';
    echo '<input type="hidden" name="tipo" value="foto"  />';
    echo '</br><textarea name="copete"></textarea></br>';
    echo form_submit('submit','Subir Imagen');
    
    echo form_close();
    ?>
</div>

<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table">
    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
           

            <th>Imagen</th>
            
            
            <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
            
            
            <th>Borrar</th>
            <?php } ?>

        </tr>

        <?php
        if (isset($items) && count($items) > 0) {
            foreach ($items as $u) {
                ?>
                <tr>
                    <td class="style1"> <img src="<?php echo base_url(); ?>assets/imagenes/<?php echo $u->path;?>" width="200" /> </td>
                    
                    

                    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
                    
                    <td><a href="<?php echo base_url(); ?>admin/secciones/borra_imagen_rotador/<?php echo $u->id; ?>/<?php echo $item->id; ?>" class="borra_imagen_rotador"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /></a></td>
                    <?php } ?>
                </tr>
    <?php }
} else { ?>
            <tr><td>No hay criterios cargados actualmente</td></tr>
        <?php } ?>

    </table>
    
</div>