
<div class="top-bar">
    <?php if($this->session->userdata('type')==1 || $this->session->userdata('type')==10 ){ ?>
    <a href="<?php echo base_url(); ?>admin/viviendas/crea" class="button nuevo">Nueva Viviendaaaa</a> | 
    <a href="<?php echo base_url(); ?>admin/viviendas/listas" class="button nuevo">Crear Listas</a>

    <?php } ?>
    <h1 class="titulo">Creraci&oacute;n de ordenes de inspecci&oacute;n</h1>
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

        <div class="listado" style="width:140px; float:left; border:1px solid #000;">
        <h3>Viviendas</h3>
        <ul id="listado_viviendas">
            <?php foreach ($items as $u) { ?>
                <li class="itemlista"><?php echo $u->idv; ?></li>
            <?php } ?>
        </ul>
        </div>
        <div class="listado" style="width:140px; float:left; border:1px solid #000;">
        <h3>Barrios</h3>
        <ul id="listado_viviendas">
            <?php foreach ($barrios as $b) { ?>
                <li class="itemlista1"><?php echo $b->codigo; ?></li>
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
                <ol>
                  <li class="placeholder">Arroje las viviendas aqu&iacute;</li>
                </ol>
            </div>
            
            <label for="observaciones">Observaciones: </label>
            <textarea name="observaciones" id="" cols="30" rows="10"></textarea>
        </div>



        <div>
           
                
                <input type="hidden" id="caja" name="viviendas" value=""  />
                <input type="submit" value="vista previa" style="padding:4px;">
           
        </div>
</div>
 <?php form_close();?>