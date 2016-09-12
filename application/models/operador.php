<?php

class Operador extends CI_Model {

    
    
    /**
     * [registro alta de operadores]
     * @return void
     */
    public function registro(){
         $u = $this->input->post('item');   
         $isadmin = (isset($u['isadmin']))?$u['isadmin']:0;   
         $data = array(
                'email' => $u['email'],
                'nombre' => $u['nombre'],
                'apellido' => $u['apellido'],
                'fecha_ingreso' => $u['fecha_ingreso'],
                'id_sede' => $u['id_sede'],
                'estado' => 'activo'
         );
         $this->db->insert('operadores', $data);  
    }
    
    /**
     * [editar modificacion de operadores]
     * @return void
     */
    public function editar(){
        $u = $this->input->post('item');
        
        $data = array(                
                'email' => $u['email'],
                'nombre' => $u['nombre'],
                'apellido' => $u['apellido'],
                'fecha_ingreso' => $u['fecha_ingreso'],
                'id_sede' => $u['id_sede'],
                'estado' => 'activo'
                );       
        $this->db->where('id', $u['id']);
        $this->db->update('operadores', $data);
        
    }

    /**
     * [estado swap de estad de un operador]
     * @param  integer $id
     * @return void
     */
    public function estado($id){
        $id = (int)$id;
        $this->db->where('id',$id);
        $res = $this->db->get('operadores')->result();
        $cambia_por = ($res[0]->estado=='inactivo')?'activo':'inactivo';    
        $data = array('estado'=>$cambia_por);
        $this->db->where('id', $id);
        $this->db->update('operadores', $data);

    }

    /**
     * [borrar baja de un operador]
     * @param  integer $id
     * @return void
     */
    public function borrar($id){
        $id=(int)$id;
        $data = array('id'=>$id);
        $this->db->delete('usuarios',$data);
    }

    /**
     * [getOperarios trae operadores con o sin busqueda]
     * @param  string $criterio
     * @return array
     */
    public function getOperarios($criterio=''){
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
     * [get_user devuelve usuarios]
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
     * [getOperador devuelve operador por id]
     * @param  integer $id
     * @return obj
     */
    public function getOperador($id){
        $id = (int)$id;
        $this->db->where('id',$id);
        $res = $this->db->get('operadores')->result();
        if(isset($res[0])){
            return $res[0];
        }else{
            return 0;
        }
    }

    /**
     * [getOperadoresBySede trae operadores por sede]
     * @param  integer $id_sede
     * @return obj
     */
    public function getOperadoresBySede($id_sede){
        $id_sede = (int)$id_sede;
        $this->db->where('id_sede',$id_sede);
        $res = $this->db->get('operadores')->result();
        return $res;
    }

}
