
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/usuarios/crear" class="button nuevo">Nuevo Usuario</a>
    <?php } ?>
    <h1 class="titulo">Administraci&oacute;n de Usuarios</h1>
    <br><br>
    <hr>
    <div style="width:1000px;" id="usu">
    <!--
        <?php echo form_open_multipart(base_url().'admin/usuarios/informes/');  ?>

           <label for='fecha_desde'>Fecha desde </label>
            <input id="desde" name="item[desde]" size="15" />
            <label for='fecha_hasta'>Fecha hasta </label>
            <input id="hasta" name="item[hasta]" size="15"   />

            


            
            <label for='sede'>Sede </label>
            <select id="sede" name="item[sede]" >
                    <option value=""></option>
                    <?php
                    foreach ($sedes as $key => $value) {
                        if($key==$item->id_sede){
                            echo '<option value="' . $key . '" selected>'. $value .'</option>';
                         }else{
                            echo '<option value="' . $key . '">'. $value .'</option>';
                         }
                    }
                    ?>

                </select>

            <label class="control-label" for="ciclo">Ciclo </label>  
            <select name="item[ciclo]"  id="ciclo" style="width:150px;" >
            <option value=""></option>
                <?php foreach($ciclos as $cic){ ?>
                        <option value="<?php echo $cic->id; ?>"><?php echo $cic->ciclo.' ( '.$cic->tipo.' ) '; ?></option>
                <?php } ?>
            </select>
            <input type="submit" name="submit" value="Ver informe" />

        </form>
        -->
    </div>
    <hr class="linea_baja">
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
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Sede</th>
                <th>Admin</th>
                <th>Herraminetas</th>

            </tr>
        </thead>
        <tbody>
        <?php
        if(!is_null($items)){
            if (isset($items) && count($items) > 0 ) {
                foreach ($items as $u) {
                    ?>
                    <tr>
                        <td class="nombre_fuente"> <?php echo $u->nombre; ?> </td>
                        <td class="url_fuente"> <?php echo $u->apellido; ?> </td>
                        <td class="url_fuente"> <?php echo $u->email; ?> </td>
                        <td class="url_fuente"> <?php echo $u->sede; ?> </td>
                        <td class="url_fuente"> <?php echo ($u->isadmin == 1)?'Si':'No'; ?></td>

                        <td class="herramientas_fuentes1">
                        <a href="<?php echo base_url(); ?>admin/usuarios/editar/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Editar |
                        <a href="javascript:borrarItem('<?php echo base_url(); ?>admin/usuarios/borrar/<?php echo $u->id; ?>')" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" />  Borrar</a> |
                        <a href="<?php echo base_url(); ?>admin/usuarios/informe/<?php echo $u->id; ?>" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/informes.png" width="16" height="16" alt="" />  Informe</a>
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
