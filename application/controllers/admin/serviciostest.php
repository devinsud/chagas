<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Serviciostest extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));
        $data = array();
        $data['menusel'] = "serviciostest";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/serviciostest/listado';
        $data['col_derecha'] = 'admin/serviciostest/col_derecha';
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/adminsintablas', $data);
    }

}
