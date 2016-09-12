<div class="top-bar">
    
    <h1>Imagenes para: <?php echo $item->titulo;?></h1>
    <div class="breadcrumbs">
        <a href="<?php echo base_url(); ?>admin/admin">Homepage</a> / <a href="<?php echo base_url(); ?>admin/noticias/index">Noticias</a> 
    </div>
    </br></br>
    <h1>Agregar Imagen o Video</h1>
    <table>
        <?php 
    echo form_open_multipart( base_url().'admin/noticias/add_imagen/');
    ?>
    
    <tr><input type="hidden" name="id_noticia" value="<?php echo $item->id;?>"  id="files"/>
     <td>Imagen</td> <td><input type="file" name="fileField" value=""  /></td></tr>
    
    <tr><td>Video</td> <td><input type="text" name="link" value=""  /></td></<tr>
    <tr><td>Descripcion</td> <td><?php $this->ckeditor->editor("item[copete]", "",$config); ?></td></tr>
    <?php 
    echo '<tr><td colspan="2">'.form_submit('submit','Subir Imagen').'</td></tr>';
    echo form_close();
    ?>
    </table>
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
            
            <th>Video</th>
            
            
            <th>Borrar</th>
            

        </tr>

        <?php
        if (isset($items) && count($items) > 0) {
            foreach ($items as $u) {
                ?>
                <tr>
                    <td class="style1"> <img src="<?php echo base_url(); ?>assets/imagenes/<?php echo $u->path;?>" width="200" /> </td>
                    <?php if($u->link!=''){ ?>
                    <td class="style1"> <?php echo '<iframe width="280" height="158" src="http://www.youtube.com/embed/'.$u->link.'" frameborder="0" allowfullscreen></iframe>';?> </td>
                    <?php }else{ ?>
                    <td class="style1"> &nbsp; </td>
                    <?php } ?>
                    

                    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
                    
                    <td><a href="<?php echo base_url(); ?>admin/noticias/borra_imagen_rotador/<?php echo $u->id; ?>/<?php echo $item->id; ?>" class="borra_imagen_noticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /></a></td>
                    <?php } ?>
                </tr>
    <?php }
} else { ?>
            <tr><td>No hay criterios cargados actualmente</td></tr>
        <?php } ?>

    </table>
    
</div>