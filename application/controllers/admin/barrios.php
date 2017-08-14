<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barrios extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('barrio');
    }

    /**
     * [index Listado de barrios]
     * @return [view] 
     */
    public function index() {

        $data = array();
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menusel'] = "barrios";
        $data['menu_top'] = $this->menu;
        $data['listado'] = 'admin/barrios/listado';
        $args = array('tabla' => 'barrios', 'campo_orden' => 'id_sede', 'dir_orden' => 'asc');
        $data['items'] = $this->varios->getItems($args);
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [crea alta de barrios]
     * @return [view] 
     */
    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->barrio->registro($u);
            $this->session->set_flashdata('message', 'El barrio se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/barrios/index', 'location');
        } else {
            $data = array();
            $data['admin'] = $this->admin;
            $data['menusel'] = "barrios";
            $data['menu_top'] = $this->menu;
            $data['listado'] = 'admin/barrios/form';
            $args = array('tabla' => 'sedes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
            $data['sedes'] = $this->varios->getItems($args);
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [edita modificacion de barrios]
     * @param  integer $id 
     * @return [view]
     */
    public function edita($id = 0) {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->barrio->edicion($u);
            $this->session->set_flashdata('message', 'El barrio se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/barrios/index', 'location');
        } else {
            $data = array();
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "barrios";
            $data['admin'] = $this->admin;
            $data['menu_top'] = $this->menu;
            $data['listado'] = 'admin/barrios/form_edit';
            $args = array('tabla' => 'barrios', 'campo' => 'id', 'valor' => $id);
            $data['item'] = $this->varios->getItem($args);
            $args = array('tabla' => 'sedes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
            $data['sedes'] = $this->varios->getItems($args);
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [cambiaEstado cambia el estado del barrio de activo a inactivo para participar o no de los informes]
     * @param  integer $id
     * @return [void]
     */
    public function cambiaEstado($id) {
        $id = (int) $id;
        $estado = $this->barrio->estado($id);
        redirect(base_url() . 'admin/barrios/index', 'location');
    }

    /**
     * [borra elimina un barrio]
     * @param  integer $id [description]
     * @return [void]
     */
    public function borra($id) {
        $id = (int) $id;
        $args = array('tabla' => 'barrios', 'campo' => 'id', 'valor' => $id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'el barrio ha sido eliminado');
        redirect(base_url() . 'admin/barrios/index', 'location');
    }

    /**
     * [getBarrioById devuelve barrio por id y por sede]
     * @param  integer $id
     * @param  integer $sede
     * @return [json string]
     */
    public function getBarrioById($id = 0, $sede = 0) {
        $barrio = $this->barrio->getBarrioById($id, $sede);
        if ($barrio != 'no existe') {
            echo json_encode($barrio);
        } else {
            echo json_encode('no existe');
        }
    }

}

//class end bracket

