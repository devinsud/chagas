<?php
class Proyecto extends CI_Model {


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
    public function registro($u) {
        $u = $this->input->post('item');
        $ahora = @date('Y-m-d');

        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            'id_sede' => $u['id_sede'],
            'nombre' => $u['nombre'],
            'descripcion' => $u['descripcion'],
            'fecha_creacion' => $ahora,
            'fecha_modificacion' => $ahora,
            'creado_por' => $this->session->userdata('id'),
            'modificado_por' => $this->session->userdata('id')
        );
        $this->db->insert('proyectos', $data);
    }
    
    public function edicion() {
        $u = $this->input->post('item');
        $ahora = @date('Y-m-d');
        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            
           'id_sede' => $u['id_sede'],
            'nombre' => $u['nombre'],
            'descripcion' => $u['descripcion'],
            'fecha_modificacion' => $ahora,
            'modificado_por' => $this->session->userdata('id')
        );
        $this->db->where('id', $u['id_proyecto']);
        $this->db->update('proyectos', $data);
       
    }

   

    
   

    public function getproyectoId($id_proyecto){
        $id = (int)$id_proyecto;
        $this->db->where('id',$id);
        $res = $this->db->get('proyectos')->result();
        return $res;
    }
    
}
