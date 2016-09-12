

   


<hr>
 <?php   

echo form_open_multipart(base_url().'admin/usuarios/informe/'.$item->id);

?>
  
   <label for='fecha_desde'>Fecha desde </label>
    <input id="desde" name="item[desde]" size="15" value="<?php echo $otros_datos['desde']; ?>" />
    <label for='fecha_hasta'>Fecha hasta </label>
    <input id="hasta" name="item[hasta]" size="15" value="<?php echo $otros_datos['hasta']; ?>"  />
    <input type='hidden' name='item[id_user]' value='<?php echo $item->id;?>'>
    <label for='ciclo'>Ciclo/Muestreo </label>
    <input id="ciclo" name="item[ciclo]" size="15" value="<?php echo $otros_datos['ciclo']; ?>" />
    <input type="submit" name="submit" value="Aplicar Criterios" /> 
   
</form>
<hr>

<div>
	<h2>Usuario : <?php echo $item->apellido.', '.$item->nombre; ?></h2>
	Cantidad de relevamientos realizados por el usuario: <strong><?php echo $otros_datos['cant']; ?></strong> de un total de <strong><?php echo $todos['cant']; ?></strong>
	<br><br>
	<?php //dump($datos);die; ?>

	<div style="width:1100px; overflow:scroll">

                    <?php
                    
                    if(isset($datos) && count($datos>0)){
                    	//dump($datos);
                      foreach ($datos as $value) {

                          $campos = $value;    
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
                                  $datos = $value;  
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