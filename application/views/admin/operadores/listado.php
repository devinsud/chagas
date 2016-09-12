
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/operadores/crear" class="button nuevo">Nuevo Operador de Campo</a>
    <?php } ?>
    <h1 class="titulo">Administraci&oacute;n de Operadores</h1>
    <br><br>
    
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
                <th>Apellido</th>
                <th>Email</th>
                <th>Fecha de Ingreso</th>
                <th>Sede</th>
                <th>Estado</th>
                <th>Herramientas</th>
                

            </tr>
        </thead>
        <tbody>
        <?php
        if(!is_null($items)){
            if (isset($items) && count($items) > 0 ) {
                foreach ($items as $u) {
                    if($u->nombre!=''){
                    ?>
                    <tr>
                        <td class="nombre_fuente"> <?php echo $u->nombre; ?> </td>
                        <td class="url_fuente"> <?php echo $u->apellido; ?> </td>
                        <td class="url_fuente"> <?php echo $u->email; ?> </td>
                        <td class="url_fuente"> <?php echo $u->fecha_ingreso; ?> </td>
                        <td class="url_fuente"> <?php 

                        $sede = $this->sede->getSedeId($u->id_sede);
                        echo $sede[0]->localidad; ?> </td>
                        
                        <td><a href="<?php echo base_url();?>admin/operadores/cambiaEstado/<?php echo $u->id;?>"><?php echo $u->estado; ?></a></td>
                        <td class="herramientas_fuentes1">
                        <a href="<?php echo base_url(); ?>admin/operadores/editar/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Editar |
                        <a href="<?php echo base_url(); ?>admin/operadores/informe/<?php echo $u->id; ?>" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/informes.png" width="16" height="16" alt="" /> </a> Informe
                    </td>
                    </tr>
            <?php } }
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
