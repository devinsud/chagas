<?php
class Ciclo extends CI_Model {


    /**
     * [registro alta]
     * @return void
     */
    public function registro() {
        $u = $this->input->post('item');
        $data = array(
            'ciclo' => $u['ciclo'],
            'tipo' => $u['tipo'],
            'id_sede' => $u['id_sede']
        );
        $this->db->insert('ciclos', $data);
    }
    
    /**
     * [edicion modificacion]
     * @return void
     */
    public function edicion() {
        $u = $this->input->post('item');
        $data = array(
            'ciclo' => $u['ciclo'],
            'tipo' => $u['tipo'],
            'id_sede' => $u['id_sede']
        );
        $this->db->where('id', $u['id']);
        $this->db->update('ciclos', $data);
    }

    /**
     * [getcicloId devuelve un ciclo basado en su id]
     * @param  integer $id_ciclo
     * @return obj
     */
    public function getcicloId($id_ciclo){
        $id = (int)$id_ciclo;
        $this->db->where('id',$id);
        $res = $this->db->get('ciclos')->result();
        return $res;
    }

    /**
     * [getCicloById trae ciclo por id y sede]
     * @param  integer $id_ciclo [description]
     * @param  integer $id_sede  [description]
     * @return obj
     */
    public function getCicloById($id_ciclo=0,$id_sede=0){
        $id = (int)$id_ciclo;
        $id_sede = (int)$id_sede;
        if($id!=0){
            $this->db->where('id_sede',$id_sede);
            $this->db->where('id',$id);
            $res = $this->db->get('ciclos')->result();
            return $res;
        }else{
            return 'no existe';
        }
        
    }

    /**
     * [getCiclos devuelve todos los ciclos]
     * @return obj
     */
    public function getCiclos(){
        $this->db->order_by('ciclo','asc');
        $res = $this->db->get('ciclos')->result();
        return $res;
    }

    /**
     * [getCiclosBySede devuelve todos los ciclos de una sede]
     * @param  [type] $id_sede [description]
     * @return [type]          [description]
     */
    public function getCiclosBySede($id_sede){
        $id_sede = (int)$id_sede;
        $this->db->where('id_sede',$id_sede);
        $this->db->order_by('id','desc');
        $res = $this->db->get('ciclos')->result();
        return $res;
    }


    
}
