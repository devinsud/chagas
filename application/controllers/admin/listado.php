

<div class="top-bar">
    <?php
    if ($admin == 1) {
        foreach ($sedes as $sede1) {
            ?>
            <a href="<?php echo base_url(); ?>admin/viviendas/listas/<?php echo $sede1->id; ?>" class="btn btn-success">Crear Listas para la sede <?php echo $sede1->localidad; ?></a>
            <?php
        }
    }
    ?>
    <h1 class="titulo">Administraci&oacute;n de ordenes de trabajo</h1>
    <strong>Sedes: </strong>
    <?php
    foreach ($sedes as $se) {
        if ($sede == $se->id) {
            ?>
            <a href="<?php echo base_url(); ?>admin/ordenes/index/<?php echo $se->id; ?>" style="font-weight:bold;"><?php echo $se->localidad; ?></a> |
        <?php } else { ?>
            <a href="<?php echo base_url(); ?>admin/ordenes/index/<?php echo $se->id; ?>" ><?php echo $se->localidad; ?></a> |
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
    <table id='example1' class='display datatable' border='0' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>
                <th>Sede</th>
                <th>Ciclo</th>
                <th>id Orden</th>
                <th>Operador</th>
                <th>Fecha</th>
                <th>Tipo de Orden</th>
                <th>Oprobada</th>





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
                            <td class="nombre_fuente"> <?php echo $u->fecha; ?> </td>
                            <td class="nombre_fuente"> <?php echo $u->tipo; ?> </td>

                            <td>
                                <?php
                                $aprobada = ($u->aprobada == 1) ? 'ok.png' : 'esperando.png';
                                ?>
                                <img src="<?php echo base_url(); ?>assets/img/<?php echo $aprobada; ?>" width="16" height="16">
                            </td>

                            <td class="herramientas_fuentes">
                                <?php if ($u->tipo == 'Rociado') { ?>

                                    <a class="btn btn-xs btn-default" href="<?php echo base_url(); ?>admin/ordenes/ver/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/ojo.png" width="16" height="16" alt="ver" /> </a> | 
                                    <a class="btn btn-xs btn-info" href="<?php echo base_url(); ?>admin/ordenes/imprimir/<?php echo $u->id; ?>" target="_blank" ><img src="<?php echo base_url(); ?>assets/img/printer.png" width="16" height="16"  alt="imprimir" />  </a> | 
                                    <a class="btn btn-xs btn-warning" href="<?php echo base_url(); ?>admin/ordenes/procesar/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="procesar" />  </a>


                                <?php } else { ?>
                                    <a class="btn  btn-xs btn-default" href="<?php echo base_url(); ?>admin/ordenes/ver/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/ojo.png" width="16" height="16" alt="ver" />  </a> |
                                    <a class="btn btn-xs btn-default" href="<?php echo base_url(); ?>admin/ordenes/imprimir/<?php echo $u->id; ?>" target="_blank" ><img src="<?php echo base_url(); ?>assets/img/printer.png" width="16" height="16" alt="imprimir" />  </a> 
                                    <?php } ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr><td>No hay viviendas cargados actualmente</td></tr>
                    <?php
                }
            } else {
                ?>
                <tr><td>No hay viviendas cargados actualmente</td></tr>
            <?php }
            ?>
        </tbody>
    </table>

</div>
