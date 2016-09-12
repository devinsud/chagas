<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitios extends MY_Controller {
    
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
        $this->load->model('sitio');

        
    }

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "sitios";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/sitios/listado';
        $data['col_derecha'] = 'admin/sitios/col_derecha';
        $args = array('tabla'=>'sitios','campo_orden'=>'id','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admin', $data);
    }

    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->sitio->registro($u);
            $this->session->set_flashdata('message', 'El sitio se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/sitios/index', 'location');
        } else {
            
          
            $data = array();
            $data['config'] = $this->config_editor;
            $data['canales'] = $this->noticia->getAllCanales();
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "sitios";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/sitios/form';
            $data['col_derecha'] = 'admin/sitios/col_derecha';
            $args = array('tabla'=>'sitios','campo_orden'=>'id','dir_orden'=>'asc');
            $data['secciones'] = $this->varios->getItems($args);
           
            
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function edita($id=0) {
     $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->sitio->edicion($u);
            $this->session->set_flashdata('message', 'La noticia se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/sitios/index', 'location');
        } else {
            $data = array();
            $data['canales'] = $this->noticia->getAllCanales();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "sitios";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/sitios/form_edit';
            $data['col_derecha'] = 'admin/noticias/col_derecha';
            $args=array('tabla'=>'sitios','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function getNoticiaById($id){
        $id_noticia = (int)$id;
        $noticia = $this->noticia->getNoticiaById($id_noticia);
        echo json_encode($noticia);


    }
    public function getImagenesByNoticiaId($id){
        $id_noticia = (int)$id;
        $imagenes = $this->noticia->getImagenesByNoticiaId($id_noticia);
        echo json_encode($imagenes);


    }


    public function getNoticiasByEmpresa($empresa,$cant){
        switch ($empresa) {
             case 'insud':
                 $id_empresa = 'Insud';
                 break;
             case 'solnatu':
                 $id_empresa = 'Solantu';
                 break;
             case 'capin':
                 $id_empresa = 'Capital Intelectual';
                 break;
             default:
                 $id_empresa = 'Insud';
                 break;
         } 

        
        $noticias = $this->noticia->getNoticiasByEmpresa($id_empresa,$cant);
        echo json_encode($noticias);
    }
    public function cambiaEstado($id){
        $id_noticia = (int)$id;
        $estado = $this->noticia->cambiaEstado($id);
        echo $estado;
    }

    public function borra($id) {
        $args=array('tabla'=>'sitios','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'el servidor ha sido eliminado');
        redirect(base_url() . 'admin/sitios/index', 'location');
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
        redirect(base_url() . 'admin/noticias/imagenes/'.$this->input->post('id_noticia'), 'refresh');
    }
    
    public function borra_imagen_rotador($id=0,$id_sec=0){
        $args=array('tabla'=>'assets_noticias','campo'=>'id','valor'=>$id);
        $item = $this->varios->getItem($args);
        if(is_file('./assets/imagenes/'.$item->path)){
            unlink('./assets/imagenes/'.$item->path);
        }
        $args=array('tabla'=>'assets_noticias','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la imagen ha sido eliminada');
        redirect(base_url() . 'admin/noticias/imagenes/'.$id_sec, 'location');
    }
    
    public function importFromService($empresa){
        $hoy = date('d/m/Y');
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

}

