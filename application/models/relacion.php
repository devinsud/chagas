<?php
class Relacion extends CI_Model {

    /**
     * [registro alta]
     * @return void
     */
    public function registro() {
        $u = $this->input->post('item');
        $data = array(
            'relacion' => $u['relacion']
        );
        $this->db->insert('relaciones_familiares', $data);
    }
    
    /**
     * [edicion modificacion]
     * @return void
     */
    public function edicion() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            'relacion' => $u['relacion']            
        );
        $this->db->where('id', $u['id']);
        $this->db->update('relaciones_familiares', $data);
    }

    /**
     * [getRelaciones devuelve relaciones]
     * @return [type] [description]
     */
    public function getRelaciones(){
        $res = $this->db->get('relaciones_familiares')->result();
        return $res;
    }


    
}
