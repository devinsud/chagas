

<div class="top-bar">
    <h1 class="titulo">Viviendas tratadas</h1>
    <strong>Sedes: </strong>

    
     <?php 
     
     foreach ($sedes as $se) { 
            if($sede == $se->id){
            ?>
            <a href="<?php echo base_url(); ?>admin/viviendas/rociadas/<?php echo $se->id; ?>" style="font-weight:bold;"><?php echo $se->localidad; ?></a> |
            <?php }else{ ?>
              <a href="<?php echo base_url(); ?>admin/viviendas/rociadas/<?php echo $se->id; ?>" ><?php echo $se->localidad; ?></a> |
        <?php 
        }
        } ?>
    <br>
    <br>
    <br>

</div>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
<div class="table1">
   <table id='example1'  class="table table-striped table-bordered table-hover" border='0' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>
                <th>Sede</th>
                 <th>Id Vivenda</th>
                 <th>Barrio</th>
                
                 <th>Rociada</th>

                 
                
               <th>Fecha de rociado</th>
                <th>Químico</th>
                <th>Dosis</th>
                <th>Motivo</th>
               
            </tr>
        </thead>
        <tbody>
        <?php
        if(!is_null($items)){
            if (isset($items) && count($items) > 0 ) {
                foreach ($items as $u) { 
                    
                    ?>
                <tr>
                        <td> <?php echo $u->id_sede; ?></td>
                        <td class="nombre_fuente"> <?php echo $u->idv; ?> </td>
                        <td><?php 

                        $barrio =  $this->barrio->getbarrioId($u->id_barrio);
                        if(isset($barrio[0])){
                            echo $barrio[0]->nombre;
                        }else{
                            echo "barrio no cargado";
                        }
                        ?></td>
                   
                    

                       
                       
                        <td>
                                                    
                           

                            
                            <a class="btn btn-xs btn-info" href="<?php echo base_url(); ?>admin/ordenes/verDatosTratadas/<?php echo $u->idv; ?>/<?php echo $u->id_orden; ?>" ><i class="fa fa-eye" aria-hidden="true"></i> Ver </a>                           

                        </td>
                        <td><?php echo $u->fecha_rociado; ?></td>
                        
                        <td><?php echo $u->quimico; ?></td>
                        <td><?php echo $u->cantidad; ?></td>
                        <td><?php echo $u->motivo; ?></td>
                    </tr>
            <?php }
            } else { ?>
            <tr><td>No hay viviendas cargados actualmente</td></tr>
        <?php }

        }else { ?>
            <tr><td>No hay viviendas cargados actualmente</td></tr>
    <?php }
    ?>
    </tbody>
    </table>

</div>
