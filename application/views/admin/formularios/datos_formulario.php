 
<hr>
    <?php  echo form_open_multipart(base_url().'admin/formularios/excel'); ?>
    <label for='fecha_desde'>Fecha desde </label>
    <input id="fecha_desde" name="fecha_desde" size="15"/>
    <label for='fecha_hasta'>Fecha hasta </label>
    <input id="fecha_hasta" name="fecha_hasta" size="15"/>
    <input type='hidden' name='id_form' value='<?php echo $form;?>'>
    <label for='barrios'> Barrios </label>
    <select id="barrios" name="barrios">
        <option value="">Todos</option>
        <?php 

        foreach ($barrios as $key => $value) {
          if($barrio==$key){
            echo '<option value="' . $key . '" selected>'. $value .'</option>';
          }else{
              echo '<option value="' . $key . '">'. $value .'</option>';
          }
        }
        ?>
                    
    </select>   
    <?php echo form_submit('submit','Exportar excel'); 




   
echo form_close();
?>
<hr>
 
<div style="width:1100px; overflow:scroll">

                    <?php
                    
                    if(isset($datos) && count($datos>0)){
                      foreach ($datos as $value) {

                          $campos = json_decode($value->datos);    
                          break;
                      }

                  }
                        // var_dump($campos);
                    ?>

                    <table id='example1' class='display datatable' border='0' cellspacing='0' cellpadding='0' >
                        <thead>
                          <tr>
                            
                              <?php 
                              if(isset($datos) && count($datos>0)){
                                
                                foreach($campos as $k=>$v){
                                  if($k!='id' && $k!='submit'){
                                      echo "<th>".$k.'</th>';
                                  }
                                }
                            }
                              ?>
                          </tr>
                        </thead>
                        <tbody>
                            <?php

                           if(isset($datos) && count($datos>0)){ 
                             foreach ($datos as $value) {
                                  $id = $value->id;
                                  $datos = json_decode($value->datos);  
                                  echo "<tr id='".$id."'>";  
                                  
                                  //echo '<td>'.anchor(base_url() . 'admin/formularios/edit/'.$id, '<img src="'.base_url().'assets/img/edit-icon.gif" alt="editar evento" width="16" height="16" alt="" />').'</td>';
                                 
                                  foreach($datos as $k1=>$v1){

                                  	//var_dump($k1 . " = " . $v1);
                                        if($k1!='id' && $k1!='submit'){
                                            echo "<td>";
                                              if($v1){
                                                echo $v1;
                                            }else{
                                              echo '0';
                                            }
                                            echo "</td>";
                                        }
                                      
                                  }
                                  echo "</tr>";
                              }
                          }

                    ?>


                        </tbody>


                    </table>
                </div>