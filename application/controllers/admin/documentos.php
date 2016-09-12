<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Documentos extends MY_Controller {
    
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

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "documentos";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/documentos/listado';
        $data['col_derecha'] = 'admin/documentos/col_derecha';
        $args = array('tabla'=>'documentos','campo_orden'=>'id','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admin', $data);
    }

    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            
            
            
            
            $this->documento->registro($u);
            $this->session->set_flashdata('message', 'La documento se ha creado satisfactoriamente');
            redirect(base_url() . 'admin/documentos/index', 'location');
        } else {
            
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "documentos";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/documentos/form';
            $data['col_derecha'] = 'admin/documentos/col_derecha';
            
            
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function edita($id=0) {
     $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            
            $this->documento->edicion($u);
            $this->session->set_flashdata('message', 'La documento se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/documentos/index', 'location');
        } else {
            
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "documentos";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/documentos/form_edit';
            $data['col_derecha'] = 'admin/documentos/col_derecha';
            $args=array('tabla'=>'documentos','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $args = array('tabla'=>'documentos','campo_orden'=>'id','dir_orden'=>'asc');
            $data['secciones'] = $this->varios->getItems($args);
            $args = array('tabla'=>'galerias','campo_orden'=>'id','dir_orden'=>'asc');
            $data['galerias'] = $this->varios->getItemsForDropdown($args);
            
            $data['gals'] = explode(',',$data['item']->galerias);
            
          // var_dump($data['gals']);die;
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function borra($id) {
         $args=array('tabla'=>'documentos','campo'=>'id','valor'=>$id);
        $item = $this->varios->getItem($args);
        
        if(is_file('./assets/imagenes/'.$item->link)){
            unlink('./assets/imagenes/'.$item->link);
        }
        
        $args=array('tabla'=>'documentos','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la documento ha sido eliminada');
        redirect(base_url() . 'admin/documentos/index', 'location');
    }
    
    public function sorting(){
        $submit = $this->input->post('submit');
         if ($submit != '') {
          $order=explode(',',$this->input->post('sarasa'));
          foreach ($order as $key => $value) {
               $data = array('orden'=>$key);
               $this->db->where('id',$value);
               $this->db->update('documentos',$data);
          }
           redirect(base_url() . 'admin/documentos/sorting/', 'refresh');
         }else{
        $data = array();
        $args = array(
            'tabla'=>'documentos', 
            'campo_orden'=>'orden', 
            'dir_orden'=>'asc',
            'campo_where'=>'id_seccion',
            'valor_where'=>0
            );
        $data['items'] = $this->varios->getItems($args);
       
        $admin = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "documentos";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/documentos/sorting';
        $data['col_derecha'] = 'admin/documentos/col_derecha';

        
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
            'tabla'=>'assets_documentos', 
            'campo_orden'=>'id', 
            'dir_orden'=>'asc',
            'campo_where'=>'id_documento',
            'valor_where'=>$id
            );
        $data['items'] = $this->varios->getItems($args);
        //var_dump($data['items']);die;
        $args=array('tabla'=>'documentos','campo'=>'id','valor'=>$id);
        $data['item'] = $this->varios->getItem($args);
        $admin = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "documentos";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/documentos/imagenes';
        $data['col_derecha'] = 'admin/documentos/col_derecha';

        
        $this->load->view('admin/admin', $data);
    }

    public function add_imagen(){
        $args = array(
            'path'=>'./assets/imagenes/',
            'ancho'=>900,
            'alto'=>300,
            'tabla'=>'assets_documentos',
            'campo'=>'id',
            'valor'=>0,
            'campos'=>array('copete'=>'copete','link'=>'link','id_documento'=>'id_documento')
            
            
            
        );
        
        
        
        $this->varios->addImage($args);
        redirect(base_url() . 'admin/documentos/imagenes/'.$this->input->post('id_documento'), 'refresh');
    }
    
    public function borra_imagen_rotador($id=0,$id_sec=0){
        $args=array('tabla'=>'assets_documentos','campo'=>'id','valor'=>$id);
        $item = $this->varios->getItem($args);
        
        if(is_file('./assets/imagenes/'.$item->path)){
            unlink('./assets/imagenes/'.$item->path);
        }
        $args=array('tabla'=>'assets_documentos','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la imagen ha sido eliminada');
        redirect(base_url() . 'admin/documentos/imagenes/'.$id_sec, 'location');
    }
    
    public function galeria($id=0){
        $data = array();
        $args = array(
            'tabla'=>'galeria_secciones', 
            'campo_orden'=>'id', 
            'dir_orden'=>'asc',
            'campo_where'=>'id_sec',
            'valor_where'=>$id
            );
        $data['items'] = $this->varios->getItems($args);
        $args=array('tabla'=>'secciones','campo'=>'id','valor'=>$id);
        $data['item'] = $this->varios->getItem($args);
        $admin = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "secciones";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/secciones/rotador';
        $data['col_derecha'] = 'admin/secciones/col_derecha';

        
        $this->load->view('admin/admin', $data);
    }
    

}

