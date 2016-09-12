
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/formularios/crea" class="button nuevo">Nuevo Formulario</a>
    <?php } ?>
    <h1>Administraci&oacute;n de formularios</h1> 
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
                <th>Proyecto</th>
                <th>Nombre del formulario</th>
               
                <th style="width:180px;">Herraminetas</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(!is_null($items)){
            if (isset($items) && count($items) > 0 ) {
                foreach ($items as $u) {


                            $sede =$this->sede->getSedeId($u->id_sede);
                            $proyecto = $this->proyecto->getProyectoId($u->id_sede);
                     
                    ?>
                    <tr>
                        <td class="nombre_fuente"> <?php echo $sede[0]->localidad; ?> </td>
                        <td class="url_fuente"> <?php echo $proyecto[0]->nombre; ?> </td>
                        <td class="url_fuente"> <?php echo $u->nombre; ?> </td>
                       
                        
                        <td class="herramientas_fuentes">
                             <a href="<?php echo base_url(); ?>formularios_front/formu/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/lista.png" width="16" height="16" alt="" /> Usar </a> | 
                              <a href="<?php echo base_url(); ?>formularios_front/datos/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/lista.png" width="16" height="16" alt="" /> Datos </a> 



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
