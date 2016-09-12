<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lugares extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lugar');


    }

    /**
     * [index listado de lugares]
     * @return [view]
     */
    public function index() {
        $data['admin'] = $this->admin;  //this admin vive en My_Controller
        $data = array();
        $data['menusel'] = "lugares";
        $data['menu_top'] = $this->menu;
        $data['listado'] = 'admin/lugares/listado';
        $args = array('tabla'=>'lugares','campo_orden'=>'tipo','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [crea alta de lugares]
     * @return [view]
     */
    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $this->lugar->registro();
            $this->session->set_flashdata('message', 'El lugar se agreg&oacute; correctamente');
            redirect(base_url() . 'admin/lugares/index', 'location');
        } else {
            $data = array();
            $data['admin'] = $this->admin;  //this admin vive en My_Controller
            $data['menusel'] = "lugares";
            $data['menu_top'] = $this->menu;
            $data['listado'] = 'admin/lugares/form';
            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [edita modificacion de lugares]
     * @param  integer $id 
     * @return [view]
     */
    public function edita($id=0) {
     $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->lugar->edicion($u);
            $this->session->set_flashdata('message', 'El lugar se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/lugares/index', 'location');
        } else {
            $data = array();
            $data['admin'] = $this->admin;  //this admin vive en My_Controller
            $data['menusel'] = "lugares";
            $data['menu_top'] = $this->menu;
            $data['listado'] = 'admin/lugares/form_edit';
            $args=array('tabla'=>'lugares','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
            $this->load->view('admin/admin_n', $data);
        }
    }

    /**
     * [borra elimina un lugar]
     * @param  integer $id
     * @return [void]
     */
    public function borra($id) {
        $args=array('tabla'=>'lugares','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'el lugar ha sido eliminado');
        redirect(base_url() . 'admin/lugares/index', 'location');
    }


    

} //class end bracket

