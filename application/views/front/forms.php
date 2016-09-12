 
Formulario : <?php echo $item->nombre; ?>
 <form action="<?php echo base_url(); ?>formularios_front/formu" method="post" id="form1" novalidate="novalidate">
	<?php
	  echo $item->formulario;
	  echo "<input type='hidden' name='id' value='".$item->id."' />";
    echo "<input type='hidden' name='id_sede' value='".$sede->id."' />";
	  
	?>
	<input type="submit" id="submit" name="submit" value="Guardar"  class="submit"  />
</form>               
<br/>
<br/>
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