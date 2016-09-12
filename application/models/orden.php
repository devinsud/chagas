<?php
class Orden extends CI_Model {

    /**
     * [get_user devuelve un usuario basado en su id]
     * @param  [int] $id 
     * @return [array]
     */
    public function get_user($id){
        $data   = array('id'=>$id);
        $Q      = $this->db->get_where('usuarios',$data);
        if ($Q->num_rows() > 0) {
                foreach ($Q->result() as $row) {
                    $users = $row; 
                }
            }
        return $users;   
    }

    /**
     * [getOrdenById devuelve una orden buscada por su id]
     * @param  [int] $id_orden 
     * @return [obj] 
     */
    public function getOrdenById($id_orden){
        $id_orden = (int)$id_orden;
        $this->db->where('id', $id_orden);
        $res = $this->db->get('ordenes')->result();
        return $res;
    }

    /**
     * [getOrdenes devuelve todas las ordenes y si se le envia el id de sede restrinje el paquete a la sede]
     * @return [obj] 
     */
    public function getOrdenes($id_sede = 0){
        if($id_sede >0){
            $this->db->where('id_sede',$id_sede);
        }
        $this->db->order_by('fecha','desc');
        $res = $this->db->get('ordenes')->result();

        return $res;
    }

    /**
     * [asienta guarda los resultados de cada orden de rociado x vivienda]
     * @return [type] [description]
     */
    public function asienta(){
        $orden = $this->input->post('orden');
        $idv = $this->input->post('idv');
        $quimico = $this->input->post('quimico');
        $cant = $this->input->post('cant');
        $observaciones = $this->input->post('observaciones');
        $fecha_rociado = $this->input->post('fecha_rociado');
        $motivo = $this->input->post('motivo');
        $data = array(
            'id_orden'      => $orden,
            'id_vivienda'   => $idv,
            'fecha_rociado' => $fecha_rociado,
            'quimico'       => $quimico,
            'cantidad'      => $cant,
            'observaciones' => $observaciones,
            'motivo'        => $motivo
            );
        $this->db->insert('ordenes_datos', $data);
        
    }

    /**
     * [getNombreSede devuelve el nombre de a sede basado en su id]
     * @param  [int] $id_sede 
     * @return [string]          
     */
    public function getNombreSede($id_sede){
        $id_sede = (int)$id_sede;
        $this->db->where('id',$id_sede);
        $res = $this->db->get('sedes')->result();
        if(isset($res[0])){
            return $res[0]->localidad;
        }else{
            return false;
        }
    }


    /**
     * [getNombreCiclo devuelve el nombre del basado en su id]
     * @param  [int] $id_sede 
     * @return [string]          
     */
    public function getNombreCiclo($id_ciclo){
        $id_ciclo = (int)$id_ciclo;
        $this->db->where('id',$id_ciclo);
        $res = $this->db->get('ciclos')->result();
        if(isset($res[0])){
            return $res[0]->ciclo;
        }else{
            return false;
        }
    }


    /**
     * [getDatosOrdenVivienda verifica si ya se agregaron datos para esa vivienda en esa orden de trabajo]
     * @param  [type] $orden    [description]
     * @param  [type] $vivienda [description]
     * @return [bool]           [description]
     */
    public function getDatosOrdenVivienda($vivienda, $orden){

        $this->db->where('id_vivienda',$vivienda);
        $this->db->where('id_orden',$orden);
        $res = $this->db->get('ordenes_datos');
        if ($res->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * [getDatosOrdenVivienda verifica si ya se agregaron datos para esa vivienda en esa orden de trabajo]
     * @param  [type] $orden    [description]
     * @param  [type] $vivienda [description]
     * @return [bool]           [description]
     */
    public function getDatos($orden, $vivienda){

        $this->db->where('id_vivienda',$vivienda);
        $this->db->where('id_orden',$orden);
        $res = $this->db->get('ordenes_datos')->result();
        return $res;
        
    }
    
    /**
     * [getUserById trae usuario por id]
     * @param  integer $id
     * @return object
     */
    public function getUserById($id){
        $this->db->where('id', $id);
        $res = $this->db->get('usuarios')->result();
        return $res;
    }

     /**
     * [guardaOrden description]
     * @return void
     */
    public function guardaOrden(){
        $viv = $this->input->post('viviendas');
        $data = array('orden'=>$viv);
        $this->db->insert('ordenes', $data);
    }
    
    /**
     * [guardaLista guarda ordenes de trabajo]
     * @return void
     */
    public function guardaLista(){
        $u = $_POST;
        
        $data = array(
            'tipo'=>$u['tipo'],
            'fecha_orden' => $u['fecha'],
            'operador' => $u['operador'],
            'observaciones' => $u['observaciones'],
            'orden' => $u['viviendas'],
            'quimico' => $u['quimico']
            );
        
        $this->db->insert('ordenes', $data);

    }

    /**
     * [aprueba marca como aprobada una orden y le pone fecha]
     * @param  [int] $id 
     * @return void
     */
    public function aprueba($id){
        
        $this->db->where('id',$id);
        $fecha = date('y-m-d');
        $data = array('aprobada'=>1, 'fecha_aprob'=>$fecha);
        $this->db->update('ordenes',$data);
        $this->tratadas($id);
    }

    

    /**
     * [elimina elimina una orden]
     * @param  [int] $id 
     * @return void
     */
    public function elimina($id){
        $this->db->where('id',$id);
        $this->db->delete('ordenes');
    }

}
