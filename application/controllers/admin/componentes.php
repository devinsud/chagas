<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Componentes extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->config_editor = array();
        //indicamos la ruta para ckFinder
        $this->config_editor['filebrowserBrowseUrl'] = base_url() . "assets/ckeditor/kcfinder/browse.php";
        // indicamos la ruta para el boton de la toolbar para subir imagenes
        $this->config_editor['filebrowserImageBrowseUrl'] = base_url() . "assets/ckeditor/kcfinder/browse.php?type=images";
        // indicamos la ruta para subir archivos desde la pestaña de la toolbar (Quick Upload)
        $this->config_editor['filebrowserUploadUrl'] = base_url() . "assets/ckeditor/kcfinder/upload.php?type=files";
        // indicamos la ruta para subir imagenesdesde la pestaña de la toolbar (Quick Upload)
        $this->config_editor['filebrowserImageUploadUrl'] = base_url() . "assets/ckeditor/kcfinder/upload.php?type=images";
        $this->config_editor['toolbar'] = array(
            array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'),
            array('Image', 'Link', 'Unlink', 'Anchor')
        );
        $this->load->model('componente');
    }

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "componentes";
        $data['menu_top'] = 'admin/menu_top';
        $data['listado'] = 'admin/componentes/listado';
        $args = array('tabla' => 'componentes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
        $data['items'] = $this->varios->getItems($args);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));


        $this->load->view('admin/admin', $data);
    }

    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {

            $this->componente->registro();
            $this->session->set_flashdata('message', 'El Componente se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/componentes/index', 'location');
        } else {
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "componentes";
            $data['menu_top'] = 'admin/menu_top';
            $data['listado'] = 'admin/componentes/form';
            $args = array('tabla' => 'componentes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
            $data['secciones'] = $this->varios->getItems($args);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function edita($id = 0) {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->componente->edicion($u);
            $this->session->set_flashdata('message', 'El Componente se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/sitios/index', 'location');
        } else {
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "fuentes";
            $data['menu_top'] = 'admin/menu_top';
            $data['listado'] = 'admin/fuentes/form_edit';
            $args = array('tabla' => 'fuentes', 'campo' => 'id', 'valor' => $id);
            $data['item'] = $this->varios->getItem($args);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function cambiaEstado($id) {
        $id_noticia = (int) $id;
        $estado = $this->noticia->cambiaEstado($id);
        echo $estado;
    }

    public function borra($id) {
        $args = array('tabla' => 'componentes', 'campo' => 'id', 'valor' => $id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'El componente ha sido eliminado');
        redirect(base_url() . 'admin/componentes/index', 'location');
    }

}

//class end bracket

