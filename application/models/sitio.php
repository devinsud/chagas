<?php
class Sitio extends CI_Model {


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
        //var_dump($u);die;
        
        $fecha = date('Y-m-d H:i:s');
        
        $fec =  explode('/',$u['fecha1']);
        $f1 = $fec[2].'-'.$fec[1].'-'.$fec[0];
        $admin = $this->get_user($this->session->userdata('id'));
        
        $can = $this->input->post('canales');
        $canales ='';
        foreach ($can as $c) {
            $canales .= 'q'.$c.'q';
        }
        $data = array(
            'nombre' => $u['nombre'],
            'url' => $u['url'],
            'ip' => $u['ip'],
             'proveedor' => $u['proveedor'],
            'codigo_proveedor' => $u['codigo_proveedor'],
            'url_servicio' => $u['url_servicio'],
            'canales' => $canales
        );
        
        $this->db->insert('sitios', $data);
    }
    
    public function edicion() {
        $u = $this->input->post('item');
       
        $fecha = date('Y-m-d H:i:s');
        $fec =  explode('/',$u['fecha1']);
        $f1 = $fec[2].'-'.$fec[1].'-'.$fec[0];
        $admin = $this->get_user($this->session->userdata('id'));
        
        $can = $this->input->post('canales');
        $canales ='';
        foreach ($can as $c) {
            $canales .= 'q'.$c.'q';
        }
        
        $data = array(
            
            'nombre' => $u['nombre'],
            'url' => $u['url'],
            'ip' => $u['ip'],
            'proveedor' => $u['proveedor'],
            'codigo_proveedor' => $u['codigo_proveedor'],
             'url_servicio' => $u['url_servicio'],
            'canales' => $canales

        );
        $this->db->where('id', $u['id']);
        $this->db->update('sitios', $data);
    }

    public function getNoticiaById($id){
        $this->db->where('id',$id);
        $Q = $this->db->get('noticias');

         if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $items[] = $row;
            }
        }
       
        //var_dump($this->db->last_query());die;
        if (isset($items)) {
            return $items;
        }


    }
    
    public function getImagenesByNoticiaId($id){
         $this->db->where('id_noticia',$id);
        $Q = $this->db->get('assets_noticias');
         if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $items[] = $row;
            }
        }
        if (isset($items)) {
            return $items;
        }

    }


    public function getNoticiasByEmpresa($id, $cant){
        $this->db->where('empresa',$id);
        if(isset($cant)&&$cant>0){
            $this->db->limit($cant);
        }
        $Q = $this->db->get('noticias');


         if ($Q->num_rows() > 0) {
            $cc = 0;
            foreach ($Q->result_array() as $row) {
                $items[$cc] = $row;

                $this->db->where('id_noticia',$row['id']);
                $Q1 = $this->db->get('assets_noticias');
                if ($Q1->num_rows() > 0) {
                    foreach ($Q1->result_array() as $row1) {
                        $items[$cc]['img'][] = $row1;
                    }
                }

                $cc++;

            }
        }
       
        //var_dump($this->db->last_query());die;
        if (isset($items)) {
            return $items;
        }


    }

    public function cambiaEstado($id){
        $this->db->select('status');
        $this->db->where('id',$id);
        $Q = $this->db->get('noticias');
        $item='';
         if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $item = $row['status'];
            }
         }
         if($item == 'activo'){
            $this->db->where('id',$id);
            $data = array('status'=>'inactivo');
            $this->db->update('noticias',$data);
            return 'inactivo';
         }elseif($item == 'inactivo'){
            $this->db->where('id',$id);
            $data = array('status'=>'activo');
            $this->db->update('noticias',$data);
            return 'activo';
         }


    }
    
}
