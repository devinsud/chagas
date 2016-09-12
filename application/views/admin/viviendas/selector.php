<div class="table" style="width:800px;margin:0 auto;">
<?php
$attributes = array('id' => 'id-form', 'class' => 'form-horizontal');
echo form_open_multipart(base_url().'admin/viviendas/vvdas', $attributes);?>
<fieldset>
            <legend>Filtro de viviendas</legend>
            <div class="row">

                <div class="col-xs-3">Barrio:
                  <select name="barrio" class="form-control">
<?php foreach ($barrios as $ba) {

	?>

		                        <option value="<?php echo $ba->id;?>">( <?php echo $ba->codigo;?> ) <?php echo $ba->nombre;
	?></option>
	<?php }?>
</s
                </div>
            </div>
            <div class="row">





                <div class="col-xs-4">
                     <div class="control-group">
                        <label class="control-label" for="input01">&nbsp;</label>
                        <div class="controls">
                            <input type="hidden" name="submit" value="Guardar">
                            <button type="submit" class="btn btn-primary">Listar</button>
                        </div>
                      </div>
                </div>

            </div>
    </fieldset>
<?php echo form_close();?>
</div>

