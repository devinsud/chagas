<div id="contacto">
                        <div class="formulario">

                        <?php

                            $attr = array('id'=>"contacto1");
                            echo form_open(base_url() . 'contacto/envio',$attr);
                                echo '<label for="nombre">Nombre</label>';
                                echo '<br/>';
                                echo form_input('user[nombre]');
                                echo '<br/>';
                                echo '<label for="email">Email</label>';
                                echo '<br/>';
                                echo form_input('user[email]');
                                echo '<br/>';
                                echo '<label for="comentario">Comentario</label>';
                                echo '<br/>';
                                echo form_textarea('user[comentario]');
                                echo '<br/>';
                                echo form_submit('submit', 'Enviar');

                         ?>
                     </form>
                    </div>
                    <div class="datos_contacto">
                        Tel: 011 15 4 9929656 </br>
                        email: info@altosdesanjose.com.ar

                    </div>
                    </div>
