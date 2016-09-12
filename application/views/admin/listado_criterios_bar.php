
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/admin/registro_cia" class="button nuevo">Nueva Compa&ntilde;&iacute;a </a>
    <?php } ?>
    <h1>Compa&ntilde;&iacute;as</h1>
    <div class="breadcrumbs"><a href="<?php echo base_url(); ?>admin/admin">Homepage</a> / <a href="<?php echo base_url(); ?>admin/admin/cia">Compa&ntilde;&iacute;as</a></div>
</div>
<div class="select-bar">
    
        <label>
            <?php if( $criterio != ''){ ?>
            <input type="text" name="textfield" value="<?php echo $criterio;?>" id="busqueda_cia" />
            <?php }else{ ?>
            <input type="text" name="textfield"  id="busqueda_cia" />
            <?php } ?>
        </label>
        <label>
            <input type="submit" name="Submit" value="Buscar" class="buscar_cia" />
        </label>
   
</div>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table">
    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
           

            <th>Compa&ntilde;&iacute;a</th>
            <th>Contacto</th>
            <th>Te</th>
            <th>Descuento</th>
            
            <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
            <th>Editar</th>
            <th>Borrar</th>
            <?php } ?>

        </tr>

        <?php
        if (isset($cias) && count($cias) > 0) {
            foreach ($cias as $u) {
                ?>
                <tr>
                    <td class="style1"> <?php echo $u->cia; ?> </td>
                    <td class="style1"> <?php echo $u->contacto; ?> </td>
                    <td class="style1"> <?php echo $u->te; ?> </td>
                    <td class="style1"> <?php echo $u->descuento; ?>% </td>


                    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
                    <td><a href="<?php echo base_url(); ?>admin/admin/editar_cia/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /></td>
                    <td><a href="<?php echo base_url(); ?>admin/admin/borrar_cia/<?php echo $u->id; ?>" class="borracia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /></a></td>
                    <?php } ?>
                </tr>
    <?php }
} else { ?>
            <tr><td>No hay compa&ntilde;&iacute;as cargadas actualmente</td></tr>
        <?php } ?>

    </table>
    <div class="select">
        <strong>Otras P&aacute;ginas: </strong>
           
        <select class="paginador_cia">
            <?php
            $pagina = (int) ceil($cant / 10);

            for ($a = 0; $a < $pagina; $a++) {
                if ($pag_sel == ($a)) {
                    ?>
                    <option value="<?php echo $a; ?>" selected><?php echo $a + 1; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $a; ?>"><?php echo $a + 1; ?></option>
                <?php }
            } ?>
        </select>
    </div>
</div>
