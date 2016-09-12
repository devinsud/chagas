<?php
class Noticia extends CI_Model {

    /*
    registro
    Modelo de grabacion de datos de las noticias

     */
    public function registro($u) {
        //var_dump($u);die;
        $fecha = date('Y-m-d H:i:s');
        $fec =  explode('/',$u['fecha1']);
        $f1 = $fec[2].'-'.$fec[1].'-'.$fec[0];
        $admin = $this->get_user($this->session->userdata('id'));
        
        $data = array(
            
            'titulo' => $u['titulo'],
            'volanta' => $u['volanta'],
            'autor' => $u['autor'],
            'copete' => $u['copete'],
            'fuente' => $u['permalink'],
            'texto' => $u['texto'],
            'fecha_creacion' => $fecha,
            'fecha_modificacion' => $fecha,
            'fecha1' => $f1,
            'creada_por' => $admin->apellido.' '.$admin->nombre,
            'modificada_por' => $admin->apellido.' '.$admin->nombre,
            'permalink' => $u['permalink'],
            'empresa' => $u['empresa']
        );
        
        $this->db->insert('noticias', $data);
        
        
    }
    
    /*
    edicion
    Modelo de edicion de noticias

     */
    public function edicion() {
        $u = $this->input->post('item');
       $can = $this->input->post('canales');
       $canales ='';
       foreach ($can as $c) {
           $canales .= 'q'.$c.'q';
       }
        $fecha = @date('Y-m-d H:i:s');
        $fec =  explode('/',$u['fecha1']);
        $f1 = $fec[2].'-'.$fec[1].'-'.$fec[0];
        $admin = $this->get_user($this->session->userdata('id'));
        
        $data = array(
            
            'titulo' => $u['titulo'],
            'volanta' => $u['volanta'],
            'autor' => $u['autor'],
            'copete' => $u['copete'],
            'fuente' => $u['fuente'],
            'texto' => $u['texto'],
            'fecha_modificacion' => $fecha,
            'modificada_por' => $admin->apellido.' '.$admin->nombre,
            'permalink' => $u['permalink'],
            'canales' => $canales,
            'empresa' => $u['empresa']
        );
        $this->db->where('id', $u['id']);
        $this->db->update('noticias', $data);
    }

    /*
    Modelo de edicion rapida de noticias
     */
    public function edicionAlVuelo() {
        $u = $this->input->post('item');
       $can = $this->input->post('canales');
       $canales ='';
       foreach ($can as $c) {
           $canales .= 'q'.$c.'q';
       }
        $fecha = @date('Y-m-d H:i:s');
        $fec =  explode('/',$u['fecha1']);
        $f1 = $fec[2].'-'.$fec[1].'-'.$fec[0];
        $admin = $this->get_user($this->session->userdata('id'));
        
        $data = array(
            
            'titulo' => $u['titulo'],
            'volanta' => $u['volanta'],
            'autor' => $u['autor'],
            'copete' => $u['copete'],
            'fuente' => $u['fuente'],
            'texto' => $u['texto'],
            'fecha_modificacion' => $fecha,
            'modificada_por' => $admin->apellido.' '.$admin->nombre,
            'permalink' => $u['permalink'],
            'canales' => $canales
        );
        $this->db->where('id', $u['id']);
        $this->db->update('noticias', $data);
    }

    /*
    getNoticiaById
    recibe un id ( int ) 
    devuelve un array con la noticia
     */
    public function getNoticiaById($id){
        $this->db->where('id',$id);
        $Q = $this->db->get('noticias');

         if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $items[] = $row;
            }
        }
        
        if (isset($items)) {
            return $items;
        }


    }

    /*
    getImagenesByNoticiaId
    recibe un id ( int )
    devuelve un array con las imagenes de una noticia
     */

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

    /*
    getNoticiasByEmpresa
    recibe el id de la empresa y la cantidad de noticias a devolver
    devuelve un array con noticias
     */
    public function getNoticiasByEmpresa($id, $cant){
        $id_empresa = 'q'.(int)$id.'q';
        //$this->db->where('empresa',$id);
        $this->db->like('canales',$id_empresa);
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
        if (isset($items)) {
            return $items;
        }
    }

    /*
    getListadoByEmpresa
    devuelve unarray con las notas para una empresa
    recibe el id de la empresa
     */
    public function getListadoByEmpresa($id){
   
        $canal = (int)$id;
        $ahora = date('Y-m-d H:i:s');
        $this->db->where('canal',$canal);
        $this->db->order_by('fecha','desc');
        $this->db->limit(1);
        $res = $this->db->get('descargas')->result();

        if(empty($res)){
            $fecha = $ahora;
        }else{
            
            $fecha = $res[0]->fecha;
        }
        $id_empresa = 'q'.$canal.'q';
        $this->db->like('canales',$id_empresa);
        $this->db->where('fecha_modificacion >=', $fecha );
        if(isset($cant)&&$cant>0){
            $this->db->limit($cant);
        }
        $Q = $this->db->get('noticias');
         if ($Q->num_rows() > 0) {
            $cc = 0;
            foreach ($Q->result_array() as $row) {

                if($row['fecha_modificacion']==$row['fecha_creacion']){
                    $flag = 'nuevas';
                }else{
                    $flag = 'modificadas';
                }

                $items[$flag][$cc] = $row;
                $this->db->where('id_noticia',$row['id']);
                $Q1 = $this->db->get('assets_noticias')->result();
                $items[$flag][$cc]['img'] = json_encode($Q1);
                $cc++;
            }
        }

        $data2 = array('canal'=>$canal, 'fecha'=>$ahora );
        $this->db->insert('descargas',$data2);

        if (isset($items)) {
            return $items;
        }
    }



    /*
    getListadoByEmpresa
    recibe el id de la empresa
    devuelve un array con las notas para una empresa
    
     */
    public function getListadoById($id,$min=100,$max=200){
   
        $canal = (int)$id;
        $ahora = date('Y-m-d H:i:s');
        $this->db->where('canal',$canal);
        $this->db->order_by('fecha','desc');
        $this->db->limit(1);
        $res = $this->db->get('descargas')->result();

        if(empty($res)){
            $fecha = $ahora;
        }else{
            
            $fecha = $res[0]->fecha;
        }
        $id_empresa = 'q'.$canal.'q';
        $this->db->select('id, titulo, empresa, fecha, fuente, fecha_modificacion,fecha_creacion, autor, copete, texto');
        $this->db->like('canales',$id_empresa);
        $this->db->where('fecha_modificacion >=', $fecha );
        $this->db->where('status','activo');
        if(isset($cant)&&$cant>0){
            $this->db->limit($cant);
        }
        $Q = $this->db->get('noticias');
         if ($Q->num_rows() > 0) {
            $cc = 0;
            foreach ($Q->result_array() as $row) {

                $flag = ($row['fecha_modificacion']==$row['fecha_creacion']) ?  'nuevas' : 'modificadas';


                if(strlen($row['copete'])>200){  $row['copete'] = $this->corta($row['copete'],$MaxLENGTH, " ", "..."); }

                if(strlen($row['copete'])<100){
                    $row['texto'] = $this->corta($row['texto'],$MaxLENGTH, " ", "...");
                }else{
                    $row['texto']='';
                }
                $items[$flag][$cc] = $row;
                $this->db->where('id_noticia',$row['id']);
                $Q1 = $this->db->get('assets_noticias');
                if ($Q1->num_rows() > 0) {
                    foreach ($Q1->result_array() as $row1) {
                        $items[$flag][$cc]['img'][] = $row1;
                    }
                }
                $cc++;
            }
        }

        $data2 = array('canal'=>$canal, 'fecha'=>$ahora );
        $this->db->insert('descargas',$data2);

        if (isset($items)) {
            return $items;
        }
    }


    /*
    getLastDescarga
    recibe el id de canal
    devuelve un objeto con los datos de la ultima descarga realizada por un canal
     */

    public function getLastDescarga($canal){
        $ahora = @date('Y-m-d H:i:s');
        $this->db->where('canal',$canal);
        $this->db->order_by('fecha','desc');
        $this->db->limit(1);
    
        $return = $this->db->get('descargas')->result();
    }

 
    /*
    getListadoByEmpresa
    recibe el id de la empresa
    devuelve un array con las notas para una empresa junto con las notas 
    de otras empresa que le hayan sido asignadas
    
     */
    public function getListadoCompuestoByEmpresa($id,$urg= 'comun',$min=100,$max=200){
        
        $ahora = @date('Y-m-d H:i:s');


        $canal = (int)$id;
        $sitio = $this->getSitio($canal);

        $canalesQueConsume = explode('q', str_replace('qq', 'q', $sitio[0]->canales));   
        $res = $this->getLastDescarga($canal, $ahora);

        $fecha = (is_null($res)) ? $ahora : $res[0]->fecha;
        $id_empresa = 'q'.$canal.'q';


       $this->db->select('id, titulo, empresa, fecha, fuente, fecha_modificacion,fecha_creacion, autor, copete, texto');
       
       $this->db->where('fecha_modificacion >', $fecha );
        $this->db->where('status', 'activo' );
        if(!empty($canalesQueConsume)){        
            $where = "(";
            
            foreach ($canalesQueConsume as $chan) {
               
                if($chan>0){

                    $where .= " canales like '%q". $chan . "q%' OR";
                   
                }
            }
            $where1 = rtrim($where, 'OR');
            $where = $where1. ")";
            $this->db->where($where);
        }
        
         

        $Q = $this->db->get('noticias');
        $lq = $this->db->last_query();
       
         if ($Q->num_rows() > 0) {
            $cc = 0;
            foreach ($Q->result_array() as $row) {
                $flag = ($row['fecha_modificacion']==$row['fecha_creacion']) ?  'nuevas' : 'modificadas';
                $MaxLENGTH=(int)$max;
                $MinLENGHT=(int)$min;
                if(strlen($row['copete'])>200){
                    
                    $row['copete'] = $this->corta($row['copete'],$MaxLENGTH, " ", "...");
                }

                if(strlen($row['copete'])<100){
                    $row['texto'] = $this->corta($row['texto'],$MaxLENGTH, " ", "...");
                }else{
                    $row['texto']='';
                }

                $items[$flag][$cc] = $row;
                $this->db->where('id_noticia',$row['id']);
               /* $Q1 = $this->db->get('assets_noticias');
                if ($Q1->num_rows() > 0) {
                    foreach ($Q1->result_array() as $row1) {
                        $items[$flag][$cc]['img'][] = $row1;
                    }
                }*/

                $Q1 = $this->db->get('assets_noticias')->result();
                $items[$flag][$cc]['img'] = json_encode($Q1);
                
                $cc++;
            }
        }
        $this->actualizaDescarga($canal,$fecha,$urg);
        if (isset($items)) {
            return $items;
        }
    }

    public function addEstadistica($id_noticia, $canal, $ip, $navegador){
        $data = array(
                'canal'=>$canal,
                'ip_usuario' => $ip,
                'navegador' => $navegador
            );
        $this->db->insert('estadistica_simple', $data);
    }

    /*
    cambiaEstado 
    modelo de cambio de estado de las noticias entre activo e inactivo
     */
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

    /*
    getCanalByIp
    devuelve un cala basado en la ip del sitio que lo llama
    para que esto devuelva algo el canal y su ip deberan estar registrados
     */
    public function getCanalByIp(){
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->db->where('ip',$ip);
        $res = $this->db->get('sitios')->result();
        return $res;
    }

    /*
    calculateKey
    recibe el hash enviado por el consumidor del servicio y determina si el mismo es correcto
    de serlo devuelve el id del canal
     */
    public function calculateKey($hash){

        if(isset($_SERVER['HTTP_REFERER'])&&!empty($_SERVER['HTTP_REFERER'])) {
            $http_referer=$_SERVER['HTTP_REFERER'];
        }
        $canal = $this->getCanalByIp();


        //dump($canal);
        $hoy = @date('Y-m-d');
        //127.0.0.1qqwww.grupoinsud.comqq0000000002qq2013-05-21
        //5c7aa2dc3da4d0bb3eb310720a9a7fc44e093398
        //$dk1 = $canal[0]->ip.'qq'.$canal[0]->url.'qq'.str_pad($canal[0]->id, 10, "0", STR_PAD_LEFT).'qq'.$hoy;
        $dk = sha1($canal[0]->ip.'qq'.$canal[0]->url.'qq'.str_pad($canal[0]->id, 10, "0", STR_PAD_LEFT).'qq'.$hoy);

        //dump($dk . '    ' . $hash);
        //dump($dk1);
        if($dk==$hash){
            return $canal[0]->id;
        }else{
            return 0;
        }
    }    

     /*
    calculateKeyNoticia
    recibe el hash enviado por el consumidor del servicio y determina si el mismo es correcto
    de serlo devuelve el id del canal
     */
    public function calculateKeyNoticia($hash){

        if(isset($_SERVER['HTTP_REFERER'])&&!empty($_SERVER['HTTP_REFERER'])) {
            $http_referer=$_SERVER['HTTP_REFERER'];
        }
        $canal = $this->getCanalByIp();
        $hoy = @date('Y-m-d');
        //127.0.0.1qqwww.grupoinsud.comqq0000000002qq2013-05-21
        //5c7aa2dc3da4d0bb3eb310720a9a7fc44e093398
        //$dk1 = $canal[0]->ip.'qq'.$canal[0]->url.'qq'.str_pad($canal[0]->id, 10, "0", STR_PAD_LEFT).'qq'.$hoy;
        $dk = sha1($canal[0]->ip.'qq'.$canal[0]->url.'qq'.str_pad($canal[0]->id, 10, "0", STR_PAD_LEFT).'qq'.$hoy);
        //dump($dk . '    ' . $hash);
        if($dk==$hash){
            return $canal[0]->id;
        }else{
            return 0;
        }
    }   


     /*
    get_user
    recibe un int ID de un admin
    devuelve los datos del administrador
     */
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

    /*
    corta 
    es una funcion utilitaria que sirve para acortar bloques de texto a un determinado 
    numero de caracteres sin cortar las palabras

    recibe el string a cortar, el numero de caracteres al que lo va a cortar, el caracter de fin de oracion y un 
     */

    function corta($string, $limit, $break=".", $pad="…") {
 
        if(strlen($string) <= $limit)
         
            return $string;
             
        if(false !== ($breakpoint = strpos($string, $break, $limit))){
             
            if($breakpoint < strlen($string)-1) {
             
                $string = substr($string, 0, $breakpoint) . $pad;
             
            }
             
        }
             
        return $string;
         
    }


     /*
    getSitio
    recibe un id de canal 
    delvuelve un objeto con los datos del canal solicitado
     */
    public function getSitio($id){
        $this->db->where('id',$id);
        return $this->db->get('sitios')->result();
    }

    /*
    actualizaDescarga
    recibe el canal y la fecha para grabar los datos de la ultima descarga realizada por un canal
    */
    public function actualizaDescarga($canal,$fecha,$urg){
        $tipo = '';
        if($urg == 'comun'){ 

            $tipo = 'comun';
        }else if($urg == 'forzada'){
            $tipo = 'forzada';
        }
        $data2 = array('canal'=>$canal, 'fecha'=>$fecha, 'tipo'=>$tipo );
        $this->db->insert('descargas',$data2);
    }

    /*
    getAllCanales
    devuelve un objeto con todos los canales
    */

    public function getAllCanales(){
        return $this->db->get('sitios')->result();
    }


}
