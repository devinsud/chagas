<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operadores extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('operador');
        $this->load->model('sede');
    }

    /**
     * [index listado de operadores de campo]
     * @param  integer $indice   [description]
     * @param  string  $criterio [description]
     * @return view
     */
    public function index($indice = 0, $criterio = '') {
        $data = array();
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['listado'] = 'admin/operadores/listado';
        $data['menusel'] = "operadores";
        $args_sedes = array('tabla' => 'sedes', 'campo_orden' => 'localidad', 'dir_orden' => 'asc', 'campo_titulo' => 'localidad');
        $data['sedes'] = $this->varios->getItemsForDropdown($args_sedes);
        $args = array('tabla' => 'operadores', 'campo_orden' => 'id_sede', 'dir_orden' => 'asc');
        $data['items'] = $this->varios->getItems($args);
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [crear alta operadores de campo]
     * @return view
     */
    public function crear() {
        $submit = $this->input->post('submit');
        if ($submit != '') {
            $u = $this->input->post('item');
            $this->operador->registro($u);
            $this->session->set_flashdata('message', 'El operador ha sido creado');
            redirect(base_url() . 'admin/operadores/index', 'location');
        }
        $data = array();
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['listado'] = 'admin/operadores/form';
        $args = array('tabla' => 'sedes', 'campo_orden' => 'localidad', 'dir_orden' => 'asc', 'campo_titulo' => 'localidad');
        $data['sedes'] = $this->varios->getItemsForDropdown($args);
        $data['menusel'] = "operadores";
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [editar modificacion operadores de campo]
     * @param  integer $id
     * @return view
     */
    public function editar($id = 0) {
        $submit = $this->input->post('submit');
        if ($submit != '') {
            $this->operador->editar();
            $this->session->set_flashdata('message', 'El operador ha sido actualizado');
            redirect(base_url() . 'admin/operadores/index', 'location');
        }
        $data['item'] = $this->operador->getOperador($id);
        $args = array('tabla' => 'sedes', 'campo_orden' => 'localidad', 'dir_orden' => 'asc', 'campo_titulo' => 'localidad');
        $data['sedes'] = $this->varios->getItemsForDropdown($args);
        $data['listado'] = 'admin/operadores/form_edit';
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['menusel'] = "operadores";
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [borrar baja operadores de campo]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function borrar($id) {
        $this->user->borrar_usuario($id);
        $this->session->set_flashdata('message', 'El usuario eliminado');
        redirect(base_url() . 'admin/usuarios', 'location');
    }

    /* Fin operadores */
}
