
<div class="top-bar">
  
    <h1>Servicos</h1>
   
</div>

<?php
if ($this->session->flashdata('message')) {
    echo "<div class='message'>" . $this->session->flashdata('message') . "</div> ";
}
$hoy = @date('Y-m-d');
$dk = sha1('127.0.0.1qqwww.grupoinsud.comqq0000000002qq'.$hoy);
?>
<div class="table1">
   <table id='example1' class='display datatable' border='1' cellspacing='0' cellpadding='0' >
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Descripcion</th>
                <th>Link</th>
                
              

            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="nombreServicio">getListadoCompuesto</td>
                <td class="descripcion"> <p>El Servicio <strong>getListadoCompuesto</strong> recibe como parametro un apikey conformado de la siguiente manera ip+domainName+servicioNro+fecha y ese string es convertido a SHA1 </p>
                    <ul>
                        <li>ip es el ip del canal que consume el servicio ( ej: 192.168.0.1 )</li>
                        <li>domainName es la url del sitio que consume el servicio ( ej: www.grupoinsud.com )</li>
                        <li>el servicioNro es el id de canal</li>
                        <li>fecha es la fecha del dia de hoy </li>
                    </ul> 
                    <p> El servicio devolver&aacute; un JSON con todas las noticias asignadas al canal, propias y de los demas canales que le hayan sido  asignadas al mismo </p>
                </td>
                <td>
                    <a href="<?php echo base_url(); ?>servicios/getListadoCompuesto/<?php echo $dk; ?>" target="_blank">
                        <?php echo base_url(); ?>servicios/getListadoCompuesto/<?php echo $dk; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td>getNoticia</td>
                <td><p>El servicio <strong>getNoticia</strong></p> recibe 4 parametros :
                    
                    <ul>
                        <li>id_noticia es el id de la noticia en si</li>
                        <li>key es el hash descripto en el servicio anterior</li>
                        <li>ip es el pi del usuario que solicita esa noticia al medio</li>
                        <li>navegador es el navegador del usuario que solicita la noticia al medio</li>
                    </ul>
                    <p>y devuelve un JSON con la nota completa y almacena los datos del usuario solicitante en la tabla de estadisticas simples</p>

                </td>
                <td>


                    <a href="<?php echo base_url(); ?>servicios/getNoticia/2/<?php echo $dk; ?>/192.168.1.1/mozilla" target="_blank">
                        <?php echo base_url(); ?>servicios/getNoticia/2/<?php echo $dk; ?>/192.168.1.1/mozilla
                    </a>
                </td>
            </tr>
            <tr>
                <td>getFuenteByName</td>
                <td>
                    <p>El servicio <strong>getFuenteByName</strong> recibe como parametro un string con el nombre del medio, y devuelve un JSON con los datos del mismo, incluyendo las imagenes o logos que se le hayan asignado.<br>
                        el nombre del medio puede ser aproximado ya que se lo busca con un LIKE</p>
                </td>
                <td>
                    <a href="<?php echo base_url(); ?>servicios/getFuenteByName/nacion" target="_blank">
                        <?php echo base_url(); ?>servicios/getFuenteByName/nacion
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
    
</div>
