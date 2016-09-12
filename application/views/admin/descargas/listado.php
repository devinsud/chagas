
<div class="top-bar">
   
    <h1>Descargas realizadas por los distintos canales</h1>
   
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
                
                <th>Canal</th>
                <th>Fecha</th>
                
                
                <th style="width:180px;">Herraminetas</th>
                
              

            </tr>
        </thead>
        <tbody>
        <?php
         
        if(!is_null($items)){

        if (isset($items) && count($items) > 0 ) {

            foreach ($items as $u) {
                ?>
                <tr>
                    
                
                    <td class="style1"> <?php echo $u->nombre; ?> </td>
                    <td class="style1"> <?php echo $u->fecha_descarga; ?> </td>
                
                    <td>
                   
                    <a href="<?php echo base_url(); ?>admin/descargas/borra/<?php echo $u->id_descargas; ?>" class="borranoticia"  style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/hr.gif" width="16" height="16" alt="" /> Borrar</a></td>
                    
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
