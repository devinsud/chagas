<h1><?php echo $title ?></h1>

<p><?php echo anchor(base_url() . "admin/eventos/crear", "Crear evento") ?></p>

<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
if (count($eventos)) {
    echo "<table border='1' cellspacing='0' cellpadding='4' width='820'>\n";
    echo " <tr valign='top'> \n";
    echo " <th> titulo</th><th>lugar</th><th>descript</th><th>fecha</th><th>horario</th><th>status</th><th>Cambia Estado </th><th> Edita </th><th>Borra</th> \n";
    echo " </tr> \n";
    foreach ($eventos as $key => $list) {

        echo " <tr valign='top'> \n";

        echo " <td> " . $list['titulo'] . " </td> \n";
        echo " <td> " . $list['lugar'] . " </td> \n";
        echo " <td> " . $list['texto'] . " </td> \n";
        echo " <td> " . $list['fecha_inicio'] . " </td> \n";
        echo " <td> " . $list['fecha_fin'] . " </td> \n";
        echo " <td> " . $list['status'] . " </td> \n";
        
       
        echo " <td align='center' > ";
        
        echo anchor(base_url() . 'admin/eventos/changeState/' . $list['id'], '<img src="'.base_url().'assets/img/edit-icon.gif" alt="cambiar estado" width="16" height="16" alt="" />');
        echo "</td><td align='center' > ";
        echo anchor(base_url() . 'admin/eventos/edit/' . $list['id'], '<img src="'.base_url().'assets/img/edit-icon.gif" alt="editar evento" width="16" height="16" alt="" />');
        echo " </td><td align='center' > ";
        echo anchor(base_url() . 'admin/eventos/delete/' . $list['id'], '<img src="'.base_url().'assets/img/hr.gif" width="16" height="16" alt="borrar evento" />');
        
        echo " </td>\n";
        echo " </tr>\n";
    }
    echo " </table> ";
    echo form_close();
}
?>

