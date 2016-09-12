
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/sedes/crea" class="button nuevo">Nueva Sede</a>
    <?php } ?>
    <h1 class="titulo">Administraci&oacute;n de sedes</h1>
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
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Direccion</th>
                <th>Cod. Pos.</th>
                <th>Tel</th>
                <th>Responsable</th>
                <th>Email</th>
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
                        <td class="nombre_fuente"> <?php echo $u->localidad; ?> </td>
                        <td class="url_fuente"> <?php echo $u->provincia; ?> </td>
                        <td class="url_fuente"> <?php echo $u->direccion; ?> </td>
                        <td class="url_fuente"> <?php echo $u->codpos; ?> </td>
                        <td class="url_fuente"> <?php echo $u->telefono; ?> </td>
                        <td class="url_fuente"> <?php echo $u->responsable; ?> </td>
                        <td class="url_fuente"> <?php echo $u->email; ?> </td>

                        <td class="herramientas_fuentes">
                        <a href="<?php echo base_url(); ?>admin/sedes/edita/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Editar | 
                        <a href="<?php echo base_url(); ?>admin/informes/index/<?php echo $u->id; ?>" target="_blank"><img src="<?php echo base_url(); ?>assets/img/inf.jpg" width="16" height="16" alt="" /> Informes | 

                        </td>
                    </tr>
            <?php }
            } else { ?>
            <tr><td>No hay sedes cargadas actualmente</td></tr>
        <?php }

        }else { ?>
            <tr><td>No hay sedes cargados actualmente</td></tr>
    <?php }
    ?>
    
    </tbody>
    </table>

</div>
