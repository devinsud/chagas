<h1><?php echo $title;?></h1>
<?php
$data_titulo = array('name' => 'titulo', 'id' => 'titulo', 'size' => 60 ,'value' =>$evento['titulo']);
$data_lugar = array('name' => 'lugar', 'id' => 'lugar', 'size' => 60,'value' =>$evento['lugar']);
$data_descript = array('name' => 'descript', 'id' => 'descript' ,'rows'=>10,'cols'=>45,'value' =>$evento['descript']);
$data_fecha = array('name' => 'fecha', 'id' => 'post_date', 'size' => 10,'value' =>$evento['fecha']);
$data_inicio = array('name' => 'inicio', 'id' => 'inicio', 'size' => 10,'value' =>$evento['inicio']);


echo form_open_multipart(base_url().'admin/eventos/delete');
echo "<div id='panel'>";
            echo form_fieldset();
echo "<p><label for='titulo'>titulo</label><br/>";
echo form_input($data_titulo) . "</p>";
echo "<p><label for='lugar'>lugar</label><br/>";
echo form_input($data_lugar) . "</p>";
echo "<p><label for='descript'>description</label><br/>";
echo form_textarea($data_descript) . "</p>";
echo "<p><label for='fecha'>fecha</label><br/>";
echo form_input($data_fecha) . "</p>";
echo "<p><label for='inicio'>inicio</label><br/>";
echo form_input($data_inicio) . "</p>";
echo "<br><br>";


echo form_hidden('id',$evento['id'] );
echo form_submit('submit','eliminar evento');
echo form_close();
echo "<br><br>";
echo anchor(base_url()."admin/eventos/index","volver");
?>


