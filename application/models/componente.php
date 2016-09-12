<?php
class Componente extends CI_Model {


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
    public function registro() {
        
        $admin = $this->get_user($this->session->userdata('id'));
        $args = array(
            'path'=>'./assets/imagenes/',
            'ancho'=>75,
            'alto'=>20,
            'tabla'=>'componentes',
            'campo'=>'id',
            'valor'=>0,
            'campo_imagen'=>'icono',
            'campos'=>array('nombre'=>'nombre', 'codigo'=>'codigo')
        );
        $this->varios->addImage($args);


    }
    

        






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

   

    
   

    public function getSedeId($id_sede){
        $id = (int)$id_sede;
        $this->db->where('id',$id);
        $res = $this->db->get('sedes')->result();
        return $res;
    }
    
}
