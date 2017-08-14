
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/barrios/crea" class="btn btn-success">Nuevo Barrio/paraje</a>
    <?php } ?>
    <h1 class="titulo">Administraci&oacute;n de barrios/parajes</h1>
</div>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table1">
   <table id='example1' class="table table-striped table-bordered" border='0' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Barrio</th>
                <th>Sede</th>
                <th>Estado para informes</th>
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
                        <td class="nombre_fuente"> <?php echo $u->codigo; ?> </td>
                        <td class="url_fuente"> <?php echo $u->nombre; ?> </td>
                        <td class="url_fuente"> <?php

                                                $this->db->where('id',$u->id_sede);
                                                $q = $this->db->get('sedes')->result();
                                                if(isset($q[0])){
                                                    if(is_object($q[0])){
                                                            echo $q[0]->localidad;
                                                    }else{
                                                        echo "sin nombre";
                                                    }
                                                }
                                                $base = base_url();

                        ?> </td>
                        <td>
                            <?php if($u->estado=="activo"){ ?>
                            <a class="btn btn-xs btn-success " href="<?php echo base_url();?>admin/barrios/cambiaEstado/<?php echo $u->id;?>">
                         <?php echo strtoupper($u->estado) ; ?>
                            </a>
                <?php }else{?>
                        <a class="btn btn-xs btn-danger" href="<?php echo base_url();?>admin/barrios/cambiaEstado/<?php echo $u->id;?>">
                         <?php echo strtoupper($u->estado); ?>
                            </a>
                <?php } ?>
                        </td>
                        <td class="herramientas_fuentes">
                            <a class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>admin/barrios/edita/<?php echo $u->id; ?>" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>
                        <?php if($admin == 1){ ?>
                        <a class="btn btn-danger btn-sm" href="javascript:borrarItem('<?php echo base_url(); ?>admin/barrios/borra/<?php echo $u->id; ?>')" class="borranoticia"  style="cursor:pointer;"><i class="fa fa-minus" aria-hidden="true"></i> Borrar</a> </td>
                        <?php } ?>
                    </tr>
            <?php }
            } else { ?>
            <tr><td>No hay barrios cargados actualmente</td></tr>
        <?php }

        }else { ?>
            <tr><td>No hay barrios cargados actualmente</td></tr>
    <?php }
    ?>
    </tbody>
    </table>

</div>
