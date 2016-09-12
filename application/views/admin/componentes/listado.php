
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/componentes/crea" class="button nuevo">Nuevo componente</a>
    <?php } ?>
    <h1>Administraci&oacute;n de componentes</h1> 
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
                <th>Nombre</th>
                <th>Icono</th>
                <th style="width:180px;">Herraminetas</th>
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
                        <td class="url_fuente"> <img src="<?php echo base_url().'assets/imagenes/'.$u->path; ?>" /> </td>
                        
                        <td class="herramientas_fuentes">
                        <a href="<?php echo base_url(); ?>admin/componentes/edita/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Editar </a>
                        <a href="<?php echo base_url(); ?>admin/componentes/borra/<?php echo $u->id; ?>" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /> Borrar </a> </td>
                    </tr>
            <?php }
            } else { ?>
            <tr><td>No hay componentes cargados actualmente</td></tr>
        <?php } 

        }else { ?>
            <tr><td>No hay componentes cargados actualmente</td></tr>
    <?php } 
    ?>
    </tbody>
    </table>
    
</div>
