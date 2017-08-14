<div class="table">
    <?php
    $attributes = array('id' => 'id-form');
    echo form_open_multipart(base_url() . 'admin/viviendas/editarInspeccion', $attributes);
    ?>
    <h2>Inspecci&oacute;n de viviendas</h2>
    <?php $datos = $this->vivienda->explode_id($item->id_vivienda); ?>
    <input type="hidden" name="item[ciclo]" value="<?php echo $ciclo_orden ?>">
    <input type="hidden" name="item[orden]" value="<?php echo $orden ?>">
    <input type="hidden" name="idv" value="<?php echo $idv; ?>">
    <input type="hidden" name="item[idi]" value="<?php echo $id_inspeccion; ?>">

    <div class="panel panel-primary">

        <div class="panel-heading">
            <h3 class="panel-title">Datos de la vivienda</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <label class="control-label" for="id">Id de la vivienda : </label><?php echo $item->id_vivienda; ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label class="control-label" for="barrio">Barrio : </label><?php echo $datos['nombre_barrio']; ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label class="control-label" for="id">Tipo de vivienda : </label><?php echo $item->tipo; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <label class="control-label" for="id">Latitud : </label><?php echo $item->latitud; ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label class="control-label" for="barrio">Longitud : </label><?php echo $item->longitud; ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label class="control-label" for="id">Cantidad de habitantes : </label><?php echo $item->habitantes; ?>
                </div>
            </div>

        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Formulario de inspección </h3>
        </div>
        <div class="panel-body">

            <div class="control-group">
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="jefe">Jefe de Familia </label>
                            <input type="text" name="item[jefe]" class="form-control" required="required" id="jefe" value="<?php if (count($jefe) != 0) {
        echo $jefe[0]->nombre;
    } ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="ciclo">Cantidad de Habitantes </label>
                            <input type="text" name="item[habitantes]" required="required" class="form-control" id="habitantes" value="<?php echo $item->hab; ?>" >


                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="ciclo">Ciclo </label>
                            <select name="item[ciclo]" class="form-control" disabled   id="ciclo" value="<?php echo $item->habitantes; ?>">
                                <option value=""></option>
                                <?php
                                foreach ($ciclos as $cic) {
                                    $sele_ciclo = ($cic->id == $item->ciclo) ? 'selected' : '';
                                    ?>

                                    <option value="<?php echo $cic->id; ?>" <?php echo $sele_ciclo;
                                    ?> ><?php echo $cic->ciclo . ' ( ' . $cic->tipo . ' ) ';
                                ?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="operador">Operador </label>
                            <select name="item[operador][]" required="required" class="form-control"  id="operador" multiple>


                                <?php
                                $oper = explode('&&', $item->id_operador);

                                foreach ($operadores as $ope) {
                                    $sele_ope = (in_array($ope->id, $oper)) ? 'selected' : '';
                                    if ($ope->nombre != '') {
                                        ?>
                                        <option value="<?php echo $ope->id; ?>" <?php echo $sele_ope;
                                        ?>><?php echo $ope->nombre . ', ' . $ope->apellido;
                                        ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" name="item[id_vivienda]" value="<?php echo $item->id_vivienda; ?>" >
                            <input type="hidden" name="item[usuario]" value="<?php echo $usuario; ?>" >
                            <input type="hidden" name="item[inspeccion]" value="<?php echo $item->id_inspeccion; ?>" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="jefeflia">Fecha </label>
                            <input type="text" class="form-control" required="required" id="fecha_inspeccion" placeholder="Fecha" name="item[fecha_inspeccion]" value="<?php echo $item->fecha_inspeccion; ?>"  >
                        </div>                    
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="receptividad">Receptividad de vivienda </label>
                            <?php
                            $receptividad = array("receptiva", "cerrada", "renuente", "deshabitada", "desarmada");
                            ?>
                            <select class="form-control" name="item[receptividad]" id="receptividad">
                                <option value=""></option>

                                <?php
                                foreach ($receptividad as $recep) {
                                    $sele_recep = ($recep == $item->receptividad_vivienda) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $recep; ?>" <?php echo $sele_recep;
                                    ?>><?php echo $recep;
                                ?></option>
<?php } ?>
                            </select>
                        </div>                    
                    </div>
                    <div class="col-xs-12 col-md-2">
<?php $muestra = ($item->receptividad_vivienda == 'receptiva') ? 'display:block;' : 'display:none'; ?>
                        <div id="receptiva" style="<?php echo $muestra; ?>">
                            <div class="form-group">

                                <label class="control-label" for="vigilancia">Vigilancia Entomol&oacute;gica</label>
                                <select  class="form-control"  name="item[vigilancia]" id="vigilancia">
                                    <option value=""></option>
                                    <?php
                                    $vigilancia = array("Negativa" => "negativa", "Positiva" => "positiva");
                                    foreach ($vigilancia as $k => $v) {
                                        $sele_vig = ($v == $item->vigilancia_entomologica) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $v; ?>" <?php echo $sele_vig;
                                        ?>><?php echo $k;
                                    ?></option>
<?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>



            </div>




            <?php
            $muestra_vigi = ($item->vigilancia_entomologica == 'positiva') ? 'display:block;' : 'display:none';
            ?>


            <div class="positiva "  style="<?php echo $muestra_vigi; ?>">
                <div class=" linea_lugar well hidden" id="container_new[0]">
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group" >
                                <label class="control-label" for="vigilancia">Lugar: </label>
                                <select name="new[0][etim]" id="lugar" class="form-control" >
                                    <option value=""></option>
<?php foreach ($lugares as $lugar) {
    ?>

                                        <option value="<?php echo $lugar->id; ?>"  ><?php echo $lugar->nombre;
                                    ?></option>
<?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group" >
                                <label class="control-label" for="vigilancia">Etapa: </label>
                                <?php
                                $etapas = array('huevos', 'ninfas', 'adultos');
                                ?>
                                <select name="new[0][etapa]" id="edad" class="form-control" >
                                    <?php
                                    foreach ($etapas as $eta) {
                                        //$sele_eta = ($eta == $pos->etapa)?'selected':'';
                                        ?>
                                        <option value="<?php echo $eta; ?>"  ><?php echo $eta;
                                    ?></option>
<?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group" >
                                <label class="control-label" for="vigilancia">Cantidad: </label>
                                <?php
                                $cantidades = array('1' => '1 a 10', '2' => '11 a 50', '3' => '51 a 100', '4' => '+ 100');
                                ?>
                                <select name="new[0][cantidad]" id="edad" class="form-control"  >
                                    <?php
                                    foreach ($cantidades as $k1 => $v1) {
                                        //$sele_cant = ($k1 == $pos->cantidad)?'selected':'';
                                        ?>
                                        <option value="<?php echo $k1; ?>"  ><?php echo $v1;
                                    ?></option>
<?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-md-2">
                            <div class="form-group" >
                                <label class="control-label" for="cod">Codigo muestra: <input type="text" class="form-control" id="cod" placeholder="Codigo muestra" name="new[0][cod]" value=""   ></label>

                            </div>
                        </div>
                        <div class="col-xs-4 col-md-1">
                            <label class="control-label" for="cod"> Borrar
                                <button type="button" class="btn btn-danger" onclick="borrarContainer('new[0]')">X</button>
                            </label>
                        </div>
                    </div>

                </div>

                <?php
// dump($positivas);

                $cantidades = array('1' => '1 a 10', '2' => '11 a 50', '3' => '51 a 100', '4' => '+ 100');
                $etapas = array('huevos', 'ninfas', 'adultos');

                foreach ($positivas as $key => $pos) {
                    ?>


                    <div class="linea_lugar well ">
                        <div class="row">
                            <div class="col-xs-12 col-md-3">
                                <input type="hidden" name="idpos[]" value="<?php echo $pos->id; ?>" />
                                <label class="control-label" for="vigilancia">Lugar: </label>
                                <select name="actual[<?php echo $key ?>][etim]" id="lugar" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    foreach ($lugares as $lugar) {
                                        $sele_lug = ($lugar->id == $pos->donde) ? 'selected' : '';
                                        ?>

                                        <option value="<?php echo $lugar->id; ?>" <?php echo $sele_lug;
                                        ?> ><?php echo $lugar->nombre;
                                ?></option>
    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label class="control-label" for="vigilancia">Etapa: </label>
                                <select name="actual[<?php echo $key ?>][etapa]" id="edad" class="form-control">
                                    <?php
                                    foreach ($etapas as $eta) {
                                        $sele_eta = ($eta == $pos->etapa) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $eta; ?>" <?php echo $sele_eta;
                                        ?> ><?php echo $eta;
                                ?></option>
    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label class="control-label" for="vigilancia">Cantidad: </label>
                                <select name="actual[<?php echo $key ?>][cantidad]" id="edad" class="form-control">
                                    <?php
                                    foreach ($cantidades as $k1 => $v1) {
                                        $sele_cant = ($k1 == $pos->cantidad) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $k1; ?>" <?php echo $sele_cant;
                                        ?> ><?php echo $v1;
                                ?></option>
    <?php } ?>

                                </select>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <label class="control-label" for="cod">Codigo muestra: 
                                    <input type="text" class="form-control"  id="cod" placeholder="Codigo muestra" name="actual[<?php echo $key ?>][cod]" value="<?php echo $pos->codigo; ?>"  ></label>

                            </div>
                            <div class="col-xs-4 col-md-1">
                                <label class="control-label" for="cod"> Borrar
                                    <a  class="btn btn-danger" href="<?php echo base_url() . 'admin/viviendas/delPos/' . $orden . '/' . $idv . '/' . $pos->id . "/" . $ciclo_orden; ?>">X</a>

                                    <input type="hidden" name="actual[<?php echo $key ?>][idv_count]" value="<?php echo $idv ?>"/>
                                    <input type="hidden" name="actual[<?php echo $key ?>][post_id_count]" value="<?php echo $pos->id ?>"/>
                                </label>
                            </div>
                        </div>

                    </div>
<?php } ?>
            </div>
            <button type="button" class="btn btn-lg btn-info btn-block" id="mas" style="<?php echo $muestra_vigi; ?>"> + </button>

            <hr/>
            <div class="control-group">
                <input type="hidden" name="submit" value="Guardar" />
                <button class="btn btn-lg btn-success btn-block" type="submit" id="submit_inspeccion_edit" value="Guardar">Guardar</button>
            </div>
        </div>



<?php echo form_close(); ?>
    </div>

</div>