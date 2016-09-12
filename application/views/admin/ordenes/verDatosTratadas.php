<h2>Datos del rociado de la vivienda <?php echo $datos[0]->id_vivienda; ?> </h2>
Qu&iacute;mico utilizado : <?php echo $datos[0]->quimico; ?> <br><br>
Cantidad de monodosis x 100ml utilizadas : <?php echo $datos[0]->cantidad; ?>  <br><br>
Fecha de rociado : <?php echo $datos[0]->fecha_rociado; ?>  <br><br>
Motivo del rociado : <?php echo $datos[0]->motivo; ?>   <br><br>
Observaciones : <?php echo $datos[0]->observaciones; ?>   <br><br>
<a href="<?php echo base_url(); ?>admin/viviendas/rociadas/">< Volver</a>