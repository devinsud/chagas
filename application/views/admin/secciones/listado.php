
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/secciones/crea" class="button nuevo">Nueva Seccion</a>
    <?php } ?>
    <h1>Secciones</h1>
    <div class="breadcrumbs">
        <a href="<?php echo base_url(); ?>admin/admin">Homepage</a> / <a href="<?php echo base_url(); ?>admin/secciones/index">Secciones</a> | <a href="<?php echo base_url(); ?>admin/secciones/sorting">Ordenar Secciones</a>
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
            <th>Imagenes al rotador</th>
            
            <th>Borrar</th>
            <?php } ?>

        </tr>

        <?php
        if (isset($items) && count($items) > 0) {
            foreach ($items as $u) {
                $ite = array();
                if($u->id_seccion!=0){
                    $args=array('tabla'=>'secciones','campo'=>'id','valor'=>$u->id_seccion);
                    $ite = $this->varios->getItem($args);
                }
                if(isset($ite) && count($ite)>0){
                    $dep = '-----'.$ite->titulo.' / ';
                }else{
                    $dep = '';
                }
                ?>
                <tr>
                    <td class="style1" style="width:300px;"> <?php echo $dep.$u->titulo; ?> </td>
                    
                    

                    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
                    
                    <td><a href="<?php echo base_url(); ?>admin/secciones/edita/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /></td>
                    <td><a href="<?php echo base_url(); ?>admin/secciones/rotador/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /></td>
                    <td><a href="<?php echo base_url(); ?>admin/secciones/borra/<?php echo $u->id; ?>" class="borrasec"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /></a></td>
                    <?php } ?>
                </tr>
    <?php }
} else { ?>
            <tr><td>No hay criterios cargados actualmente</td></tr>
        <?php } ?>

    </table>
    
</div>
