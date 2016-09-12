<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class informes extends MY_Controller {
    
    public function __construct() {
        parent::__construct();        
        $this->load->model('formulario');
        $this->load->model('sede');
        $this->load->model('proyecto');
        $this->load->model('informe');
        $this->load->model('user');
        $this->load->model('lugar');
        $this->load->model('vivienda');
        $this->load->model('ciclo');
    }

    /**
     * [index muestra informes de la sede, sin parametros ]
     * @param  integer $id_sede
     * @return view
     */
    public function index($id_sede=0) {
        $id_sede                        = (isset($id_sede) && $id_sede>0)?(int)$id_sede:$this->input->post('id_sede');
        $data['admin']                  = $this->admin; //this admin vive en My_Controller
        $data['menu_top']               = $this->menu;
        //$usuario                        = $this->user->getUser($this->session->userdata('id'));
        $data['lugares']                = $this->lugar->getLugares();
        $data['lugares_intra']          = $this->lugar->getLugaresByType('intradomicilio');
        $data['lugares_peri']           = $this->lugar->getLugaresByType('peridomicilio');
        $data['ciclos']                 = $this->ciclo->getCiclosBySede($id_sede);
        $data['barrio']                 = (isset($_POST['barrios']))?$_POST['barrios']:'';
        $data['manzana']                = (isset($_POST['manzana']))?$_POST['manzana']:'';
        $data['zona']                   = (isset($_POST['zona']))?$_POST['zona']:'';
        $data['filtro_ciclos']          = (isset($_POST['filtro_ciclos']))?$_POST['filtro_ciclos']:'';
        
        $fechas                         = $this->informe->getFechaPrimeryUltimoDato('viviendas_inspeccion','fecha_inspeccion');
        $fechas['desde']                = (isset($_POST['desde']))?$_POST['desde']:'';
        $fechas['hasta']                = (isset($_POST['hasta']))?$_POST['hasta']:'';

        $data['hasta']                  = $fechas['hasta'];
        $data['desde']                  = $fechas['desde'];
        if($data['zona']!=''){
            $ciclos                     = $this->ciclo->getCiclosXTipo($data['zona']);
        }else{
            $ciclos                     = '';
        }
        
        $filtros                        = array(
                                            'id_sede'       => $id_sede,
                                            'barrio'        => $data['barrio'],
                                            'manzana'       => $data['manzana'],
                                            'desde'         => $fechas['desde'], 
                                            'hasta'         => $fechas['hasta'],
                                            'zona'          => $data['zona'],
                                            'ciclos'        => $ciclos,
                                            'filtro_ciclos'   => $data['filtro_ciclos']
                                        );
        $data['receptividad']           = $this->informe->getInformeReceptividad($filtros); 
        $data['positivas']              = $this->informe->getInfestadas($filtros);
        $data['viviendas_positivas']    = $this->vivienda->getPositivasAgrupadasyPorSede($filtros);
        $data['ambos']                  = $this->informe->getInfestaAmbos($data['lugares'],$filtros);
        
        $total_viviendas_relevadas      = count($this->vivienda->getViviendasRelevadasBySede($id_sede,$filtros));
        $data['total_viviendas_relevadas']=$total_viviendas_relevadas;
        $total_viviendas_sede           = $this->vivienda->getViviendasBySede($id_sede);
        $data['form'] = '';
        $data['ckey'] = '';

        $data['cobertura']              = round((($data['receptividad']['receptiva']/$total_viviendas_relevadas )*100), 2);
        $data['porLugar_intra']         = $this->informe->getByLugar('intradomicilio',$data['ambos'],$data['lugares_intra'],$filtros);
        $data['porLugar_peri']          = $this->informe->getByLugar('peridomicilio',$data['ambos'],$data['lugares_peri'],$filtros);


        $data['getCantViviendasInfectadas_peri']          = $this->informe->getCantViviendasInfectadas('peridomicilio',$data['ambos'],$data['lugares_peri'],$filtros);
        $data['getCantViviendasInfectadas_intra']         = $this->informe->getCantViviendasInfectadas('intradomicilio',$data['ambos'],$data['lugares_intra'],$filtros);
        
       
        $data['cant_infeccion_ambos']   = $this->informe->devuelveCant($data['ambos']); 
        $data['cant_infeccion_intra']   = $this->informe->devuelveCant($data['getCantViviendasInfectadas_intra']); 
       // $data['cant_infeccion_peri']    = $this->informe->devuelveCant($data['porLugar_peri']); 
        $data['cant_infeccion_peri']    = $this->informe->devuelveCant($data['getCantViviendasInfectadas_peri']); 

        $data['cant_infeccion_intra1']   = $this->informe->devuelveCant($data['getCantViviendasInfectadas_intra']); 
        
        $data['cant_infeccion_peri1']    = $this->informe->devuelveCant($data['getCantViviendasInfectadas_peri']); 

        $data['idi']                    = ($data['receptividad']['receptiva']>0)?round((($data['positivas']['totales']/$data['receptividad']['receptiva'])*100), 2):0;
        $data['idi_intra']              = ($data['receptividad']['receptiva']>0)?round((($data['cant_infeccion_intra']/$data['receptividad']['receptiva'])*100), 2):0;
        $data['idi_peri']               = ($data['receptividad']['receptiva']>0)?round((($data['cant_infeccion_peri']/$data['receptividad']['receptiva'])*100), 2):0;
        $data['idi_ambos']              = ($data['receptividad']['receptiva']>0)?round((($data['cant_infeccion_ambos']/$data['receptividad']['receptiva'])*100), 2):0;
        $data['menusel']                = "informes";
        $data['listado']                = 'admin/informes/informes';
        $data['sede']                   = $this->sede->getSedeId($id_sede);
        $data['barrios']                = $this->sede->getBarriosBySede($id_sede);
        $data['viviendas']              = $this->vivienda->getViviendasBySede($filtros);
        $this->load->view('admin/admin_info', $data);
    }


    /**
     * [informes_print muestra los distintos informes en un formato de impresion]
     * @param  integer $id_sede
     * @return view
     */
    public function informes_print($id_sede=0) {
        if(isset($id_sede) && $id_sede>0){
            $id_sede = (int)$id_sede;
        }else{
            $id_sede = $this->input->post('id_sede');

        }
        $usuario = $this->user->getUser($this->session->userdata('id'));
        $data['lugares'] = $this->lugar->getLugares();
        if(isset($_POST['desde']) && !is_null($_POST['desde'])){
            $data['desde']                          = $_POST['desde'];
            $data['hasta']                          = $_POST['hasta'];
            $data['barrio']                         = $_POST['barrios'];
            $data['ciclo_desde']                    = $_POST['ciclo_desde'];
            $data['ciclo_hasta']                    = $_POST['ciclo_hasta'];
            $data['receptividad']                   = $this->informe->getInformeReceptividad($data['barrio'],$data['desde'],$data['hasta'],$data['ciclo_desde'],$data['ciclo_hasta'] ); 
            $data['positivas']                      = $this->informe->getInfestadas($data['barrio'],$data['desde'],$data['hasta'],$data['ciclo_desde'],$data['ciclo_hasta'] ); 
            $data['porLugar']                       = $this->informe->getByLugar($data['lugares'],$id_sede,$data['barrio'],$data['desde'],$data['hasta'],$data['ciclo_desde'],$data['ciclo_hasta'] ); 
            if($data['positivas']['totales']>0){
                $data['idi']                        = round(($data['receptividad']['receptiva']/$data['positivas']['totales'])/100, 2);
            }else{
                $data['idi']                        = 0;
            }
            $data['cobertura']                      = round(($data['receptividad']['receptiva']/$data['receptividad']['totales'])/100, 2);
        }else{

            $fechas                                 = $this->informe->getFechaPrimeryUltimoDato('viviendas_inspeccion','fecha_inspeccion');
            $data['desde']                          = $fechas['desde'];
            $data['hasta']                          = $fechas['hasta'];
            $data['receptividad']                   = $this->informe->getInformeReceptividad(); 
            $data['positivas']                      = $this->informe->getInfestadas();
            if($data['positivas']['totales']>0){
                $data['idi']                        = round(($data['receptividad']['receptiva']/$data['positivas']['totales'])/100, 2);
            }else{
                $data['idi']                        = 0;
            }
            $data['cobertura']                      = round(($data['receptividad']['receptiva']/$data['receptividad']['totales'])/100, 2);
            $data['porLugar']                       = $this->informe->getByLugar($data['lugares'],$id_sede);
        }
        $data['menusel']                            = "informes";
        $data['menu_top']                           = 'admin/menu_top';
        $data['listado']                            = 'admin/informes/informes_print';
        $args                                       = array('tabla'=>'formularios','campo_orden'=>'id','dir_orden'=>'asc');
        $data['sede']                               = $this->sede->getSedeId($id_sede);
        $data['barrios']                            = $this->sede->getBarriosBySede($id_sede);
        $data['viviendas']                          = $this->vivienda->getViviendasBySede($id_sede);
        $data['items']                              = $this->varios->getItems($args);
        $data['admin']                              = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admin_informes_print', $data);
    }

    

    /**
     * [excel Recoge datos para mandarlos a excel]
     * @return [type] [description]
     */
    function excel(){
        $id         = (int)$this->input->post('id_form');
        $desde      = $this->input->post('fecha_desde');
        $hasta      = $this->input->post('fecha_hasta');
        $ciclo      = $this->input->post('ciclo');
        $data       = $this->informe->getDatosByIdForm($id,$desde,$hasta,$ciclo);
        $this->to_excel($data);
    }

    /**
     * [exportar_excel_vivienda exporta ya sea a excel o a dbf]
     * @param  [type] $id_sede [description]
     * @return [type]          [description]
     */
    function exportar_excel_vivienda($id_sede){
        $id             = (int)$id_sede;
        $barrio         = $this->input->post('barrios'); 
        $desde          = $this->input->post('desde_v');
        $hasta          = $this->input->post('hasta_v');
        $ciclo          = $this->input->post('ciclo_v');
        $data           = $this->informe->getViviendasPositivasExcel($id,$barrio,$desde,$hasta,$ciclo);
        if($this->input->post('submit')=="Exportar dbf"){
            $this->to_dbf($data);
        }else if($this->input->post('submit')=="Exportar excel"){
            $this->to_excel($data);
        }  
    }

    /**
     * [exportar_dbf_vivienda prepara los datos y los manda a el impresor dbf]
     * @return [type] [description]
     */
    function exportar_dbf_vivienda(){
        $id         = (int)$this->input->post('id_form');
        $barrio     = $this->input->post('barrios'); 
        $desde      = $this->input->post('desde_v');
        $hasta      = $this->input->post('hasta_v');
        $ciclo      = $this->input->post('ciclo_v');
        $data       = $this->informe->getViviendasPositivasExcel($id,$barrio,$desde,$hasta,$ciclo);
        $this->to_dbf($data);
    }

    /**
     * [to_excel parsear a excel]
     * @param  array $array    [description]
     * @param  string $filename [description]
     * @return excel file
     */
    function to_excel($array, $filename='out') {
        if(count($array)>0){
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
    }
    /**
     * [_writeRow escribe linea a linea del parseo]
     * @param  [type]  $row      [description]
     * @param  [type]  $h        [description]
     * @param  boolean $isHeader [description]
     * @return [type]            [description]
     */
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

    /**
     * [to_dbf_funca convierte el paquete de datos en dbf]
     * @return [type] [description]
     */
    function to_dbf_funca(){
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

function to_dbf($datos,$filename="datos_vivienda"){

    $ahora = @date('Y-m-d-h-i-s');
    $file = 'datos_vivienda'.$ahora;
    $db_file = '/var/www/chagas/assets/dbf/'.$file.'.dbf';
    
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
    //$db_file = '/tmp/datos_viviendas.dbf';
    
    $dbase_definition = array (
       array ('ID',  NUMBER_FIELD, 10, 1)  # string
       //array ('Criaderos',  NUMBER_FIELD, 5, 1)# boolean
    );
    
    # Records to insert into the dbf file   
    foreach($datos as $d){
        $datos_a_grabar[] = array($d['ID']);
    }
    
    # create dbf file using the
    $create = @ dbase_create($db_file, $dbase_definition)
       or die ("Could not create dbf file <i>$db_file</i>.");

    # open dbf file for reading and writing
    $id = @ dbase_open ($db_file, READ_WRITE)
       or die ("Could not open dbf file <i>$db_file</i>."); 
    foreach ($datos_a_grabar as $value) {
        dbase_add_record ($id, $value)
       or die ("Could not add record 'inari' to dbf file <i>$db_file</i>."); 
    }
    
    # find the number of fields (columns) and rows in the dbf file
    $num_fields = dbase_numfields ($id);
    $num_rows   = dbase_numrecords($id);
    /*
    print "dbf file <i>$db_file</i> contains $num_rows row(s) with $num_fields field(s) in each row.\n";

    # Loop through the entries in the dbf file
    for ($i=1; $i <= $num_rows; $i++) {
       print "\nRow $i of the database contains this information:<blockquote>";
       print_r (dbase_get_record_with_names ($id,$i));
       print "</blockquote>";
    } */

    # close the dbf file
    dbase_close($id);
    $this->descarga1($file);
}

    /**
     * [descarga1 descarga de archivos]
     * @param  [file $file [description]
     * @return [type]       [description]
     */
    public function descarga1($file){
        $dbfile = '/var/www/chagas/assets/dbf/'.$file.'.dbf';
        //$nombre = ltrim($dbfile,'/var/www/mundosano/assets/dbf/');
        if(!file_exists($dbfile)){
            die('El archivo no existe');
        }else{
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$file.dbf");
            header("Content-type: application/dbf");
            header("Content-Transfer-Encoding: binary");
            readfile($dbfile);
        }
    }

    /**
     * [to_dbf_recipientes dbf aplicados con otra estructura]
     * @param  [type] $datos    [description]
     * @param  string $filename [description]
     * @return [type]           [description]
     */
    function to_dbf_recipientes($datos,$filename="datos"){

        //header('Content-type: application/dbf');
        //header('Content-Disposition: attachment; filename=/tmp/'.$filename.'.dbf');
        $ahora = date('Y-m-d-h-i-s');
        $file = 'datos_recipientes'.$ahora;
        $db_file = '/var/www/mundosano/assets/dbf/'.$file.'.dbf';
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
        //$db_file = '/tmp/datos_recipientes.dbf';

        $dbase_definition = array (
           array ('ID',  NUMBER_FIELD, 10, 1),
           array ('A',  NUMBER_FIELD, 5, 1),
           array ('B',  NUMBER_FIELD, 5, 1),
           array ('C',  NUMBER_FIELD, 5, 1),
           array ('D',  NUMBER_FIELD, 5, 1),
           array ('E',  NUMBER_FIELD, 5, 1),
           array ('F',  NUMBER_FIELD, 5, 1),
           array ('G',  NUMBER_FIELD, 5, 1),
           array ('H',  NUMBER_FIELD, 5, 1)
        );
        
        # Records to insert into the dbf file   
        foreach($datos as $d){
            $datos_a_grabar[] = array($d['ID'],$d['A'],$d['B'],$d['C'],$d['D'],$d['E'],$d['F'],$d['G'],$d['H']);
        }
        
        # create dbf file using the
        $create = @ dbase_create($db_file, $dbase_definition)
           or die ("Could not create dbf file <i>$db_file</i>.");

        # open dbf file for reading and writing
        $id = @ dbase_open ($db_file, READ_WRITE)
           or die ("Could not open dbf file <i>$db_file</i>."); 
        foreach ($datos_a_grabar as $value) {
            dbase_add_record ($id, $value)
           or die ("Could not add record 'inari' to dbf file <i>$db_file</i>."); 
        }
        
        # find the number of fields (columns) and rows in the dbf file
        $num_fields = dbase_numfields ($id);
        $num_rows   = dbase_numrecords($id);
        /*
        print "dbf file <i>$db_file</i> contains $num_rows row(s) with $num_fields field(s) in each row.\n";

        # Loop through the entries in the dbf file
        for ($i=1; $i <= $num_rows; $i++) {
           print "\nRow $i of the database contains this information:<blockquote>";
           print_r (dbase_get_record_with_names ($id,$i));
           print "</blockquote>";
        } */

        # close the dbf file
        dbase_close($id);
        $this->descarga1($file);
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
/**
 * [informes creador de informes]
 * @param  integer $id [description]
 * @return [type]      [description]
 */
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

/**
 * [informes_print1 creador de pagina de impresion de informes]
 * @param  integer $id [description]
 * @return [type]      [description]
 */
function informes_print1($id = 0){
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

