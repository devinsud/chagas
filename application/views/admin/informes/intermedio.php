<h2>Informes de la sede <?php echo $sede[0]->localidad; ?></h2>

<!--<a href="<?php echo base_url(); ?>admin/informes/informes_print/<?php echo $sede[0]->id; ?>" target="_blank"> Imprimir </a>-->
<hr>

<?php
echo form_open_multipart(base_url() . 'admin/informes/index/');
?>

<div class="col-xs-6">
    <div class="form-group">
        <label for='desde'>Fecha desde</label>
        <input id="desde" name="desde" class="form-control" size="15" value="<?php echo $desde; ?>" />
    </div>
</div>

<div class="col-xs-6">
    <div class="form-group">
        <label for='hasta'>Fecha hasta</label>
        <input id="hasta" class="form-control" name="hasta" size="15" value="<?php echo date('Y-m-d'); ?>"  />
        <input type='hidden' name='id_sede' value='<?php echo $sede[0]->id; ?>'>
    </div>
</div>

<div class="col-xs-6">
    <div class="form-group">
        <label for='barrios'> Barrios </label>
        <select id="barrios" class="form-control"  name="barrios">
            <option value="">Todos</option>
            <?php
            foreach ($barrios as $b) {
                if ($barrio == $b->id) {
                    echo '<option value="' . $b->id . '" selected>' . $b->nombre . '</option>';
                } else {
                    echo '<option value="' . $b->id . '">' . $b->nombre . '</option>';
                }
            }
            ?>
        </select>
    </div>
</div>

<div class="col-xs-6">
    <div class="form-group">
        <label for='manzana'>Manzana </label>
        <input id="manzana" name="manzana"  class="form-control" size="5" value="<?php echo (isset($manzana)) ? $manzana : ''; ?>" />
    </div>
</div>

<div class="col-xs-12">
    <hr/>
    
    <p>  <label for='ciclos'>Ciclo/Muestreo </label></p>

    <div class="btn-group" role="group" aria-label="...">
        <button type="button" id="todosbutton" class="btn btn-info " onclick="seleccionarTipo(0)">Todos</button>
        <button type="button" id="ruralbutton" class="btn btn-default" onclick="seleccionarTipo('tipo_rural')">Rural</button>
        <button type="button" id="urbanobutton" class="btn btn-default" onclick="seleccionarTipo('tipo_urbano')">Urbano</button>
    </div>
 
    <div class="form-group">
        <br>
        <input id="zona" name="zona" type="hidden" value=""/>
        <select id="ciclos_dropdown" name="filtro_ciclos[]"  class="form-control" multiple="multiple">
            <option value="">Todos</option>
            <?php
            foreach ($ciclos as $ciclo) {
                echo '<option class="tipo_' . $ciclo->tipo . '" value="' . $ciclo->id . '">' . $ciclo->ciclo . ' - '.$ciclo->tipo.' </option>';
            }
            ?>
        </select>
    </div>
    <hr/>
    <input type="submit" class="btn btn-success pull-right" name="submit" value="Aplicar Criterios" />
</div>

<?php echo form_close(); ?>
<script>
    var zona=0;
    var todos = $("#ciclos_dropdown option");
    $("#ciclos_dropdown").change(function () {
        $("#ciclos_dropdown :selected").each(function () {
            if ($(this).val() == "") {
                if(zona=="tipo_rural"){
                   $("#zona").val("rural");
               }else if(zona=="tipo_urbano"){
                    $("#zona").val("urbano");
               }else{
                    $("#zona").val("");
               }
            }else{
                $("#zona").val(""); 
            }
        })
    })
    function seleccionarTipo(tipo) {
        zona=tipo;
        if(zona=="tipo_rural"){
           $("#ruralbutton").removeClass('btn-default').addClass('btn-info');
           $("#urbanobutton").removeClass('btn-info').addClass('btn-default');
           $("#todosbutton").removeClass('btn-info').addClass('btn-default');
        }else if(zona=="tipo_urbano"){
           $("#urbanobutton").removeClass('btn-default').addClass('btn-info');
           $("#ruralbutton").removeClass('btn-info').addClass('btn-default');
           $("#todosbutton").removeClass('btn-info').addClass('btn-default');
        }else if(zona==0){
           $("#todosbutton").removeClass('btn-default').addClass('btn-info');
           $("#urbanobutton").removeClass('btn-info').addClass('btn-default');
           $("#ruralbutton").removeClass('btn-info').addClass('btn-default');
        }
        
        $("#ciclos_dropdown").html("");
        var ciclos = "<option value=''>Todos</option>";
        todos.each(function () {
            if (tipo == 0) {
                if ($(this).attr("class") == "tipo_rural" || $(this).attr("class") == "tipo_urbano") {
                    ciclos = ciclos + "<option class='" + $(this).attr("class") + "' value='" + $(this).val() + "'>" + $(this).text() + "</option>";
                }
            } else if (tipo == $(this).attr("class")) {
                 ciclos = ciclos + "<option class='" + $(this).attr("class") + "' value='" + $(this).val() + "'>" + $(this).text() + "</option>";
            }
        });

        $("#ciclos_dropdown").html(ciclos);
    }

</script>
