<?php

class Eventos extends MY_Controller {

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
    }

    function index() {
        $data['menusel'] = "eventos";
        $data['title'] = "Administracion de eventos";
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));

        $data['col_derecha'] = 'admin/galerias/col_derecha';
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = "admin/eventos/listado";
        $data['eventos'] = $this->evento->getAllEvents();

        $this->load->vars($data);
        $this->load->view('admin/admin_ancho');
    }

    function changeState($id) {
        $this->varios->changeState($id, 'eventos');

        $this->session->set_flashdata('message', 'Status cambiado');
        redirect(base_url() . 'admin/eventos/index', 'refresh');
    }

    function crear() {
        if ($this->input->post('submit')) {
            $data = array(
                'titulo' => $this->input->post('titulo'),
                'lugar' => $this->input->post('lugar'),
                'texto' => $this->input->post('texto'),
                'fecha_inicio' => $this->input->post('fecha_inicio'),
                'fecha_fin' => $this->input->post('fecha_fin')
            );


            $this->evento->insert_data($data);
            $this->session->set_flashdata('message', 'evento creado');
            redirect(base_url() . 'admin/eventos/index', 'refresh');
        } else {
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $data['menusel'] = "eventos";
            $data['title'] = "Administracion de eventos";
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));

            $data['col_derecha'] = 'admin/galerias/col_derecha';
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = "admin/eventos/form";
            $this->load->vars($data);
            $this->load->view('admin/admin_ancho');
        }
    }

    function delete($id = null) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('id');
            $this->evento->delite_data($id);
            $this->session->set_flashdata('message', 'evento eliminado');
            redirect(base_url() . 'admin/eventos/index', 'refresh');
        } else {
            $data['title'] = "Eliminar evento";
            $data['main'] = 'admin/eventos/admin_eventos_delete';
            $data['evento'] = $this->MEvents->getEvent($id);
            $this->load->vars($data);
            $this->load->view('admin/dashboard');
        }
    }

    function edit($id = null) {
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;
        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
        $data = array();
        if ($this->input->post('submit')) {
            $data = array(
                'id' => $this->input->post('id'),
                'titulo' => $this->input->post('titulo'),
                'lugar' => $this->input->post('lugar'),
                'texto' => $this->input->post('texto'),
                'fecha_inicio' => $this->input->post('fecha_inicio'),
                'fecha_fin' => $this->input->post('fecha_fin')
            );
            $this->evento->edit_data($data);
            $this->session->set_flashdata('message', 'evento modificado');
            redirect(base_url() . 'admin/eventos/index', 'refresh');
        } else {
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $data['menusel'] = "eventos";
            $data['title'] = "Administracion de eventos";
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $data['col_derecha'] = 'admin/galerias/col_derecha';
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = "admin/eventos/form_edit";
            $data['evento'] = $this->evento->getEvent($id);
            $this->load->vars($data);
            $this->load->view('admin/admin_ancho');
        }
    }

}

?>
