<div class="top-bar">

    <h1 class="titulo">Carga de inspecciones para la orden Nro. <?php echo $id_orden;
?></h1>

    <br>

</div>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table1">
    <table id='example1' class="table table-striped table-bordered table-hover" border='0' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>

                <th>Id Vivenda</th>
                <th>Vivienda Cargada</th>


                <th style="width:180px;">Herramientas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!is_null($items)) {
                if (isset($items) && count($items) > 0) {

                    if (isset($items['vivienda'])) {


                        foreach ($items['vivienda'] as $u) {
                            $id_sede = $this->vivienda->getSedeByViviendaId($u[0]->id_vivienda);
                            ?>
                        <td class="nombre_fuente"> <?php echo $u[0]->id_vivienda; ?></td>
                        <?php if ($this->vivienda->estaCargada($u[0]->id_vivienda, $id_orden)) { ?>

                            <td class="nombre_fuente"> X </td>
                            <td class="herramientas_fuentes">
                                <a class="btn btn-warning" href="<?php echo base_url(); ?>admin/viviendas/editarInspeccion/<?php echo $u[0]->id_vivienda; ?>/<?php echo $id_orden; ?>/<?php echo $items['orden']; ?>" ><i class="fa fa-edit" aria-hidden="true"></i> Editar Inspección </a>
                            <?php } else { ?>
                            <td>&nbsp;</td>
                            <td class="herramientas_fuentes">
                                <a class="btn btn-success" href="<?php echo base_url(); ?>admin/viviendas/inspeccion/<?php echo $u[0]->id_vivienda; ?>/<?php echo $id_orden; ?>/<?php echo $items['orden']; ?>" ><i class="fa fa-cloud-upload" aria-hidden="true"></i> Cargar Inspección </a>
                            </td>

                            </td>
                        <?php } ?>
                        </tr>
                    <?php
                    }
                }
            } else {
                ?>
                <tr><td>No hay viviendas cargados actualmente</td></tr>
            <?php }
        } else {
            ?>
            <tr><td>No hay viviendas cargados actualmente</td></tr>
<?php }
?>
        </tbody>
    </table>

</div>
