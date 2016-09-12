<?php
class Descarga extends CI_Model {


    public function get_descargas(){
        $this->db->select('descargas.id as id_descargas, descargas.canal as canal, descargas.fecha as fecha_descarga , sitios.nombre as nombre, sitios.id as id_canal ');
        $this->db->from('descargas');
        $this->db->join('sitios','sitios.id = descargas.canal');
        $descargas = $this->db->get()->result();

        

        return $descargas;   
    }
    
    
   

   
    
}
