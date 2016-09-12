<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sedes extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sede');
    }

    /**
     * [index listado de sedes]
     * @return [view] 
     */
    public function index() {
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['menusel'] = "sedes";
        $data['listado'] = 'admin/sedes/listado';
        $args = array('tabla'=>'sedes','campo_orden'=>'id','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [crea Formulario de Alta de sedes]
     * @return [view] 
     */
    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->sede->registro($u);
            $this->session->set_flashdata('message', 'La sede se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/sedes/index', 'location');
        } else {
            $data = array();
            $data['admin'] = $this->admin;
            $data['menusel'] = "sedes";
            $data['sede'] = 1;
            $data['menu_top'] =$this->menu;
            $data['listado'] = 'admin/sedes/form';
            $args = array('tabla'=>'sedes','campo_orden'=>'id','dir_orden'=>'asc');
            $data['secciones'] = $this->varios->getItems($args);
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [edita edicion de sedes]
     * @param  integer $id [id de la sede]
     * @return [view]
     */
    public function edita($id=0) {
     $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->sede->edicion($u);
            $this->session->set_flashdata('message', 'La sede se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/sedes/index', 'location');
        } else {
            $data = array();
            $data['admin'] = $this->admin;
            $data['menu_top'] =$this->menu;
            $data['menusel'] = "sedes";
            $data['listado'] = 'admin/sedes/form_edit';
            $args=array('tabla'=>'sedes','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [borra elimina una sede]
     * @param  integer $id [id de la sede]
     * @return [void]
     */
    public function borra($id) {
        $args=array('tabla'=>'sedes','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la sede ha sido eliminado');
        redirect(base_url() . 'admin/sedes/index', 'location');
    }

} //class end bracket

