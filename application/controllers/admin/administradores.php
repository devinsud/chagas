<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administradores extends MY_Controller {
    /* usuarios */

    public function index($indice=0, $criterio= '') {

        $admin = $this->user->is_admin($this->session->userdata('id'));
        if (!$admin) {
            redirect(base_url() . 'admin/admin', 'location');
        }
        $data = array();
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['col_derecha'] = 'admin/administradores/col_derecha';
        $data['listado'] = 'admin/administradores/listado';
        $data['menusel'] = "administradores";
        $args = array('tabla'=>'administradores','campo_orden'=>'id','dir_orden'=>'asc');
        $data['items'] = $this->varios->getItems($args);


        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admin_n', $data);
    }

    public function crear() {
        $submit = $this->input->post('submit');
        if ($submit != '') {
            $u = $this->input->post('user');
            $this->load->model('user');

            $existe = $this->varios->email_exists('administradores',$u['email']);
            if (!$existe) {
                $this->administrador->registro($u);
                $this->session->set_flashdata('message', 'El administrador ha sido creado');
                redirect(base_url() . 'admin/administradores/index', 'location');
            } else {
                $this->session->set_flashdata('message', 'El administrador ya existe');
                redirect(base_url() . 'admin/administradores/index', 'location');
            }
        }
        $data = array();
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';

        $data['col_derecha'] = 'admin/administradores/col_derecha';
        $data['listado'] = 'admin/administradores/form';

        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "administradores";
        $this->load->view('admin/admin_n', $data);
    }

    public function editar($id=0) {
        $submit = $this->input->post('submit');

        if ($submit != '') {
            $this->administrador->edicion();
            $this->session->set_flashdata('message', 'El administrador ha sido actualizado');
            redirect(base_url() . 'admin/administradores/index', 'location');
        }
        $args=array('tabla'=>'administradores','campo'=>'id','valor'=>$id);
            $data['item'] = $this->varios->getItem($args);
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['col_derecha'] = 'admin/administradores/col_derecha';
        $data['listado'] = 'admin/administradores/form_edit';
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "administradores";
        $this->load->view('admin/admin_n', $data);
    }

    public function borrar($id) {
        $args=array('tabla'=>'administradores','campo'=>'id','valor'=>$id);
        $this->varios->borraItem($args);

        $this->session->set_flashdata('message', 'Administrador eliminado');
        redirect(base_url() . 'admin/administradores/index', 'location');
    }

    /* Fin usuarios */


}
