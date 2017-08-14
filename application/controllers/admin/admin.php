<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function index() {

        $data = array();
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['col_derecha'] = 'admin/col_derecha';
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $data['administradores'] = $this->administrador->get_all_admin();
        $data['menusel'] = "home";
        $this->load->view('admin/admin_arranque', $data);
    }

}
