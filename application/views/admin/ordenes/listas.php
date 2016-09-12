
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/viviendas/crea" class="button nuevo">Nueva Vivienda</a> | 
    <a href="<?php echo base_url(); ?>admin/viviendas/listas" class="button nuevo">Crear Listas</a>

    <?php } ?>
    <h1 class="titulo">Creraci&oacute;n de ordenes de trabajo</h1>
</div>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
?>
 <?php
            $attributes = array('id' => 'id-form');
            echo form_open_multipart(base_url().'admin/viviendas/vista_previa',$attributes); ?>
    <div class="table1" >

        <div class="listado" style="width:220px; float:left; border:1px solid #000;">
        <h3>Viviendas</h3>
        <ul id="listado_viviendas">
            <?php foreach ($items as $u) { 
                $barrio = $this->barrio->getbarrioId($u->id_barrio);

                ?>
                <li class="itemlista" bel='vivienda' rel="<?php echo $u->idv; ?>"><?php echo $u->idv; ?> - <?php echo $barrio[0]->nombre; ?></li>
            <?php } ?>
        </ul>
        </div>
        
       <div id="cart" style="border:1px solid #000; float:left;">
            <h3>Listado para <select name="tipo" id="">
                <option value="Inspecci&oacute;n">Inspecci&oacute;n</option>
                <option value="Rociado">Rociado</option>
                <option value="Mejoras">Mejoras</option>

            </select></h3>
            <label for="fecha">Fecha</label>
            <input type="text" id="fecha_orden" name="fecha">
            <div class="ui-widget-content">
                <ol style="list-style:none;">
                  <li class="placeholder">Arroje las viviendas aqu&iacute;</li>
                </ol>
            </div>
            
            <label for="observaciones">Observaciones: </label>
            <textarea name="observaciones" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="listado" style="width:220px; float:left; border:1px solid #000;">
        <h3>Barrio Completo</h3>
        <ul id="listado_barrios">
            <?php foreach ($barrios as $b) { 
               

                ?>
                <li class="itemlista" bel='barrio' rel="<?php echo $b->id; ?>"><?php echo $b->nombre; ?> </li>
            <?php } ?>
        </ul>
        </div>
         <!--
        <div style="border:1px solid #000; float:left; width:200px;">
           
            <select name="barrio" id="barrios">
                <option value="">Seleccione un barrio completo</option>
                <?php foreach($barrios as $b){ ?>
                    <option value="<?php echo $b->id; ?>"><?php echo $b->nombre; ?></option>            
                <?php } ?>
                
                
            </select>
            

        </div>
        -->
        <div>
           
                
                <input type="text" id="caja" name="viviendas" value=""  />
                <input type="text" id="cajaBarrios" name="barrios" value=""  />
                <input type="submit" value="vista previa" style="padding:4px;">
           
        </div>
</div>
 <?php form_close();?>