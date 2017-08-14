<?php
class Barrio extends CI_Model {

    /**
     * [get_user trae usuario por id]
     * @param  integer $id
     * @return [array]
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
     * [registro alta de barrio]
     * @return [void]
     */
    public function registro() {
        $u = $this->input->post('item');
        $data = array(
            'codigo' => $u['codigo'],
            'nombre' => $u['nombre'],
            'id_sede' => $u['id_sede']
        );
        $this->db->insert('barrios', $data);
    }

    /**
     * [edicion modificacion de barrio]
     * @return void
     */
    public function edicion() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $data = array(
            'codigo' => $u['codigo'],
            'nombre' => $u['nombre'],
            'id_sede' => $u['id_sede']
        );
        $this->db->where('id', $u['id']);
        $this->db->update('barrios', $data);

    }

    /**
     * [estado swap de estado del barrio]
     * @param  integer $id
     * @return [void]
     */
    public function estado($id){
        $id = (int)$id;
        $this->db->where('id',$id);
        $res = $this->db->get('barrios')->result();
        $cambia_por = ($res[0]->estado=='inactivo')?'activo':'inactivo';    
        $data = array('estado'=>$cambia_por);
        $this->db->where('id', $id);
        $this->db->update('barrios', $data);

    }

    /**
     * [getbarrioByCodigo trae barrio por codigo asignado]
     * @param  integer $id_barrio
     * @return [obj]
     */
    public function getbarrioByCodigo($id_barrio){
        $id = (int)$id_barrio;
        $this->db->where('codigo',$id);
        $res = $this->db->get('barrios')->result();
        return $res;
    }    

    /**
     * [getbarrioByCodigo trae barrio por id]
     * @param  integer $id_barrio
     * @return [obj]
     */
    public function getbarrioId($id_barrio){
        $id = (int)$id_barrio;
        $this->db->where('id',$id);
        $res = $this->db->get('barrios')->result();
        return $res;
    }

    /**
     * [getbarrioByCodigo trae barrio por codigo asignado y sede]
     * @param  integer $id_barrio
     * @return [obj]
     */
    public function getBarrioById($id_barrio=0,$id_sede=0){
        $id = (int)$id_barrio;
        $id_sede = (int)$id_sede;
        if($id!=0){
            $this->db->where('id_sede',$id_sede);
            $this->db->where('codigo',$id);
            $res = $this->db->get('barrios')->result();
            return $res;
        }else{
            return 'no existe';
        }
        
    }

    /**
     * [getBarrios trae todos los barrios]
     * @return [obj] 
     */
    public function getBarrios(){
        $this->db->order_by('codigo','asc');
        $res = $this->db->get('barrios')->result();
        return $res;
    }

    /**
     * [getBarriosBySede trae barrios por sede]
     * @param  integer $id_sede
     * @return [obj]
     */
    public function getBarriosBySede($id_sede=0){

        $this->db->order_by('nombre','asc');
        $this->db->where('id_sede',$id_sede);
        $res = $this->db->get('barrios')->result();
        return $res;
    }


    
}
