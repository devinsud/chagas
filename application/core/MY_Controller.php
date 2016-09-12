<?php

class MY_Controller extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->model('administrador');
        
        $this->load->model('varios');
       
        $this->load->model('noticia');
       
        $this->admin = $this->user->is_admin($this->session->userdata('id'));
        $this->super = $this->user->is_super($this->session->userdata('id'));
        if($this->admin==1){
            if($this->super==1){
                $this->menu = 'admin/menu_super';
            }else{
                $this->menu = 'admin/menu';
            }
        }else{
            $this->menu = 'admin/menu_usr';
        }

        if($this->admin===false){ redirect(base_url() . 'admin/viviendas/index', 'location'); }
        
        
        
        
        
        if (!$this->session->userdata('loggedin'))
        {
            
            $front = $this->input->post('user');
            
            
			$this->session->set_flashdata('message', 'Su usuario o password son incorrectos, intente nuevamente');
            if(isset($front['front']) && $front['front']==1){
                redirect(base_url().'admin/login');
            }else{
                
                redirect('admin/login');
                
            }
        }else{
            
            if((int)$this->session->userdata('type')==3){
                redirect('mapa');
            }
        }
    }
}