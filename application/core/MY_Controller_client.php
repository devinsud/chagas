<?php

class MY_Controller_Client extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        
        if (!$this->session->userdata('loggedin'))
        {
            redirect(base_url().'sessions/login');
        }else{
            //var_dump((int)$this->session->userdata('type'));die();
            if((int)$this->session->userdata('type')>2){
                redirect('formularios_user');
            }
        }
    }
}