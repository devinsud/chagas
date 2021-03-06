<div class="top-bar">
    <?php
    //if($admin==1 ){
    foreach ($sedes as $sede1) {
        ?>
        <a  href="<?php echo base_url(); ?>admin/viviendas/listas/<?php echo $sede1->id; ?>" class="btn btn-success">Crear Listas para la sede <?php echo $sede1->localidad;
        ?></a>
        <?php
    }
//} 
    ?>
    <h1 class="titulo">Administraci&oacute;n de ordenes de trabajo</h1>
    <strong>Sedes: </strong>
    <?php
    foreach ($sedes as $se) {
        if ($sede == $se->id) {
            ?>
            <a href="<?php echo base_url(); ?>admin/ordenes/index/<?php echo $se->id; ?>" style="font-weight:bold;"><?php echo $se->localidad;
            ?></a> |
        <?php } else { ?>
            <a href="<?php echo base_url(); ?>admin/ordenes/index/<?php echo $se->id; ?>" ><?php echo $se->localidad;
            ?></a> |
            <?php
        }
    }
    ?>
    <br>
    <br>
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
                <th>Sede</th>
                <th>Ciclo</th>

                <th>id Orden</th>
                <th>Operador</th>
                <th>Fecha</th>
                <th>Tipo de Orden</th>
                <th>Observaciones</th>
                <th>Aprobada</th>





                <th style="width:180px;">Herramientas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!is_null($items)) {
                if (isset($items) && count($items) > 0) {
                    foreach ($items as $u) {
                        ?>
                        <tr>
                            <td> <?php echo $this->orden->getNombreSede($u->id_sede); ?></td>
                            <td> <?php echo $this->orden->getNombreCiclo($u->ciclo); ?></td>

                            <td class="nombre_fuente"> <?php echo $u->id; ?> </td>
                            <td><?php
                                $opr = explode('-', $u->operador);
                                $ope = '';
                                foreach ($opr as $op) {
                                    if ($op != '') {
                                        $ope = $this->operador->getOperador($op);
                                        if (isset($ope->apellido)) {
                                            echo $ope->apellido . ', ' . $ope->nombre . ' - ';
                                        } else {
                                            echo "no seleccionado";
                                        }
                                    }
                                }
                                ?></td>
                            <td class="nombre_fuente"> <?php
                                $ff = explode('-', $u->fecha_orden);
                                $fecha = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

                                echo $fecha;
                                ?> </td>
                            <td class="nombre_fuente"> <?php echo $u->tipo; ?> </td>
                            <td class="nombre_fuente"> <?php echo substr($u->observaciones, 0, 50); ?></td>

                            <td>
                                <?php
                                $aprobada = ($u->aprobada == 1) ? 'ok.png' : 'esperando.png';
                                ?>
                                <img src="<?php echo base_url(); ?>assets/img/<?php echo $aprobada; ?>" width="16" height="16">
                            </td>

                            <td class="herramientas_fuentes">


                                <a class="btn btn-sm btn-default" href="<?php echo base_url(); ?>admin/ordenes/ver2/<?php echo $u->id; ?>" ><i class="fa fa-bullseye" aria-hidden="true"></i>  </a> 
                                <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>admin/ordenes/ver/<?php echo $u->id; ?>" ><i class="fa fa-eye" aria-hidden="true"></i> </a> 
                                <?php if ($u->tipo == 'Inspección') { ?>
                                <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>admin/ordenes/carga_inspeccion/<?php echo $u->id; ?>" ><i class="fa fa-cloud-upload" aria-hidden="true"></i>  </a> 
                                <?php } else { ?>
                                    |<a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>admin/ordenes/procesar/<?php echo $u->id; ?>" ><i class="fa fa-cog" aria-hidden="true"></i>  </a> 
            <?php } ?>
                                <a class="btn btn-sm btn-default" href="<?php echo base_url(); ?>admin/ordenes/imprimir/<?php echo $u->id; ?>" target="_blank" ><i class="fa fa-print" aria-hidden="true"></i>  </a>


                        </tr>
                    <?php }
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
