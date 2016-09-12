
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/lugares/crea" class="button nuevo">Nuevo Lugar</a>
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
   <table id='example1' class='display datatable' border='0' cellspacing='0' cellpadding='0' >
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
                        <a href="<?php echo base_url(); ?>admin/lugares/edita/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Editar
                        <?php if($admin==1 ){ ?><a href="<?php echo base_url(); ?>admin/lugares/borra/<?php echo $u->id; ?>" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /> </a> Borrar</td><?php } ?>
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
