<?php
class Lugar extends CI_Model {


    /**
     * [registro alta]
     * @return [void]
     */
    public function registro() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            'nombre' => $u['nombre'],
            'tipo' => $u['tipo']
        );
        $this->db->insert('lugares', $data);
    }
    
    /**
     * [edicion modificacion]
     * @return [void]
     */
    public function edicion() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            'nombre' => $u['nombre'],
            'tipo' => $u['tipo']
        );
        $this->db->where('id', $u['id']);
        $this->db->update('lugares', $data);
    }

    /**
     * [getLugares trae una lista de lugares]
     * @return obj
     */
    public function getLugares(){
        $res = $this->db->get('lugares')->result();
        return $res;
    }

    /**
     * [getLugarById devuelve el nombre de un lugar por su id]
     * @param  integer $id
     * @return string
     */
    public function getLugarById($id){
        $id= (int)$id;
        $this->db->where('id', (int)$id);
        $res = $this->db->get('lugares')->result();
        return $res[0]->nombre;
    }

    /**
     * [getLugaresByType devuelve lugares por tipo]
     * @param  string $tipo
     * @return obj
     */
    public function getLugaresByType($tipo=''){
        if($tipo!=''){
            $this->db->where('tipo',$tipo);
        }
        $res = $this->db->get('lugares')->result();
        return $res;
    }

    /**
     * [get_user trae usuario por id]
     * @param  integer $id
     * @return [array]
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
    
}
