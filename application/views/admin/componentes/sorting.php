<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<style>
    #sortable {
        margin-bottom: 160px;
    }
   #sortable li{
       cursor: pointer;
       list-style: none;
       margin: 5px 5px 5px 5px;
   }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
  $(document).ready(function() {
    $("#sortable").sortable();
    var files= new Array();
     $(".li_or").each(function(index) {
     files[index]=$(this).attr("rel");
      });
     document.getElementById('files').value=files;
  });
  function send()
  {
     var files= new Array();
     $('.li_or').each(function(index) {
     files[index]=$(this).attr("rel");
      });
     document.getElementById('files').value=files;
  }
</script>
<?php

if (count($items)){
echo '<ul id="sortable" onmouseout="send()">';
   foreach ($items as $key => $value) {

              
                   echo '<li class="li_or" rel="'.$value->id.'" onclick="send()" style="padding:5px; border:1px solid #000;">';
                   //echo "<img src='".base_url()."assets/uploads/videos/".$value->thumb."'  width='80px' />";
                   echo $value->seccion;
                   echo '</li>';
              
        }
echo'</ul>';
echo '<br><br><br><br>';
  echo form_open_multipart( base_url().'admin/secciones/sorting/');
    echo '<input type="hidden" name="sarasa" value=""  id="files"/>';

    echo form_submit('submit','Ordenar');
    
    echo form_close();

        }
?>
