
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/sedes/crea" class="btn btn-success">Nueva Sede</a>
    <?php } ?>
    <h1 class="titulo">Administraci&oacute;n de sedes</h1>
</div>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table1">
   <table id='example1' class="table table-striped table-bordered"  border='0' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Dirección</th>
                <th>Cod. Pos.</th>
                <th>Tel</th>
                <th>Responsable</th>
                <th>Email</th>
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
                        <td class="nombre_fuente"> <?php echo $u->localidad; ?> </td>
                        <td class="url_fuente"> <?php echo $u->provincia; ?> </td>
                        <td class="url_fuente"> <?php echo $u->direccion; ?> </td>
                        <td class="url_fuente"> <?php echo $u->codpos; ?> </td>
                        <td class="url_fuente"> <?php echo $u->telefono; ?> </td>
                        <td class="url_fuente"> <?php echo $u->responsable; ?> </td>
                        <td class="url_fuente"> <?php echo $u->email; ?> </td>

                        <td class="herramientas_fuentes">
                            <a href="<?php echo base_url(); ?>admin/sedes/edita/<?php echo $u->id; ?>" class="btn btn-info btn-xs" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar </a>
                            <a href="<?php echo base_url(); ?>admin/informes/info_int/<?php echo $u->id; ?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-bar-chart" aria-hidden="true"></i> Informes</a>

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
