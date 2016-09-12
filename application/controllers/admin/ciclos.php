<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ciclos extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ciclo');
    }

    /**
     * [index listado de ciclos]
     * @return view
     */
    public function index() {
        
        $data = array();
        $data['admin'] = $this->admin; // vive en My_controller
        $data['menusel'] = "ciclos";
        $data['menu_top'] = $this->menu;
        $data['listado'] = 'admin/ciclos/listado';
        $args = array('tabla'=>'ciclos','campo_orden'=>'id_sede','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [crea alta de ciclos]
     * @return view
     */
    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $this->ciclo->registro();
            $this->session->set_flashdata('message', 'El ciclo se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/ciclos/index', 'location');
        } else {
            $data = array();
            $data['admin'] = $this->admin;
            $data['menusel'] = "ciclos";
            $data['menu_top'] = $this->menu;
            $data['listado'] = 'admin/ciclos/form';
            $args = array('tabla'=>'sedes','campo_orden'=>'id','dir_orden'=>'asc');
            $data['sedes'] = $this->varios->getItems($args);
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [edita modificacion]
     * @param  integer $id
     * @return view
     */
    public function edita($id=0) {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->ciclo->edicion($u);
            $this->session->set_flashdata('message', 'El barrio se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/ciclos/index', 'location');
        } else {
            $data = array();
            $data['admin'] = $this->admin;
            $data['menusel'] = "ciclos";
            $data['menu_top'] = $this->menu;
            $data['listado'] = 'admin/ciclos/form_edit';
            $args=array('tabla'=>'ciclos','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $args = array('tabla'=>'sedes','campo_orden'=>'id','dir_orden'=>'asc');
            $data['sedes'] = $this->varios->getItems($args);
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [borra baja]
     * @param  integer $id 
     * @return void
     */
    public function borra($id) {
        $id = (int)$id;
        $args=array('tabla'=>'ciclos','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'El ciclo ha sido eliminado');
        redirect(base_url() . 'admin/ciclos/index', 'location');
    }

    /**
     * [getCiclosBySede devuelve ciclos por sede]
     * @param  integer $id_sede
     * @return [type]          [description]
     */
    public function getCiclosBySede($id_sede){
        $id_sede = (int)$id_sede;
        $ciclos = $this->ciclos->getCiclosBySede($id_sede);
        return $ciclos;
    }
    
    

} //class end bracket

