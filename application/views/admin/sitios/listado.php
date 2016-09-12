
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/sitios/crea" class="button nuevo">Nuevo sitio</a>
    <?php } ?>
    <h1>Sitios que consumen el servicio</h1>
   
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
                <th>ID</th>
                <th>Nombre</th>
                <th>url</th>
                <th>ip</th>
                <th>url_servicio</th>
                <th style="width:180px;">Herraminetas</th>
                
              

            </tr>
        </thead>
        <tbody>
        <?php
         
        if(!is_null($items)){

        if (isset($items) && count($items) > 0 ) {
            $hoy = @date('d/m/Y');
            foreach ($items as $u) {
                ?>
                <tr>
                    
                    <td class="style1"> <?php echo $u->id; ?> </td>
                    <td class="style1"> <?php echo $u->nombre; ?> </td>
                    <td class="style1"> <?php echo $u->url; ?> </td>
                    <td class="style1"> <?php echo $u->ip; ?> </td>
                    <td class="style1"> <?php 
                    if($u->url_servicio!=''){
                        echo $u->url_servicio.$hoy; 
                    }else{
                        echo '&nbsp';
                    }
                    ?> </td>
                    <td>
                    <a href="<?php echo base_url(); ?>admin/sitios/edita/<?php echo $u->id; ?>" ><img src="<?php echo base_url(); ?>assets/img/edit-icon.gif" width="16" height="16" alt="" /> Editar  | 
                    <a href="<?php echo base_url(); ?>admin/sitios/borra/<?php echo $u->id; ?>" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /> Borrar | </a>

                    <a href="<?php echo base_url();?>admin/noticias/importFromService/<?php echo $u->id;?>" >Actualizar</a> 
                    </td>
                    
                </tr>
    <?php }
    } else { ?>
            <tr><td>No hay criterios cargados actualmente</td></tr>
        <?php } 

    }else {?>
            <tr><td>No hay criterios cargados actualmente</td></tr>
    <?php } 
    ?>

    </tbody>
    </table>
    
</div>
