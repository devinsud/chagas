<?php

class Sessions extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function login() {
        $data = array();
        $data['menu_top'] = 'admin/menu_top_login';
        $data['menu_iz'] = 'admin/menu_iz_login';
        $data['form_login'] = 'admin/form_login';
        $data['col_derecha'] = 'admin/col_derecha';
        $this->load->view('admin/login', $data);
    }

    function authenticate() {
        $this->load->model('user', '', true);
        $user = $this->input->post('user');
        $user_data = $this->user->authenticate($user['email'], $user['password']);
        if($user_data){    
            $this->session->set_userdata('id', $user_data->id);
            $this->session->set_userdata('type', $user_data->type);
            $this->session->set_userdata('loggedin', true);
        }
        redirect(base_url() . 'admin/admin');
    }

    function authenticate_user() {
        $this->load->model('user', '', true);
        $user = $this->input->post('user');
        $user_data = $this->user->authenticate_cliente($user['email'], $user['password']);
        if ($user_data) {
            $this->session->set_userdata('id', $user_data->id);
            $this->session->set_userdata('type', $user_data->id);
            $this->session->set_userdata('loggedin', true);
            redirect(base_url() . 'mapa');
        } else {
             
            redirect(base_url() . 'login');
        }
    }

    function logout() {
        $this->session->unset_userdata('loggedin');
        $this->session->unset_userdata('id');
        redirect(base_url() . 'admin/login');
    }

    function logout_front() {
        $this->session->unset_userdata('loggedin');
        $this->session->unset_userdata('id');
        redirect(base_url() . 'login');
    }

    function is_admin($id) {
        if ($this->session->userdata('loggedin')) {
            $admin = $this->user->is_admin($id);
            return $admin;
        }
    }

    
    /* usuarios */

    function registro() {
        $u = $this->input->post('user');
        $this->load->model('user');

        $existe = $this->user->email_exists($u['email']);
        if (!$existe) {
            $this->user->registro_usuario($u);
            $this->session->set_flashdata('message', 'El usuario ha sido creado');
            redirect(base_url() . 'admin/admin/users', 'location');
        } else {
            $this->session->set_flashdata('message', 'El usuario ya existe');
            redirect(base_url() . 'admin/admin/users', 'location');
        }
    }

    function edicion_usuario() {
        $this->load->model('user');
        $this->user->editar_usuario();
        $this->session->set_flashdata('message', 'El usuario ha sido actualizado');
        redirect(base_url() . 'admin/admin/users', 'location');
    }

    /* fin usuarios */

    function registro_campaign() {
        $this->load->model('campaign');
        $u = $this->input->post('campa');
        $existe = $this->campaign->campa_exists($u['titulo']);
        if (!$existe) {
            $this->campaign->registro_campa($u);
            $this->session->set_flashdata('message', 'La campa&ntilde;a se ha creado con exito');
            redirect(base_url() . 'admin/admin/campaign', 'location');
        } else {
            $this->session->set_flashdata('message', 'Ya Existe una campa&ntildea con ese nombre');
            redirect(base_url() . 'admin/admin/campaign', 'location');
        }
    }

    function edicion_campa() {
        $this->load->model('campaign');
        $this->campaign->editar_campa();
        $this->session->set_flashdata('message', 'La Campa&ntilde;a ha sido editada');
        redirect(base_url() . 'admin/admin/campaign', 'location');
    }

    /* CIA */

    function registro_cia() {
        $this->load->model('cia');
        $u = $this->input->post('cia');
        $existe = $this->cia->cia_exists($u['cia']);
        if (!$existe) {
            $this->cia->registro_cia($u);
            $this->session->set_flashdata('message', 'La Compa&ntilde;&iacute;a ha sido creada');
            redirect(base_url() . 'admin/admin/cia', 'location');
        } else {
            $this->session->set_flashdata('message', 'La Compa&ntilde;&iacute;a ya existe');
            redirect(base_url() . 'admin/admin/cia', 'location');
        }
    }

    function edicion_cia() {
        $this->load->model('cia');
        $this->cia->editar_cia();
        $this->session->set_flashdata('message', 'La Compa&ntilde;&iacute;a ha sido actualizada');
        redirect(base_url() . 'admin/admin/cia', 'location');
    }

    /* camino */

    function registro_camino() {
        $this->load->model('caminos');
        $this->caminos->registro_camino();
        $this->session->set_flashdata('message', 'El camino real ha sido creado');
        redirect(base_url() . 'admin/admin/cia', 'location');
    }

    function editar_camino() {
        $this->load->model('caminos');
        $this->caminos->editar_camino();
        $this->session->set_flashdata('message', 'El camino real ha sido actualizado');
        redirect(base_url() . 'admin/admin/cia', 'location');
    }

    function salva_waypoints($id) {
        $this->load->model('caminos');
        $this->caminos->salva_waypoints($id);
    }

    function trae_waypoints($id) {
        $this->load->model('caminos');
        $this->caminos->trae_waypoints($id);
    }

    /* soporte */

    function registro_soporte() {
        $this->load->model('soportes');
        $u = $this->input->post('soporte');
        $existe = $this->soportes->soporte_exists($u['nombre'], $u['id_campa']);
        if (!$existe) {
            $this->soportes->registro_soporte();
            $this->session->set_flashdata('message', 'El soporte ha sido creado');
            redirect(base_url() . 'admin/admin/soportes/' . $u['id_campa'], 'location');
        } else {
            $this->session->set_flashdata('message', 'Ya existe un soporte con ese nombre para la campa&ntilde;a');
            redirect(base_url() . 'admin/admin/soportes/' . $u['id_campa'], 'location');
        }
    }

    function edicion_soporte() {
        $this->load->model('soportes');
        $u = $this->input->post('soporte');
        $this->soportes->edicion_soporte();
        $this->session->set_flashdata('message', 'El soporte ha sido creado');
        redirect(base_url() . 'admin/admin/soportes/' . $u['id_campa'], 'location');
    }

    /* iconos */

    function registro_icono() {
        $this->load->model('iconos');
        $this->iconos->registro_icono();
        $this->session->set_flashdata('message', 'El icono se subi&oacute; satisfactoriamente ');
        redirect(base_url() . 'admin/admin/iconos', 'location');
    }

    function editar_icono() {
        $this->load->model('iconos');
        $this->iconos->editar_icono();
        $this->session->set_flashdata('message', 'El icono se actualiz&oacute; satisfactoriamente ');
        redirect(base_url() . 'admin/admin/iconos', 'location');
    }

    function recover_password() {
        $this->load->model('user');
        $email = $this->input->post('user');
        $user = $this->user->get_user_by_email($email['email']);

        if ($user === false) {

            $this->session->set_flashdata('message', 'No tenemos su email registrado');
            redirect(base_url() . 'admin/login', 'location');
        } else {
            $this->load->library('email');
            
                
            $this->email->initialize();
            $this->email->from('olvido_de_password@mediavest.com.ar', 'Mediavest');
            $this->email->to($user->email);

            $this->email->subject('Olvido su password - mediavest');
            $this->email->message('El password de su cuenta Mediavest es: '.$user->password);
                      

            $this->email->send();

            $this->session->set_flashdata('message', 'Su password ha sido enviado a su email');
            redirect(base_url() . 'admin/login', 'location');
        }
    }
    function registro_icono_campa() {
        $this->load->model('iconos');
        $this->iconos->registro_icono_campa();
        $id_campa = $this->input->post('id_campa');
        $this->session->set_flashdata('message', 'El icono se subi&oacute; satisfactoriamente ');
        redirect(base_url() . 'admin/admin/iconos_by_campa/'.$id_campa, 'location');
    }
    
    function editar_icono_campa() {
        $this->load->model('iconos');
        $this->iconos->editar_icono_campa();
        $id_campa = $this->input->post('id_campa');
        $this->session->set_flashdata('message', 'El icono se actualiz&oacute; satisfactoriamente ');
        redirect(base_url() . 'admin/admin/iconos_by_campa/'.$id_campa, 'location');
    }
    
    
    

}