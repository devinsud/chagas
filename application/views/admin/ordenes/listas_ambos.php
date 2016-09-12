
<div class="top-bar">
    
    <h1 class="titulo">Creraci&oacute;n de ordenes de trabajo</h1>
</div>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
 <?php
            $attributes = array('id' => 'id-form', 'target'=>'_blank');
            echo form_open_multipart(base_url().'admin/viviendas/vista_previa',$attributes); ?>
    <div class="table1" >
         <input type="hidden" name="sede" value="<?php echo $sede; ?>">
        <div class="listado" id="acordeon" >

            <?php 
            foreach($barrios as $b){
                $viv = $this->vivienda->getViviendasByBarrioId($b->id);
                if(count($viv)>1){
            ?>
                <h3 class="barrios"><?php echo $b->nombre; ?> <a href="#" onclick="agregaBarrioCompleto(<?php echo $b->id; ?>)"><img src="<?php echo base_url();?>assets/img/fd.jpg" rel="<?php echo $b->id; ?>"  width="16" height="16" alt=""></a> </h3>
                <div>
                    <ul id="listado_viviendas<?php echo $b->id; ?>" class="listado_viviendas">
                        <?php foreach ($viv as $v) { ?>
                                <li class="itemlista" bel='vivienda' rel="v<?php echo $v->id_vivienda; ?>"><?php echo $v->id_vivienda; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } 
            } ?>
        </div>
        
       <div id="cart" style="border:1px solid #fbd850; float:left;">
            <h3>Listado para <select name="tipo" id="tipo_de_orden">
                <option value="Inspecci&oacute;n">Inspeccion</option>
                <option value="Rociado">Rociado</option>
                <option value="Mejoras">Mejoras</option>

            </select></h3>
            <label for="fecha" style="color:#eb8f00;">Fecha</label>
            <input type="text" id="fecha_orden" name="fecha">
            <br>
            <label  style="color:#eb8f00;" for="operador">Operador </label>  
                    <select name="operador[]"  id="operador" multiple>

                    <option value=""></option>
                        <?php foreach($operadores as $ope){ ?>
                                <option value="<?php echo $ope->id; ?>"><?php echo $ope->nombre . ', '. $ope->apellido;?></option>
                        <?php } ?>
                    </select>
            <div class="ui-widget-content">
                <ol style="list-style:none;">
                  <li class="placeholder">Arroje las viviendas aqu&iacute;</li>
                </ol>
            </div>
            <br>
            <div id="quimicos" style="display:none;">
                <label for="observaciones" style="color:#eb8f00;">Qu&iacute;mico: </label>
                <input type="text" name="quimico">
            </div>
            <label for="observaciones" style="color:#eb8f00;">Observaciones: </label>
            <textarea name="observaciones" id="" cols="30" rows="10"></textarea>
        </div>
        
        <div style="border:1px solid #000;">
           
                
                <input type="text" id="caja" name="viviendas" value=""  />
                
                <input type="submit" value="Guardar y abrir pagina de impresi&oacute;n ->" style="font-size:1.4em;padding:4px; margin-top:5px;">
           
        </div>
</div>
 <?php form_close();?>