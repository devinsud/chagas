<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formularios_front extends CI_Controller {

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
        $this->load->model('formulario');
        $this->load->model('sede');
        $this->load->model('proyecto');
        $this->load->model('user');
        $this->load->model('informe');
    }

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "formularios";
        $data['menu_top'] = 'menu_user';
        $data['listado'] = 'front/listado_forms';
        $usr = $this->user->get_user($this->session->userdata('id'));

        $args = array('tabla' => 'formularios', 'campo_orden' => 'id', 'dir_orden' => 'asc', 'campo_where' => 'id_sede', 'valor_where' => $usr->sede);
        $data['items'] = $this->varios->getItems($args);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));


        $this->load->view('admin/admin', $data);
    }

    public function edit_dato() {
        $datos = $this->input->post();
        $user = $this->formulario->getUsuarioActual();

        $this->db->where('id', $datos['row_id']);
        $res = $this->db->get('datos')->result();
        $cant = 0;
        $data = json_decode($res[0]->datos);
        foreach ($data as $key => $value) {
            $cant++;
            if ($cant == $datos['column']) {

                $data->$key = $datos['value'];
            }
        }
        $this->db->where('id', $datos['row_id']);
        if (is_array($user)) {
            $editado_por = $user['apellido'] . ', ' . $user['nombre'];
        } else {
            $editado_por = $user->apellido . ', ' . $user->nombre;
        }
        $args = array('datos' => json_encode($data), 'editado_por' => $editado_por);
        $this->db->update('datos', $args);
        echo $datos['value'];
    }

    public function formu($id = 0) {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post();

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            $this->form_validation->set_rules('ciclo', 'Ciclo', 'trim|required');
            $this->form_validation->set_rules('barrio', 'Barrio', 'trim|required');
            $this->form_validation->set_rules('fecha', 'Fecha', 'trim|required');
            $this->form_validation->set_rules('lote', 'Lote', 'trim|required');
            $this->form_validation->set_rules('manzana', 'Manzana', 'trim|required');
            if ($this->form_validation->run() === FALSE) { //si tiene errores
                $data = array();
                $data['config'] = $this->config_editor;
                $admin = $this->user->is_admin($this->session->userdata('id'));
                $data['menusel'] = "formularios";
                $data['menu_top'] = 'menu_user';

                //$data['listado'] = 'admin/formularios/tf';
                $data['usuario'] = $this->formulario->getUsuarioActual();
                $data['listado'] = 'front/forms';
                $args = array('tabla' => 'formularios', 'campo' => 'id', 'valor' => $id);
                $data['item'] = $this->varios->getItem($args);
                $args1 = array('tabla' => 'datos', 'campo_where' => 'id_form', 'valor_where' => $id, 'campo_orden' => 'id', 'dir_orden' => 'asc');
                $data['datos'] = $this->varios->getItems($args1);
                $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
                $this->load->view('admin_formu', $data);
            } else {

                $this->formulario->carga_de_datos();
                $this->session->set_flashdata('message', 'Los datos se han grabado satisfactoriamente');
            }
            redirect(base_url() . 'formularios_front/formu/' . $u['id'], 'location');
        } else {
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "formularios";
            $data['menu_top'] = 'menu_user';
            $data['sede'] = $this->informe->getSedeByFormId($id);
            $data['usuario'] = $this->formulario->getUsuarioActual();
            $data['listado'] = 'front/forms';
            $args = array('tabla' => 'formularios', 'campo' => 'id', 'valor' => $id);
            $data['item'] = $this->varios->getItem($args);
            $args1 = array('tabla' => 'datos', 'campo_where' => 'id_form', 'valor_where' => $id, 'campo_orden' => 'id', 'dir_orden' => 'desc');
            $data['datos'] = $this->varios->getItems($args1);
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin_formu', $data);
        }
    }

}

//class end bracket

