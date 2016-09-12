<?php

class Administrador extends CI_Model {
    public function authenticate($email, $password) {
            $hash = $this->_prep_password($password);
            
            $this->db->select('id,type,nombre,apellido');
            $this->db->where('email',$email);
            $this->db->where('hash', $hash);
            $this->db->where('isadmin',1);


            $Q = $this->db->get('usuarios');
          
            if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $user = $row;
                    
                }
                return $user;
            } else {
                $this->session->set_flashdata('message', 'Su usuario o password son incorrectos, intente nuevamente');
                return false;
            }
    }
    /*public function authenticate($email, $password) {
            $hash = $this->_prep_password($password);
            //var_dump($hash);die;
            $this->db->select('id,type,nombre,apellido');
            $Q = $this->db->get_where('administradores', array('email' => $email, 'hash' =>$hash));
          //var_dump($this->db->last_query());die;
            if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $user = $row;
                    
                }
                return $user;
            } else {
	 			$this->session->set_flashdata('message', 'Su usuario o password son incorrectos, intente nuevamente');
                return false;
            }
    }*/

    public function authenticate_cliente($email, $password) {
            $hash = $this->_prep_password($password);
            //var_dump($hash);die;
            $this->db->select('id,type ');
            $Q = $this->db->get_where('administradores', array('email' => $email, 'hash' =>$hash));
            if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $user = $row;
                    return $user;
                }
            } else {
				$this->session->set_flashdata('message', 'Su usuario o password son incorrectos, intente nuevamente');
                return false;
            }
    }

    
    public function is_admin($id){

            $this->db->where('id',(int)$id);
            $Q = $this->db->get('usuarios', array('id' => $id));
            if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    
                    if($row->type==1 || $row->type == 10){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
    }
    

    public function getActiveUser($id){
        $this->db->where('id',(int)$id);
        $res = $this->db->get('usuarios')->result();
        return $res;

    }

    public function get_all_admin(){
            $this->db->select('*');
            $Q = $this->db->get_where('usuarios', array('isadmin' => 1));
            if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $admin[] = $row;
                }
            }
            //var_dump($admin);die;
            if(isset($admin)){
                return $admin;
            }
    }
    
    public function _prep_password($password) {
        return sha1($password . $this->config->item('encryption_key'));
    }
    
    public function get_user($id){
        $data = array('id'=>(int)$id);
        $Q = $this->db->get_where('usuarios',$data);
        if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $users = $row; 
                }
            }
        return $users;   
    }
    
    public function get_user_by_email($email){
        $data = array('email'=>$email);
        $Q = $this->db->get_where('usuarios',$data);
        if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $users = $row; 
                }
            }
        if(isset($users)){    
            return $users;   
        }else{
            return false;
        }
    }
    
    public function email_exists($email){
        $data = array('email'=>$email);
        $Q = $this->db->get_where('usuarios',$data);
        if ($Q->num_rows() > 0) {
                return true;
            }
        return false;   
    }
    
    public function registro(){
         $u = $this->input->post('user');   
         $hash = $this->_prep_password($u['password']);
            $data = array(
                
                'email' => $u['email'],
                'nombre' => $u['nombre'],
                'apellido' => $u['apellido'],
                'password' => $u['password'],
                'hash' => $hash,
                'type' => 1,
                'isadmin' =>1
            );

            $this->db->insert('usuarios', $data);
           
    }
    
    public function edicion(){
        $u = $this->input->post('user');
        $hash = $this->_prep_password($u['password']);
        $data = array(
                
                'email' => $u['email'],
                'nombre' => $u['nombre'],
                'apellido' => $u['apellido'],
                'password' => $u['password'],
                'hash' => $hash,
                'type' => 1,
                'isadmin' =>1
            );
        $this->db->where('id', $u['id']);
        $this->db->update('usuarios', $data);
        
    }
    
    public function borrar($id){
        $data = array('id'=>$id);
        $this->db->delete('ususarios',$data);
    }

}
