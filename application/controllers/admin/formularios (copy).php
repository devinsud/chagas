<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formularios extends MY_Controller {
    
    public function __construct() {
        parent::__construct();        
        $this->config_editor = array();
        //indicamos la ruta para ckFinder
        $this->config_editor['filebrowserBrowseUrl'] = base_url()."assets/ckeditor/kcfinder/browse.php";
        // indicamos la ruta para el boton de la toolbar para subir imagenes
        $this->config_editor['filebrowserImageBrowseUrl'] = base_url()."assets/ckeditor/kcfinder/browse.php?type=images";
        // indicamos la ruta para subir archivos desde la pestaña de la toolbar (Quick Upload)
        $this->config_editor['filebrowserUploadUrl'] = base_url()."assets/ckeditor/kcfinder/upload.php?type=files";
        // indicamos la ruta para subir imagenesdesde la pestaña de la toolbar (Quick Upload)
        $this->config_editor['filebrowserImageUploadUrl'] = base_url()."assets/ckeditor/kcfinder/upload.php?type=images";
        $this->config_editor['toolbar'] = array(
            array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'),
            array('Image', 'Link', 'Unlink', 'Anchor')
        );
        $this->load->model('formulario');
        $this->load->model('sede');
        $this->load->model('proyecto');
        $this->load->model('informe');

        
    }

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "formularios";
        $data['menu_top'] = 'admin/menu_top';
        $data['listado'] = 'admin/formularios/listado';
        $args = array('tabla'=>'formularios','campo_orden'=>'id','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admin', $data);
    }

    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->formulario->registro($u);
            $this->session->set_flashdata('message', 'El Formulario se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/formularios/index', 'location');
        } else {
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "formularios";
            $data['menu_top'] = 'admin/menu_top';
            $data['listado'] = 'admin/formularios/form';
             $args = array('tabla'=>'sedes', 'campo_orden'=>'localidad', 'dir_orden'=>'asc', 'campo_titulo'=>'localidad');
            $data['sedes'] = $this->varios->getItemsForDropdown($args);
            
            $args = array('tabla'=>'formularios','campo_orden'=>'id','dir_orden'=>'asc');
            $data['secciones'] = $this->varios->getItems($args);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function edita($id=0) {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->formulario->edicion($u);
            $this->session->set_flashdata('message', 'El formulario se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/formularios/index', 'location');
        } else {
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "formularios";
            $data['menu_top'] = 'admin/menu_top';
            $data['listado'] = 'admin/formularios/form_edit';
            $args = array('tabla'=>'sedes', 'campo_orden'=>'localidad', 'dir_orden'=>'asc', 'campo_titulo'=>'localidad');
            $data['sedes'] = $this->varios->getItemsForDropdown($args);
            $args1 = array('tabla'=>'proyectos', 'campo_orden'=>'nombre', 'dir_orden'=>'asc', 'campo_titulo'=>'nombre');
            $data['proyectos'] = $this->varios->getItemsForDropdown($args1);

             $args=array('tabla'=>'formularios','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function edit_dato(){
        $datos = $this->input->post();
        $user = $this->formulario->getUsuarioActual();
        
        $this->db->where('id',$datos['row_id']);
        $res = $this->db->get('datos')->result();
        $cant=0;
        $data = json_decode($res[0]->datos);
        foreach ($data as $key => $value) {
            $cant++;
            if($cant == $datos['column']){
                
                $data->$key = $datos['value'];
            }
        }
        $this->db->where('id',$datos['row_id']);
        if(is_array($user)){
            $editado_por = $user['apellido'].', '.$user['nombre'];
        }else{
            $editado_por = $user->apellido.', '.$user->nombre;
        }
        $args = array('datos' => json_encode($data), 'editado_por'=>$editado_por );
        $this->db->update('datos',$args);
        echo $datos['value'];
    }

    public function formu($id = 0){
         $submit = $this->input->post('submit');

        if ($submit == "Guardar") {
            $u = $this->input->post();

            $this -> load -> library( 'form_validation' );
            $this -> form_validation -> set_error_delimiters('<span class="error">', '</span>'); 
            $this -> form_validation -> set_rules( 'ciclo', 'Ciclo', 'trim|required' );
            $this -> form_validation -> set_rules( 'barrio', 'Barrio', 'trim|required' );
            $this -> form_validation -> set_rules( 'fecha', 'Fecha', 'trim|required' );
            $this -> form_validation -> set_rules( 'manzana', 'Manzana', 'trim|required' );
            if( $this->form_validation->run() === FALSE){ //si tiene errores
                 dump("con error");
                $data = array();
                $data['config'] = $this->config_editor;
                $admin = $this->user->is_admin($this->session->userdata('id'));
                $data['menusel'] = "formularios";
                $data['menu_top'] = 'admin/menu_top';
                //$data['listado'] = 'admin/formularios/tf';
                $data['listado'] = 'admin/formularios/testea_formulario';
                $args=array('tabla'=>'formularios','campo'=>'id','valor'=>$id);
                $data['item'] = $this->varios->getItem($args);
                $args1 = array('tabla'=>'datos','campo_where'=>'id_form','valor_where'=>$id,'campo_orden'=>'fecha_ingreso','dir_orden'=>'desc');
                $data['datos'] =$this->varios->getItems($args1);
                $data['form_id'] = $id;
                $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
                $this->load->view('admin/admin_formu', $data);
            }else{
                
                $this->formulario->carga_de_datos();
                $this->session->set_flashdata('message', 'Los datos se han grabado satisfactoriamente');
            }
            redirect(base_url() . 'admin/formularios/formu/'.$u['id'], 'location');

        } else {
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "formularios";
            $data['menu_top'] = 'admin/menu_top';
            $data['form_id'] = $id;
            //$data['listado'] = 'admin/formularios/tf';
            $data['listado'] = 'admin/formularios/testea_formulario';
            $data['sede'] = $this->informe->getSedeByFormId($id);
            $args=array('tabla'=>'formularios','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $args1 = array('tabla'=>'datos','campo_where'=>'id_form','valor_where'=>$id,'campo_orden'=>'fecha_ingreso','dir_orden'=>'desc');
            $data['datos'] =$this->varios->getItems($args1);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin_formu', $data);
        }
    }
    public function datos($id = 0){
         $submit = $this->input->post('submit');
        
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "formularios";
            $data['menu_top'] = 'admin/menu_top';
            //$data['listado'] = 'admin/formularios/tf';
            $data['form'] = (int)$id;
            $data['listado'] = 'admin/formularios/datos_formulario';
            $args=array('tabla'=>'formularios','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $args1 = array('tabla'=>'datos','campo_where'=>'id_form','valor_where'=>$id,'campo_orden'=>'id','dir_orden'=>'asc');
            $data['datos'] =$this->varios->getItems($args1);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin_formu', $data);
        
    }


    public function cambiaEstado($id){
        $id_noticia = (int)$id;
        $estado = $this->noticia->cambiaEstado($id);
        echo $estado;
    }

    public function borra($id) {
        $args=array('tabla'=>'formularios','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la sede ha sido eliminado');
        redirect(base_url() . 'admin/formularios/index', 'location');
    }

    function excel(){
        $id = (int)$this->input->post('id_form');

        $desde = $this->input->post('fecha_desde');
        $hasta = $this->input->post('fecha_hasta');
        $ciclo = $this->input->post('ciclo');
        //$datos = $this->evento->getAllEventsByDate($desde,$hasta);
       //dump($this->formulario->getDatosByIdForm($id));die;
        $data = $this->informe->getDatosByIdForm($id,$desde,$hasta,$ciclo);

        $this->to_excel($data);
    }

    function exportar_excel_vivienda(){
        $id = (int)$this->input->post('id_form');
        $barrio =$this->input->post('barrios'); 
        $desde = $this->input->post('desde_v');
        $hasta = $this->input->post('hasta_v');
        $ciclo = $this->input->post('ciclo_v');
       
            $data = $this->informe->getViviendasPositivasExcel($id,$barrio,$desde,$hasta,$ciclo);
        

        //$this->to_excel($data);
        $this->to_dbf($data);
    }

    function exportar_dbf_vivienda(){
        $id = (int)$this->input->post('id_form');
        $barrio =$this->input->post('barrios'); 
        $desde = $this->input->post('desde_v');
        $hasta = $this->input->post('hasta_v');
        $ciclo = $this->input->post('ciclo_v');
       
            $data = $this->informe->getViviendasPositivasExcel($id,$barrio,$desde,$hasta,$ciclo);
        

        
         $this->to_dbf($data);
    }
    function exportar_excel_recipiente(){
        $id = (int)$this->input->post('id_form');
        $desde = $this->input->post('desde');
        $hasta = $this->input->post('hasta');
        $barrio =$this->input->post('barrios'); 
        $ciclo = $this->input->post('ciclo_r');
        $data = $this->informe->getRecipientesPositivosExcel($id,$barrio,$desde,$hasta,$ciclo);
        $this->to_excel($data);
    }
    
    
    function to_excel($array, $filename='out') {
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');
        
        // Filter all keys, they'll be table headers
        $h = array();
        foreach($array as $row)
           
            foreach($row as $key=>$val)
                if(!in_array($key, $h)){
                    $h[] = $key;
                }
        
        echo '<table><tr>';
        foreach($h as $key) {
            $key = ucwords($key);
            echo '<th>'.$key.'</th>';
        }
        echo '</tr>';
        
        foreach($array as $val)
            $this->_writeRow($val, $h);
        
        echo '</table>';
    }

function _writeRow($row, $h, $isHeader=false) {
        echo '<tr>';
        foreach($h as $r) {
            if($isHeader)
                echo '<th>'.utf8_decode(@$row[$r]).'</th>';
            else
                echo '<td>'.utf8_decode(@$row[$r]).'</td>';
        }
        echo '</tr>';
}
function test(){
    echo "Gestores de DBA disponibles:\n";
    foreach (dba_handlers(true) as $nombre_gestor => $versión_gestor) {
      // limpiar las versiones
      $versión_gestor = str_replace('$', '', $versión_gestor);
      echo " - $nombre_gestor: $versión_gestor\n";
    }
}
function to_dbf(){
    # Constants for dbf field types
    define ('BOOLEAN_FIELD',   'L');
    define ('CHARACTER_FIELD', 'C');
    define ('DATE_FIELD',      'D');
    define ('NUMBER_FIELD',    'N');

    # Constants for dbf file open modes
    define ('READ_ONLY',  '0');
    define ('WRITE_ONLY', '1');
    define ('READ_WRITE', '2');

    # Path to dbf file
    $db_file = '/tmp/sushi_eaten.dbf';

    # dbf database definition
    # Each element in the first level of the array represents a row
    # Each array stored in the various elements represent the properties for the row
    $dbase_definition = array (
       array ('name',  CHARACTER_FIELD,  20),  # string
       array ('date',  DATE_FIELD),            # date yyymmdd
       array ('desc',  CHARACTER_FIELD,  45),  # string
       array ('cost',  NUMBER_FIELD, 5, 2),    # number (length, precision)
       array ('good?', BOOLEAN_FIELD)          # boolean
    );

    # Records to insert into the dbf file   
    $inari = array ('Inari', 19991231, 'Deep-fried tofu pouches filled with rice.', 1.00, TRUE);
    $unagi = array ('Unagi', 19991231, 'Freshwater Eel', 2.50, FALSE);

    # create dbf file using the
    $create = @ dbase_create($db_file, $dbase_definition)
       or die ("Could not create dbf file <i>$db_file</i>.");

    # open dbf file for reading and writing
    $id = @ dbase_open ($db_file, READ_WRITE)
       or die ("Could not open dbf file <i>$db_file</i>."); 

    dbase_add_record ($id, $inari)
       or die ("Could not add record 'inari' to dbf file <i>$db_file</i>."); 
        
    dbase_add_record ($id, $unagi)
       or die ("Could not add record 'unagi' to dbf file <i>$db_file</i>."); 

    # find the number of fields (columns) and rows in the dbf file
    $num_fields = dbase_numfields ($id);
    $num_rows   = dbase_numrecords($id);

    print "dbf file <i>$db_file</i> contains $num_rows row(s) with $num_fields field(s) in each row.\n";

    # Loop through the entries in the dbf file
    for ($i=1; $i <= $num_rows; $i++) {
       print "\nRow $i of the database contains this information:<blockquote>";
       print_r (dbase_get_record_with_names ($id,$i));
       print "</blockquote>";
    } 

    # close the dbf file
    dbase_close($id);
}
function to_dbf2(){
    
        $this->load->library('dba');    
        $dba = new DBA("/var/www/mundosano/assets/dbf/test.ini"); //Crea una instancia del objeto
        
        $dba->GuardarRegistro ("clave_nueva", "valor_nuevo"); //Guarda un nuevo registro en el archivo
        print "Valor nuevo de la clave: ".$dba->ObtenerValor ("clave_nueva"); //Obtiene el valor de un dato ingresando su clave
        
        $array = $dba->ObtenerTodos (); //Obtiene un array con todas las claves y sus valores
        
        print "<br><br><b>CLAVES Y VALORES</b>";
        foreach ($array as $k => $v) //Recorre el array mostrando los valores
        {
            print "<br>Clave: ".$k." Valor: ".$v;           
        }
        
        print "<br><br><b>GESTORES DISPONIBLES EN SU SERVIDOR: </b><br>";
        foreach ($dba->GestoresDisponibles() as $v)
        {
            print "<br>$v";
        }
}

function to_dbf1($array,$filename='test'){
    error_reporting(-1);
    $this->load->library('dba');
       //header('Content-type: application/dbf');
       //header('Content-Disposition: attachment; filename='.$filename.'.db4');
        $def = array(
          array("ID",     "N",10,0),
          array("M1",     "N",5,0)
        );

// creation
    $srcfile='/var/www/mundosano/assets/dbf/test.dbf';
    
        $dba = new DBA(); //Crea una instancia del objeto
        $dba->path_file = $srcfile;
        foreach ($array as $da)
        {
            foreach($da as $key=>$value){
            
                $dba->GuardarRegistro($key,$value);
            }
        }
        //$dba->GuardarRegistro ("clave_nueva", "valor_nuevo"); //Guarda un nuevo registro en el archivo
        //print "Valor nuevo de la clave: ".$dba->ObtenerValor ("clave_nueva"); //Obtiene el valor de un dato ingresando su clave
        
        $array1 = $dba->ObtenerTodos (); //Obtiene un array con todas las claves y sus valores
        
        print "<br><br><b>CLAVES Y VALORES</b>";
        foreach ($array1 as $k => $v) //Recorre el array mostrando los valores
        {
            print "<br>Clave: ".$k." Valor: ".$v;           
        }
        
       /* print "<br><br><b>GESTORES DISPONIBLES EN SU SERVIDOR: </b><br>";
        foreach ($dba->GestoresDisponibles() as $v)
        {
            print "<br>$v";
        }*/
    /*$dba = new DBA();
    
        
           
    foreach ($array as $da)
    {
        foreach($da as $key=>$value){
        dump($key .' => '.$value);
        $dba->GuardarRegistro($key,$value);
        }
    }
    */

           
                
}

function informes($id = 0){
    $u = $this->input->post();
    $data = array();
    $data['config'] = $this->config_editor;
    $admin = $this->user->is_admin($this->session->userdata('id'));
    $data['menusel'] = "formularios";
    $data['menu_top'] = 'admin/menu_top';
    $data['form'] = (int)$id;
    $data['listado'] = 'admin/formularios/informes'; 
    $barrio = (isset($u['barrios']))?$u['barrios']:'';
    $desde = (isset($u['desde']))?$u['desde']:'';
    $hasta = (isset($u['hasta']))?$u['hasta']:'';
    $ciclo = (isset($u['ciclo']))?$u['ciclo']:'';
    $ciclo_r =(isset($u['ciclo_r']))?$u['ciclo_r']:'';
    $ciclo_v =(isset($u['ciclo_v']))?$u['ciclo_v']:'';
    $id_form = (isset($u['id_form']))?$u['id_form']:$id; 
    $data['desde'] = $desde;
    $data['hasta'] = $hasta;
    $data['barrio'] = $barrio;
    $data['ciclo'] =$ciclo;
    $data['ciclo_v'] =$ciclo_v;
    $data['ciclo_r'] =$ciclo_r;

    $data['sede'] = $this->informe->getSedeByFormId($id);
    $args_barrios= array('tabla'=>'barrios', 'campo_orden'=>'nombre','campo_where'=>'id_sede','valor_where'=>$data['sede']->id, 'dir_orden'=>'asc', 'campo_titulo'=>'nombre' );
    $data['barrios'] = $this->varios->getItemsForDropdown($args_barrios);
    
    $data['inf'] = $this->informe->getInformes($id_form,$barrio,$desde,$hasta,$ciclo);
    
    $data['viviendas'] = json_decode($this->informe->getInformesViviendas($id_form,$barrio,$desde,$hasta,$ciclo));
    
    $data['datos'] = $this->informe->getViviendasPositivas($id_form,$barrio,$desde,$hasta,$ciclo);
    $args=array('tabla'=>'formularios','campo'=>'id','valor'=>$id);
    $data['item'] = $this->varios->getItem($args);
    $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
    $this->load->view('admin/admin_informes', $data);
}

function informes_print($id = 0){
    $u = $this->input->post();
    $data = array();
    $data['config'] = $this->config_editor;
    $admin = $this->user->is_admin($this->session->userdata('id'));
    $data['menusel'] = "formularios";
    $data['menu_top'] = 'admin/menu_top';
    $data['form'] = (int)$id;
    $data['listado'] = 'admin/formularios/informes_print'; 
    $barrio = (isset($u['barrios']))?$u['barrios']:'';
    $desde = (isset($u['desde']))?$u['desde']:'';
    $hasta = (isset($u['hasta']))?$u['hasta']:'';
    $ciclo = (isset($u['ciclo']))?$u['ciclo']:'';
    $ciclo_r =(isset($u['ciclo_r']))?$u['ciclo_r']:'';
    $ciclo_v =(isset($u['ciclo_v']))?$u['ciclo_v']:'';
    $id_form = (isset($u['id_form']))?$u['id_form']:$id; 
    $data['desde'] = $desde;
    $data['hasta'] = $hasta;
    $data['barrio'] = $barrio;
    $data['ciclo'] =$ciclo;
    $data['ciclo_v'] =$ciclo_v;
    $data['ciclo_r'] =$ciclo_r;

    $data['sede'] = $this->informe->getSedeByFormId($id_form);
    $args_barrios= array('tabla'=>'barrios', 'campo_orden'=>'nombre','campo_where'=>'id_sede','valor_where'=>$data['sede']->id, 'dir_orden'=>'asc', 'campo_titulo'=>'nombre' );
    $data['barrios'] = $this->varios->getItemsForDropdown($args_barrios);
    $data['viviendas'] = json_decode($this->informe->getInformesViviendas($id_form,$barrio,$desde,$hasta,$ciclo));
    $data['inf'] = $this->informe->getInformes($id_form,$barrio,$desde,$hasta,$ciclo);
    $data['datos'] = $this->informe->getViviendasPositivas($id_form,$barrio,$desde,$hasta,$ciclo);
    $args=array('tabla'=>'formularios','campo'=>'id','valor'=>$id);
    $data['item'] = $this->varios->getItem($args);
    $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
    $this->load->view('admin/admin_informes_print', $data);
}




} //class end bracket

