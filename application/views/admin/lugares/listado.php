
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/lugares/crea" class="btn btn-success">Nuevo Lugar</a>
    <?php } ?>
    <h1 class="titulo">Administraci&oacute;n de lugares</h1>
    <div style="width:900px; height:30px;">
        <?php
            if ($this->session->flashdata('message')) {
                echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
            }
        ?>
    </div>
</div>

<div class="table1">
   <table id='example1' class="table table-striped table-bordered table-hover" border='0' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Tipo</th>

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
                        <td class="nombre_fuente"> <?php echo $u->id; ?> </td>
                        <td class="url_fuente"> <?php echo $u->nombre; ?> </td>
                        <td class="url_fuente">  <?php echo $u->tipo; ?> </td>

                        <td class="herramientas_fuentes">
                          <?php if($admin==1 ){ ?>
                            <a class="btn btn-xs btn-warning" href="<?php echo base_url(); ?>admin/lugares/edita/<?php echo $u->id; ?>" ><i class="fa fa-edit" aria-hidden="true"></i> Editar</a>
                     
                            <a class="btn btn-xs btn-danger" href="javascript:borrarItem('<?php echo base_url(); ?>admin/lugares/borra/<?php echo $u->id; ?>')" class="borranoticia"  style="cursor:pointer;"><i class="fa fa-minus" aria-hidden="true"></i>  Borrar</a></td><?php } ?>
                    </tr>
            <?php }
            } else { ?>
            <tr><td>No hay lugares cargados actualmente</td></tr>
        <?php }

        }else { ?>
            <tr><td>No hay lugares cargados actualmente</td></tr>
    <?php }
    ?>
    </tbody>
    </table>

</div>
