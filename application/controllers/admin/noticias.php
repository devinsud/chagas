<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Noticias extends MY_Controller {
    
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

        
    }

    /*
    Index de noticias muestra en un listado todas las noticias en forma cronologica
     */
    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "noticias";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/noticias/listado';
        $data['col_derecha'] = 'admin/noticias/col_derecha';
        $args = array('tabla'=>'noticias','campo_orden'=>'id','dir_orden'=>'asc');
        $data['sitios'] = $this->noticia->getAllCanales();
        $data['items'] = $this->varios->getItems($args);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admins', $data);
    }

    /*
    getAllCanales

    Output: JSON conteniendo todos los canales
     */
    public function getAllCanales(){
        
           $canales =  $this->noticia->getAllCanales();
            echo json_encode($canales);
    }


    /*
        Crea
        Es la funcion de creacion de nuevas noticias
        recibe los datos via post, si se le envio datos los guarda sino 
        arma el formulario de creacion

     */
    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->noticia->registro($u);
            $this->session->set_flashdata('message', 'La noticia se ha creado satisfactoriamente');
            redirect(base_url() . 'admin/noticias/index', 'location');
        } else {
            
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "noticias";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/noticias/form';
            $data['col_derecha'] = 'admin/noticias/col_derecha';
            $args = array('tabla'=>'noticias','campo_orden'=>'id','dir_orden'=>'asc');
            $data['secciones'] = $this->varios->getItems($args);
            
            
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin_noticias', $data);
        }
    }

    /*
       
        Edita
               Es la funcion de edicion noticias
        recibe los datos via post, si se le envio datos los guarda sino 
        arma el formulario de creacion

     */
    public function edita($id=0) {
     $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->noticia->edicion($u);
            $this->session->set_flashdata('message', 'La noticia se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/noticias/index', 'location');
        } else {
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "noticias";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/noticias/form_edit';
            $data['col_derecha'] = 'admin/noticias/col_derecha';
            $args=array('tabla'=>'noticias','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $args = array('tabla'=>'noticias','campo_orden'=>'id','dir_orden'=>'asc');
            $data['secciones'] = $this->varios->getItems($args);
           
          
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    /*
       
        EditaAlVuelo
               Es la funcion de edicion noticias via ajax en la edicion rapida
        recibe los datos via post, si se le envio datos los guarda sino 
        arma el formulario de creacion

     */
    public function editaAlVuelo($id=0) {
     $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->noticia->edicionAlVuelo($u);
            $this->session->set_flashdata('message', 'La noticia se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/noticias/index', 'location');
        } else {
            
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "noticias";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/noticias/form_edit';
            $data['col_derecha'] = 'admin/noticias/col_derecha';
            $args=array('tabla'=>'noticias','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $args = array('tabla'=>'noticias','campo_orden'=>'id','dir_orden'=>'asc');
            $data['secciones'] = $this->varios->getItems($args);
            $args = array('tabla'=>'galerias','campo_orden'=>'id','dir_orden'=>'asc');
            $data['galerias'] = $this->varios->getItemsForDropdown($args);
            $data['gals'] = explode(',',$data['item']->galerias);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }


    /*
    getNoticiaById
    Recibe un id tipo entero
    Devuelve: JSON con la noticia completa
     */
    public function getNoticiaById($id){
        $id_noticia = (int)$id;
        $noticia = $this->noticia->getNoticiaById($id_noticia);
        echo json_encode($noticia);
    }

    /*
    getImagenesByNoticiaId
    Recibe un id tipo entero
    Devuelve: JSON con las imagenes correspondientes a la noticia
     */
    public function getImagenesByNoticiaId($id){
        $id_noticia = (int)$id;
        $imagenes = $this->noticia->getImagenesByNoticiaId($id_noticia);
        echo json_encode($imagenes);
    }

    /*
        getNoticiasByEmpresa
        recibe un id tipo entero de empresa
        devuelve un JSON con todas las noticias para esa empresa
     */
    public function getNoticiasByEmpresa($empresa,$cant){
        $noticias = $this->noticia->getNoticiasByEmpresa((int)$empresa,(int)$cant);
        echo json_encode($noticias);
    }

    /*
        cambiaEstado
        recibe un id tipo entero de noticia
        suichea el estado entre activo e inactivo
     */
    public function cambiaEstado($id){
        $id_noticia = (int)$id;
        $estado = $this->noticia->cambiaEstado($id);
        echo $estado;
    }

    /*
    Borra
    Recine un entero, id de noticia y elimina la noticia
     */
    public function borra($id) {
        $args=array('tabla'=>'noticias','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la noticia ha sido eliminada');
        redirect(base_url() . 'admin/noticias/index', 'location');
    }


    public function sorting(){
        $submit = $this->input->post('submit');
         if ($submit != '') {
          $order=explode(',',$this->input->post('sarasa'));
          foreach ($order as $key => $value) {
               $data = array('orden'=>$key);
               $this->db->where('id',$value);
               $this->db->update('noticias',$data);
          }
           redirect(base_url() . 'admin/noticias/sorting/', 'refresh');
         }else{
        $data = array();
        $args = array(
            'tabla'=>'noticias', 
            'campo_orden'=>'orden', 
            'dir_orden'=>'asc',
            'campo_where'=>'id_seccion',
            'valor_where'=>0
            );
        $data['items'] = $this->varios->getItems($args);
        $admin = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "noticias";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/noticias/sorting';
        $data['col_derecha'] = 'admin/noticias/col_derecha';
        $this->load->view('admin/admin', $data);
        }
    }
    

    /*
    Imagenes

    arma el formulario para inclusion de imagenes a la noticia
     */
    public function imagenes($id=0){
         $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
        $args = array(
            'tabla'=>'assets_noticias', 
            'campo_orden'=>'id', 
            'dir_orden'=>'asc',
            'campo_where'=>'id_noticia',
            'valor_where'=>$id
            );
        $data['items'] = $this->varios->getItems($args);
        //var_dump($data['items']);die;
        $args=array('tabla'=>'noticias','campo'=>'id','valor'=>$id);
        $data['item'] = $this->varios->getItem($args);
        $admin = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "noticias";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/noticias/imagenes';
        $data['col_derecha'] = 'admin/noticias/col_derecha';
        $this->load->view('admin/admin', $data);
    }

    /*
    add_imagen
    funcion para agregar imagenes a una nota
    recibe datos via post
     */
    public function add_imagen(){
        $args = array(
            'path'=>'./assets/imagenes/',
            'ancho'=>900,
            'alto'=>300,
            'tabla'=>'assets_noticias',
            'campo'=>'id',
            'valor'=>0,
            'campos'=>array('epigrafe'=>'epigrafe','link'=>'link','id_noticia'=>'id_noticia')
        );
        $this->varios->addImage($args);
        $id = $this->input->post('id_noticia');
        $ahora = @date('Y-m-d H:i:s');
        $data = array('fecha_modificacion'=>$ahora);
        $this->db->where('id',(int)$id);
        $this->db->update('noticias',$data);
        redirect(base_url() . 'admin/noticias/imagenes/'.$this->input->post('id_noticia'), 'refresh');
    }

    
    public function importFromService1($empresa){
        $hoy = @date('d/m/Y');
        $fec =  explode('/',$hoy);
        $f1 = $fec[2].'-'.$fec[1].'-'.$fec[0];


        if($empresa == "capin"){
        $datos = file_get_contents('http://www.reporteinformativo.com.ar/web5/handlers/ExportJSon.ashx?UW=67920&Key=4C-2C-76-D4-45-5F-29-55&idClienteTema=38450&fecha='.$hoy);
        }
        $posts = json_decode( $datos);
        foreach($posts as $p){
            $this->db->where('id_externo', $p->Id);
            $cant = $this->db->count_all_results('noticias');
            if($cant == 0){
                $fec1 =  explode('/',$hoy);
                $f11 = $fec1[2].'-'.$fec1[1].'-'.$fec1[0];
                $agrega = array();
                $agrega = array('id_externo'=>$p->Id, 'fecha1'=> $f11,'empresa'=>$p->Tema,'fuente'=>$p->Fuente,'titulo'=>$p->Titulo, 'copete'=>$p->Copete, 'texto'=>$p->Texto, 'creada_por'=>'Reporte Informativo', 'status'=>'inactivo', 'externo'=>1 );
                $agrega['imgs'] = '';
                foreach($p->Imagenes as $img){
                    $agrega['imgs'] .= ','.$img;
                }
                trim($agrega['imgs'],',');
                $this->db->insert('noticias',$agrega);
            }
        }
        redirect(base_url() . 'admin/noticias/index', 'location');
    }

    /*
    importFromService
    importa noticias desde reporte informativo
    recibe un id de empres ( codigo de proveedor )
    almacena las noticias en una tabla de datos
     */
    public function importFromService($id){
        $hoy = @date('d/m/Y');
        $fec =  explode('/',$hoy);
        $f1 = $fec[2].'-'.$fec[1].'-'.$fec[0];
        $id_canal = (int)$id;
        $canal = $this->noticia->getSitio($id_canal);
        
        if($canal[0]->codigo_proveedor!=''){
        
            $datos = file_get_contents('http://www.reporteinformativo.com.ar/web5/handlers/ExportJSon.ashx?UW=67920&Key=4C-2C-76-D4-45-5F-29-55&idClienteTema='.$canal[0]->codigo_proveedor.'&fecha='.$hoy);
        }else{
            redirect(base_url() . 'admin/sitios/index', 'location');
            return false;
        }
        $posts = json_decode( $datos);
        foreach($posts as $p){
            $this->db->where('id_externo', $p->Id);
            $cant = $this->db->count_all_results('noticias');

            if($cant == 0){
                $fec1 =  explode('/',$hoy);
                $f11 = $fec1[2].'-'.$fec1[1].'-'.$fec1[0];
                $ahora = @date('Y-m-d H:i:s');
                $fecha_nota= $this->varios->fecha($p->Fecha);
                $admin = $this->get_user($this->session->userdata('id'));
                $agrega = array();
                $agrega = array('id_externo'=>$p->Id, 'fecha1'=> $fecha1,'empresa'=>$p->Tema,'fuente'=>$p->Fuente,'titulo'=>$p->Titulo, 'copete'=>$p->Copete, 'texto'=>$p->Texto,'fecha_creacion'=>$ahora, 'fecha_modificacion'=>$ahora, 'creada_por '=> ($admin->nombre.' '.$admin->apellido), 'externo'=>'RI',  'status'=>'inactivo', 'externo'=>1 );
                $agrega['imgs'] = '';
                foreach($p->Imagenes as $img){
                    $agrega['imgs'] .= ','.$img;
                }
                trim($agrega['imgs'],',');
                $this->db->insert('noticias',$agrega);
            }
        }
        redirect(base_url() . 'admin/noticias/index', 'location');
    }

}

