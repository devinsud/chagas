
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/proyectos/crea" class="button nuevo">Nuevo Proyecto</a>
    <?php } ?>
    <h1>Administraci&oacute;n de proyectos</h1> 
</div>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table1">
   <table id='example1' class='display datatable' border='0' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>
                <th>Nombre del Proyecto</th>
                <th>Sede</th>
                <th>Fecha de Creacion</th>
                
                <th style="width:180px;">Herramientas</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(!is_null($items)){
            if (isset($items) && count($items) > 0 ) {
                foreach ($items as $u) {
                    ?>
                    <tr>
                        <td class="nombre_fuente"> <?php echo $u->nombre; ?> </td>
                        <?php 
                            $sede =$this->sede->getSedeId($u->id_sede);
                        ?>
                        <td class="url_fuente"> <?php echo $sede[0]->localidad;  ?> </td>
                        <td class="url_fuente"> <?php echo $u->fecha_creacion; ?> </td>
                        <td class="herramientas_fuentes">
                        <a href="<?php echo base_url(); ?>admin/proyectos/edita/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Editar 
                        <!--<a href="<?php echo base_url(); ?>admin/proyectos/borra/<?php echo $u->id; ?>" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /> </a> Borrar</td>-->
                    </tr>
            <?php }
            } else { ?>
            <tr><td>No hay proyectos cargados actualmente</td></tr>
        <?php } 

        }else { ?>
            <tr><td>No hay proyectos cargados actualmente</td></tr>
    <?php } 
    ?>
    </tbody>
    </table>
    
</div>
