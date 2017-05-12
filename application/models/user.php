<?php

class User extends CI_Model {

    /**
     * [authenticate autenticacion de usuarios administradores]
     * @param  string $email
     * @param  string $password
     * @return obj
     */
    public function authenticate($email, $password) {
            $hash = $this->_prep_password(($password));
            //var_dump($hash);die;
            $this->db->select('id,type,nombre,apellido, isadmin');
            $this->db->where('email', $email);
            //$this->db->where('hash', $hash);
            $res = $this->db->get('usuarios')->result();
            if ($res[0]->nombre!='') {
                return $res[0];
            } else {
	 			$this->session->set_flashdata('message', 'Su usuario o password son incorrectos, intente nuevamente');
                return false;
            }
    }

    /**
     * [authenticate autenticacion de usuarios]
     * @param  string $email
     * @param  string $password
     * @return obj
     */
    public function authenticate_cliente($email, $password) {
            $hash = $this->_prep_password($password);
            
            $this->db->select('id,type ');
            $Q = $this->db->get_where('usuarios', array('email' => $email, 'hash' =>$hash));
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

    /**
     * [_prep_password function para encodear las claves]
     * @param  string $password 
     * @return string
     */
    public function _prep_password($password) {
        return sha1(md5($password . $this->config->item('encryption_key')));
    }


    /**
     * [is_admin verificacion de permiso de adimistrador]
     * @param  integer $id
     * @return boolean
     */
    public function is_admin($id){
            $id= (int)$id;
            $this->db->where('id',(int)$id);
            $this->db->where('isadmin',1);

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
    
     /**
     * [is_super verificacion de permiso de superusuario]
     * @param  integer $id
     * @return boolean
     */
    public function is_super($id){
            $id= (int)$id;
            $this->db->where('id',(int)$id);
            $this->db->where('issuper',1);

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

    /**
     * [get_all_admin trae todos los administradore]
     * @return [type] [description]
     */
    public function get_all_admin(){
            $this->db->select('*');
            $Q = $this->db->get_where('users', array('type' => 1));
            if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $admin[] = $row;
                }
            }
            if(isset($admin)){
                return $admin;
            }
    }
    
    /**
     * [get_users devuelve usuarios]
     * @param  integer $indice [description]
     * @param  string  $busca  [description]
     * @return [type]          [description]
     */
    public function get_users($indice=0, $busca = ''){
        $ind= $indice *10;
        $this->db->select('usuarios.*');
        $this->db->order_by('usuarios.id','desc');
        $this->db->from('usuarios');
        if($busca!=''){
            $this->db->or_like('email',urldecode($busca));
            $this->db->or_like('apellido',urldecode($busca));
        }
        $this->db->limit(10,$ind);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result() as $row) {
                $items[] = $row; 
            }
        }
        if(isset($items)){    
            return $items;   
        }
    }
    
    /**
     * [get_all_users_by devuelve todos los usuarios de una sede con o sin busqueda]
     * @param  string $sede
     * @return array
     */
    public function get_all_users_by($sede=''){

        $u = $this->input->post('item');
        if($sede==''){
                   $sede = (isset($u['sede']))?$u['sede']:'';
        }
        if($sede !=''){
            $this->db->where('sede',$sede);
        }
        $Q = $this->db->get('usuarios');
        if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $items[] = $row; 
                }
            }
        if(isset($items)){    
            return $items;   
        }
    }

    /**
     * [get_all_users devuelve todos los usuarios]
     * @param  string $criterio [description]
     * @return [type]           [description]
     */
    public function get_all_users($criterio=''){
        $this->db->select('usuarios.*');
        $this->db->from('usuarios');
        if($criterio!=''){
            $this->db->or_like('email',urldecode($criterio));       
        }
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $items[] = $row; 
                }
            }
        if(isset($items)){    
            return $items;   
        }
    }
    
    /**
     * [get_user devuelve un usuario por id]
     * @param  integer $id [description]
     * @return array
     */
    public function get_user($id){
        $id = (int)$id;
        $data = array('id'=>$id);
        $Q = $this->db->get_where('usuarios',$data);
        if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $users = $row; 
                }
            }
        return $users;   
    }

    /**
     * [getUser devuelve operador por id]
     * @param  integer $id 
     * @return obj
     */
    public function getUser($id){
        $id = (int)$id;
        $this->db->where('id',$id);
        $res = $this->db->get('operadores')->result();
        return $res[0];
    }
    
    /**
     * [get_user_by_email devuelve usuario por email]
     * @param  string $email
     * @return obj / bool
     */
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
    
    /**
     * [email_exists verifica si un email existe en la base de usuarios]
     * @param  string $email
     * @return boolean
     */
    public function email_exists($email){
        $data = array('email'=>$email);
        $Q = $this->db->get_where('usuarios',$data);
        if ($Q->num_rows() > 0) {
                return true;
            }
        return false;   
    }
    
    /**
     * [registro_usuario alta usuarios]
     * @return void
     */
    public function registro_usuario(){
         $u = $this->input->post('item');   
         $isadmin = (isset($u['isadmin']))?$u['isadmin']:0;   
         $issuper = (isset($u['issuper']))?$u['issuper']:0;   
         $hash = $this->_prep_password($u['password']);
         $data = array(
                'email' => $u['email'],
                'nombre' => $u['nombre'],
                'apellido' => $u['apellido'],
                'pass' => md5($u['password']),
                'hash' => $hash,
                'sede' => $u['id_sede'],
                'type' => $u['type'],
                'isadmin' => $isadmin,
                'issuper' => $issuper
         );
         $this->db->insert('usuarios', $data);
           
    }
    
    /**
     * [editar_usuario modificacion de usuarios]
     * @return void
     */
    public function editar_usuario(){
        $u = $this->input->post('item');
        $isadmin = (isset($u['isadmin']))?$u['isadmin']:0;   
        $issuper = (isset($u['issuper']))?$u['issuper']:0;
        $hash = $this->_prep_password($u['password']);
 
        $data = array(
                'email' => $u['email'],
                'nombre' => $u['nombre'],
                'apellido' => $u['apellido'],
                'pass' => md5($u['password']),
                'hash' => $hash,
                'sede' => $u['id_sede'],
                'type' => $u['type'],
                'isadmin' => $isadmin,
                'issuper' => $issuper
        );       
        $this->db->where('id', $u['id']);
        $this->db->update('usuarios', $data);
        
    }
    
    /**
     * [borrar_usuario baja de usuarios]
     * @param  integer $id
     * @return void
     */
    public function borrar_usuario($id){
        $id = (int)$id;
        $data = array('id'=>$id);
        $this->db->delete('usuarios',$data);
    }

    /**
     * [get_estadistica_by_User devuelve estadisticas por usuario (HAY QUE MODIFICARLO)]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function get_estadistica_by_User($id=0){
        $id=(int)$id;
        $u = $this->input->post('item');
        $desde = (isset($u['desde']))?$u['desde']:'';
        $hasta = (isset($u['hasta']))?$u['hasta']:'';
        $ciclo = (isset($u['ciclo']))?$u['ciclo']:'';
        $id_user =(isset($u['id_user']))?$u['id_user']:'';
        if($id_user == '' && $id != 0){
            $id_user = $id;
        }
        $user = $this->get_user($id_user);
        $nombre = $user->apellido.', '.$user->nombre;
        $this->db->where('creado_por',$nombre);
        if($desde != $hasta){
                if($desde !=''){
                    $this->db->where('fecha_ingreso >=',$desde);
                }
                if($hasta !=''){
                    $this->db->where('fecha_ingreso <=',$hasta);
                }
            }else if($desde == $hasta && $desde!=''){
                $this->db->where('fecha_ingreso',$desde);
            }
        $q = $this->db->get('viviendas_inspeccion');
        $cant=0;
        $cargados = array();
        foreach ($q->result_array() as $row) {
            $datos = json_decode($row['datos']);
            if($ciclo!=''){
                if($datos->ciclo==$ciclo){
                    $cargados[] = $datos;
                    $cant++;  
                }
            }else{
                $cargados[] = $datos;
                $cant++;  
            }
        }
        $resultados = array('cant'=>$cant, 'cargados'=>$cargados, 'desde'=>$desde, 'hasta'=>$hasta,'ciclo'=>$ciclo );
        return $resultados;
    }

    public function get_all_for_period($id_sede=0){
        $u = $this->input->post('item');
        $desde = (isset($u['desde']))?$u['desde']:'';
        $hasta = (isset($u['hasta']))?$u['hasta']:'';
        $ciclo = (isset($u['ciclo']))?$u['ciclo']:'';
            if($desde != $hasta){
                if($desde !=''){
                    $this->db->where('fecha_ingreso >=',$desde);
                }
                if($hasta !=''){
                    $this->db->where('fecha_ingreso <=',$hasta);
                }
            }else if($desde == $hasta && $desde!=''){
                $this->db->where('fecha_ingreso',$desde);
            }
        $q = $this->db->get('datos');

        $cant=0;
        $cargados = array();
        $sede = (int)$id_sede;
        foreach ($q->result_array() as $row) {
            $datos = json_decode($row['datos']);
            
            
            if($ciclo!=''){
                if(isset($datos->ciclo)){
                    if($datos->ciclo==$ciclo){
                        if($sede>0){
                            if($datos->id_sede==$sede){
                                $cargados[] = $datos;
                                $cant++;  
                            }
                        }else{
                            $cargados[] = $datos;
                            $cant++;  
                        }
                    }
                }
            }else {
               if($sede>0){
                    if($datos->id_sede==$sede){
                            $cargados[] = $datos;
                            $cant++;  
                    }
                }else{
                    $cargados[] = $datos;
                    $cant++;  
                }
            }
        }
        
        $resultados = array('cant'=>$cant, 'cargados'=>$cargados, 'desde'=>$desde, 'hasta'=>$hasta,'ciclo'=>$ciclo );
        return $resultados;
    }

    public function get_estadistica_by_sede($id=0){
        $u = $this->input->post('item');
        
        $desde = (isset($u['desde']))?$u['desde']:'';
        $hasta = (isset($u['hasta']))?$u['hasta']:'';
        $ciclo = (isset($u['ciclo']))?$u['ciclo']:'';

        $id_user =(isset($u['id_user']))?$u['id_user']:'';
        if($id_user == '' && $id != 0){
            $id_user = $id;
        }
        $user = $this->get_user($id_user);
        $nombre = $user->apellido.', '.$user->nombre;
        $this->db->where('creado_por',$nombre);
        if($desde != $hasta){
                if($desde !=''){
                    $this->db->where('fecha_ingreso >=',$desde);
                }
                if($hasta !=''){
                    $this->db->where('fecha_ingreso <=',$hasta);
                }
            }else if($desde == $hasta && $desde!=''){
                $this->db->where('fecha_ingreso',$desde);
            }
        $q = $this->db->get('datos');
        $cant=0;
        $cargados = array();
        foreach ($q->result_array() as $row) {
            $datos = json_decode($row['datos']);
            if($ciclo!=''){
                if($datos->ciclo==$ciclo){
                    $cargados[] = $datos;
                    $cant++;  
                }
            }else{
                $cargados[] = $datos;
                $cant++;  
            }
        }
        
        $resultados = array('cant'=>$cant, 'cargados'=>$cargados, 'desde'=>$desde, 'hasta'=>$hasta,'ciclo'=>$ciclo );
        return $resultados;
    }

}
