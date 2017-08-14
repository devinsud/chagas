<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Descargas extends MY_Controller {

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
        $this->load->model('descarga');
    }

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "descargas";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/descargas/listado';

        $data['col_derecha'] = 'admin/descargas/col_derecha';
        $data['items'] = $this->descarga->get_descargas();

        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admin', $data);
    }

    public function borra($id) {
        $args = array('tabla' => 'descargas', 'campo' => 'id', 'valor' => $id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'el registro de la descarga ha sido eliminado');
        redirect(base_url() . 'admin/sitios/index', 'location');
    }

}
