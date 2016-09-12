
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/documentos/crea" class="button nuevo">Nuevo Documento</a>
    <?php } ?>
    <h1>Documentos</h1>
    <div class="breadcrumbs">
        <a href="<?php echo base_url(); ?>admin/admin">Homepage</a> / <a href="<?php echo base_url(); ?>admin/documentos/index">Documentos</a>
    </div>
</div>

<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table">
    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
           

            <th>T&iacute;tulo</th>
            <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
            
            <th>Borrar</th>
            <?php } ?>

        </tr>

        <?php
        if (isset($items) && count($items) > 0) {
            foreach ($items as $u) {
                ?>
                <tr>
                    <td class="style1"> <?php echo $u->titulo; ?> </td>
                    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10){ ?>
                    
                    <td><a href="<?php echo base_url(); ?>admin/documentos/borra/<?php echo $u->id; ?>" class="borradocumento"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /></a></td>
                    <?php } ?>
                </tr>
    <?php }
} else { ?>
            <tr><td>No hay documentos cargados actualmente</td></tr>
        <?php } ?>

    </table>
    
</div>
