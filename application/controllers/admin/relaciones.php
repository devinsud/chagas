<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relaciones extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('relacion');
    }

    /**
     * [index listado de relaciones]
     * @return view
     */
    public function index() {
        
        $data = array();
        $data['admin'] = $this->admin;
        $data['menu_top'] =$this->menu;
        $data['menusel'] = "relaciones";
        $data['listado'] = 'admin/relaciones/listado';
        $args = array('tabla'=>'relaciones_familiares','campo_orden'=>'id','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [crea alta de relaciones]
     * @return view
     */
    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $this->relacion->registro();
            $this->session->set_flashdata('message', 'La relaci&oacute;n se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/relaciones/index', 'location');
        } else {
            $data = array();
            $data['admin'] = $this->admin;
            $data['menu_top'] =$this->menu;
            $data['menusel'] = "relaciones";
            $data['listado'] = 'admin/relaciones/form';
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [edita modificacion de relaciones]
     * @param  integer $id
     * @return view
     */
    public function edita($id=0) {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->relacion->edicion($u);
            $this->session->set_flashdata('message', 'La relaci&oacute;n se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/relaciones/index', 'location');
        } else {
            
            $data = array();
            $data['admin'] = $this->admin;
            $data['menu_top'] =$this->menu;
            $data['menusel'] = "relaciones";
            $data['listado'] = 'admin/relaciones/form_edit';
            $args=array('tabla'=>'relaciones_familiares','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [borra baja de relaciones]
     * @param  integer $id
     * @return void
     */
    public function borra($id) {
        $id = (int)$id;
        $args=array('tabla'=>'relaciones_familiares','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la relaci&oacute;n ha sido eliminada');
        redirect(base_url() . 'admin/relaciones/index', 'location');
    }

    /**
     * [getRelacionById devuelve relaciones por id y sede]
     * @param  integer $id
     * @param  integer $sede
     * @return json string
     */
    public function getRelacionById($id=0,$sede = 0){
        $id = (int)$id;
        $sede = (int)$sede;
        $relacion = $this->relacion->getRelacionById($id);
        if($relacion != 'no existe'){
            echo json_encode($relacion);
        }else{
            echo json_encode('no existe');
        }
    }

} //class end bracket

