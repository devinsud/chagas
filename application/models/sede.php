<?php
class Sede extends CI_Model {

    /**
     * [registro guarda los datos del form de creacion de sedes en la base de datos]
     * @param  [array] $u 
     * @return [void]    
     */
    public function registro($u) {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            'localidad' => $u['localidad'],
            'provincia' => $u['provincia'],
            'direccion' => $u['direccion'],
            'codpos' => $u['codpos'],
            'telefono' => $u['telefono'],
            'responsable' => $u['responsable'],
            'email' => $u['email']
        );
        $this->db->insert('sedes', $data);
    }
    
    /**
     * [registro guarda los datos del form de edicion de sedes en la base de datos]
     * @return [void]    
     */
    public function edicion() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            
           'localidad' => $u['localidad'],
            'provincia' => $u['provincia'],
            'direccion' => $u['direccion'],
            'codpos' => $u['codpos'],
            'telefono' => $u['telefono'],
            'responsable' => $u['responsable'],
            'email' => $u['email']
        );
        $this->db->where('id', $u['id']);
        $this->db->update('sedes', $data);
    }

    /**
     * [getSedeId devuelve sede por id]
     * @param  [int] $id_sede 
     * @return [obj]
     */
    public function getSedeId($id_sede){
        $id = (int)$id_sede;
        $this->db->where('id',$id);
        $res = $this->db->get('sedes')->result();
        return $res;
    }

    /**
     * [get_user devuelve el usuario con id como parametro]
     * @param  [int] $id 
     * @return [obj]
     */
    public function get_user($id){
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
     * [getBarriosBySede devuelve los barrios por sede]
     * @param  [int] $id_sede 
     * @return [obj]
     */
    public function getBarriosBySede($id_sede){
        $id_sede = (int)$id_sede;
        $this->db->where('id_sede',$id_sede);
        $res = $this->db->get('barrios')->result();
        return $res;
    }
    
}
