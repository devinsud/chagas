<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proyectos extends MY_Controller {
    
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
        $this->load->model('proyecto');
        $this->load->model('sede');

        
    }

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "proyectos";
        $data['menu_top'] = 'admin/menu_top';
        $data['listado'] = 'admin/proyectos/listado';
        $args = array('tabla'=>'proyectos','campo_orden'=>'id','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);
       //dump($data['items']);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));


        $this->load->view('admin/admin', $data);
    }

    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->proyecto->registro($u);
            $this->session->set_flashdata('message', 'El proyecto se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/proyectos/index', 'location');
        } else {
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "proyectos";
            $data['menu_top'] = 'admin/menu_top';
            $args = array('tabla'=>'sedes', 'campo_orden'=>'localidad', 'dir_orden'=>'asc', 'campo_titulo'=>'localidad');
            $data['sedes'] = $this->varios->getItemsForDropdown($args);
            $data['listado'] = 'admin/proyectos/form';
            $args = array('tabla'=>'proyectos','campo_orden'=>'id','dir_orden'=>'asc');
            $data['secciones'] = $this->varios->getItems($args);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }



    public function edita($id=0) {
     $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->proyecto->edicion($u);
            $this->session->set_flashdata('message', 'La proyecto se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/proyectos/index', 'location');
        } else {
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "proyectos";
            $data['menu_top'] = 'admin/menu_top';
            $data['listado'] = 'admin/proyectos/form_edit';
             $args = array('tabla'=>'sedes', 'campo_orden'=>'localidad', 'dir_orden'=>'asc', 'campo_titulo'=>'localidad');
            $data['sedes'] = $this->varios->getItemsForDropdown($args);
            $args=array('tabla'=>'proyectos','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            //dump($data['item']);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function cambiaEstado($id){
        $id_noticia = (int)$id;
        $estado = $this->noticia->cambiaEstado($id);
        echo $estado;
    }

    public function borra($id) {
        $args=array('tabla'=>'proyectos','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la proyecto ha sido eliminado');
        redirect(base_url() . 'admin/proyectos/index', 'location');
    }

    public function getProyectosBySede($sede){

        $this->db->where('id_sede',$sede);
        $query = $this->db->get('proyectos');
        $proyectos = array();
        if($query->result()){
            foreach ($query->result() as $proyecto) {
                $proyectos[$proyecto->id] = $proyecto->nombre;
            }
           header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($proyectos);
        } else {
            return FALSE;
        }
         
    }

} //class end bracket

