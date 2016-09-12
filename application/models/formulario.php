<?php
class Formulario extends CI_Model {


    public function get_user($id){
        $data = array('id'=>$id);
        $Q = $this->db->get_where('administradores',$data);
        if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $users = $row; 
                }
            }
        return $users;   
    }

    public function getUsuarioActual(){
        $id     = $this->session->userdata('id');
        $data   = array('id'=>$id);
        $Q      = $this->db->get_where('usuarios',$data);
        if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $users = $row; 
                }
            }
        if(isset($users)){
            return $users;   
        }else{
            $users = array('nombre'=>"admin","apellido"=>"admin");
            return $users;
        }
    }

    public function registro($u) {
        $u = $this->input->post('item');
        $hoy = @date('Y-m-d');
        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            'id_sede' => $u['id_sede'],
            'id_proyecto' => $u['id_proyecto'],
            'nombre' => $u['nombre'],
            'fecha_creacion' => $hoy,
            'fecha_modificacion'=> $hoy,
            'creado_por' => $this->session->userdata('id'),
            'formulario' => $u['formulario'],
            'status' => $u['status']
        );
        $this->db->insert('formularios', $data);
    }
    

    public function carga_de_datos(){
        $u = $this->input->post();
        
        $hoy = @date('Y-m-d');
        $usuario = $this->getUsuarioActual();

       
        
        $datos = json_encode($u);
        $data =array('id_form'=>$u['id'], 'fecha_ingreso'=>$hoy, 'datos'=>$datos, 'creado_por'=>$usuario->apellido.', '.$usuario->nombre);
        $this->db->insert('datos',$data);

    }

    public function edicion() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $hoy = @date('Y-m-d');
        $data = array(
            
           'id_sede' => $u['id_sede'],
            'id_proyecto' => $u['id_proyecto'],
            'nombre' => $u['nombre'],
            'fecha_creacion' => $hoy,
            'fecha_modificacion'=> $hoy,
            'creado_por' => $this->session->userdata('id'),
            'formulario' => $u['formulario'],
            'status' => $u['status']
        );
        $this->db->where('id', $u['id']);
        $this->db->update('formularios', $data);
        

       
    }

    public function getSedeId($id_sede){
        $id = (int)$id_sede;
        $this->db->where('id',$id);
        $res = $this->db->get('sedes')->result();
        return $res;
    }


    function Obj2ArrRecursivo($Objeto) {
        if (is_object($Objeto))
            $Objeto = get_object_vars($Objeto);
        if (is_array($Objeto))
            foreach ($Objeto as $key => $value)
                $Objeto [$key] = $this->Obj2ArrRecursivo($Objeto [$key]);
        return $Objeto;
    }

    public function getDatosByIdForm($id = 0, $desde='',$hasta=''){
        $id = (int)$id;

        $data = array('id_form'=>$id);
        $this->db->where('id_form',$id);
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

        $Q = $this->db->get('datos');

        if ($Q->num_rows() > 0) {
                foreach ($Q->result_array() as $row) {
                     $r = $this->Obj2ArrRecursivo(json_decode($row['datos']));
                    $res[] = $r; 
                }
            }
        return $res;   
    }
    
}
