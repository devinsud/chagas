<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	{
                $data = array();
                $data['menu_top'] = 'admin/menu_top_login';
                $data['menu_iz'] = 'admin/menu_iz_login';
                $data['form_login'] = 'admin/form_login';
                $data['col_derecha'] = 'admin/col_derecha';
		$this->load->view('admin/login',$data);
	}
        
        public function olvido_pass(){
                $data = array();
                $data['menu_top'] = 'admin/menu_top_login';
                $data['menu_iz'] = 'admin/menu_iz_login';
                $data['form_login'] = 'admin/form_forgot';
                $data['col_derecha'] = 'admin/col_derecha';
		$this->load->view('admin/forgot',$data);
        }
}

