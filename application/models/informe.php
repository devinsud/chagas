<?php
class Informe extends CI_Model {


    
    /**
     * [getFechaPrimeryUltimoDato Devuelve las fechas del primer y ultimo dato]
     * @param  string $tabla [description]
     * @param  string $campo [description]
     * @return [type]        [description]
     */
    public function getFechaPrimeryUltimoDato($tabla='',$campo = 'fecha_inspeccion'){
        $this->db->order_by($campo, 'desc');
        $this->db->limit(1);
        $hasta = $this->db->get($tabla)->result();
        $this->db->order_by($campo, 'asc');
        $this->db->limit(1);
        $desde = $this->db->get($tabla)->result();

        $fecha = array(
            'desde'=>$desde[0]->fecha_inspeccion,
            'hasta'=>$hasta[0]->fecha_inspeccion
        );
        return $fecha;

    }

    /**
     * [devuelveCant recibe un array con las ubicaciones de las infecciones y devuelve la cantidad total de viviendas]
     * @param  array  $pack [description]
     * @return [type]       [description]
     */
    public function devuelveCant($pack=array()){
      
        $cant=0;
        $paquete = array();
        foreach ($pack as $amb) {
            if(is_array($amb)){

                //$cant += count($amb);
                foreach($amb as $a){
                    if(!in_array($a, $paquete)){
                        $paquete[] = $a;
                    }
                }
                $cant = count($paquete);

            }else{
                $cant +=$amb;
            }
        }
        
        return $cant;
    }


    public function devuelveCant1($pack=array()){
         
        $cant=0;
        $paquete = array();
        foreach ($pack as $amb) {
            if(is_array($amb)){

                //$cant += count($amb);
                foreach($amb as $a){
                    if(!in_array($a, $paquete)){
                        $paquete[] = $a;
                    }
                }
                $cant = count($paquete);

            }else{
                $cant +=$amb;
            }
        }
        return $cant;
    }


    /**
     * [getLastCiclo devuelve el ultimo ciclo]
     * @return [type] [description]
     */
    public function getLastCiclo(){
        $this->db->order_by('ciclo', 'desc');
        $this->db->limit(1);
        $res = $this->db->get('viviendas_inspeccion')->result();
        return $res[0]->ciclo;
    }

    /**
     * [getInspeccionadas devuelve viviendas inspeccionadas con o sin criterios de filtro]
     * @param  [type]  $id_sede     [description]
     * @param  integer $barrio      [description]
     * @param  string  $desde       [description]
     * @param  string  $hasta       [description]
     * @param  string  $ciclo       [description]
     * @param  string  $ciclo_desde [description]
     * @param  string  $ciclo_hasta [description]
     * @return [type]               [description]
     */
    public function getInspeccionadas($id_sede,$barrio = 0, $desde = '', $hasta='',$filtros=''){
        if($barrio > 0){
                $barrio = (int)$barrio;
                $this->db->where('id_barrio',$barrio);
        }
        if($desde != $hasta){
            if($desde !=''){
                $this->db->where('viviendas_inspeccion.fecha >=',$desde);
            }
            if($hasta !=''){
                $this->db->where('viviendas_inspeccion.fecha <=',$hasta);
            }
        }else if($desde == $hasta && $desde!=''){
            $this->db->where('viviendas_inspeccion.fecha',$desde);
        }

        if(  is_array($filtros['filtro_ciclos'])){
            foreach($filtros['filtro_ciclos'] as $ciclo){
                if($ciclo !=''){
                    $this->db->or_where('viviendas_inspeccion.ciclo',$ciclo);
                }
            }
        }else{
            if($filtros['filtro_ciclos'] !=''){
                    $this->db->or_where('viviendas_inspeccion.ciclo',$filtros['filtro_ciclos']);
            }
        }
        
        $res = $this->db->get('viviendas_inspeccion')->result();
        return $res;
    }

    /**
     * [getInformeReceptividad arma el informe de receptividad ]
     * @param  [type] $filtros [description]
     * @return [type]          [description]
     */
    public function getInformeReceptividad($filtros){
        $data = array();
        if($filtros['id_sede'] > 0){
            $this->db->where('id_sede',(int)$filtros['id_sede']);
        }
        if($filtros['barrio'] > 0){
                $barrio = (int)$filtros['barrio'];
                $this->db->where('id_barrio',$barrio);
        }
        if($filtros['manzana'] > 0){
                $manzana = (int)$filtros['manzana'];
                $this->db->where('id_manzana',$manzana);
        }
        if($filtros['zona'] !=''){
                    $p = 0;
                    foreach ($filtros['ciclos'] as $cic) {
                         if($p == 0){
                          $this->db->where('ciclo',$cic->id);
                        }else{
                            $this->db->or_where('ciclo',$cic->id);
                        }
                        $p++;
                    }
                     
                }
        if($filtros['desde'] != $filtros['hasta']){
            if($filtros['desde'] !=''){
                $this->db->where('viviendas_inspeccion.fecha_inspeccion >=',$filtros['desde']);
            }
            if($filtros['hasta'] !=''){
                $this->db->where('viviendas_inspeccion.fecha_inspeccion <=',$filtros['hasta']);
            }
        }else if($filtros['desde'] == $filtros['hasta'] && $filtros['desde']!=''){
            $this->db->where('viviendas_inspeccion.fecha_inspeccion',$filtros['desde']);
        }


       if($filtros['zona'] ==''){
                    if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                        foreach($filtros['filtro_ciclos'] as $ciclo){
                            if($ciclo !=''){
                                $this->db->or_where('viviendas_inspeccion.ciclo',$ciclo);
                            }
                        }
                    }else{
                        if($filtros['filtro_ciclos'] !=''){
                                $this->db->or_where('viviendas_inspeccion.ciclo',$filtros['filtro_ciclos']);
                            }
                    }
                }
        

        $this->db->select('viviendas_inspeccion.*, viviendas.id_vivienda as idv, viviendas.id_barrio as id_barrio, viviendas.id_sede as id_sede  ');
        $this->db->from('viviendas');
        $this->db->join('viviendas_inspeccion','viviendas_inspeccion.id_vivienda=viviendas.id_vivienda', 'left');
        $res = $this->db->get()->result();
        $query = $this->db->last_query();

        $receptiva = 0;
        $cerrada = 0;
        $renuente = 0;
        $deshabitada = 0;
	$desarmada = 0;
        $totales =0;
        foreach ($res as $r) {
            if($r->receptividad_vivienda == 'receptiva'){
                $receptiva++;
            }else if($r->receptividad_vivienda == 'cerrada'){
                $cerrada++;
            }else if($r->receptividad_vivienda == 'renuente'){
                $renuente++;    
            }else if($r->receptividad_vivienda == 'deshabitada'){
                $deshabitada++;
            }else if($r->receptividad_vivienda == 'desarmada'){
                $desarmada++;
            }    
            $totales++;
        }
        $datos['receptiva']=$receptiva;
        $datos['cerrada']=$cerrada;
        $datos['renuente']=$renuente;
        $datos['deshabitada']=$deshabitada;
	$datos['desarmada']=$desarmada;
        $datos['totales']=$totales;
        return $datos;
    }

    /**
     * [getInfestadas arma los informes de infestacion de vivienda]
     * @param  [type] $filtros [description]
     * @return [type]          [description]
     */
    public function getInfestadas($filtros){
       
              if($filtros['zona'] !=''){
                    $p = 0;
                    foreach ($filtros['ciclos'] as $cic) {
                         if($p == 0){
                          $this->db->where('ciclo',$cic->id);
                        }else{
                            $this->db->or_where('ciclo',$cic->id);
                        }
                        $p++;
                    }
                     
                }

            $this->db->select('viviendas_positivas.*, lugares.id as id_lugar, lugares.nombre as nom, lugares.tipo as tipo, viviendas.id_sede as ids ');
            $this->db->from('viviendas_positivas');
            $this->db->join('viviendas','viviendas.id_vivienda = viviendas_positivas.id_vivienda','left' );
            $this->db->join('lugares','lugares.id = viviendas_positivas.donde','left');
            $this->db->join('barrios', 'barrios.id = viviendas.id_barrio','left');
            $this->db->group_by('viviendas_positivas.id_vivienda');

            if($filtros['id_sede'] > 0){
                $this->db->where('viviendas.id_sede',(int)$filtros['id_sede']);
            }
            if($filtros['barrio'] > 0){
                    $this->db->where('barrios.id',$filtros['barrio']);
                   // $bb = $this->getBarrioId($filtros['barrio']);
                   // $barri = $bb[0]->codigo;
            }
            if($filtros['desde'] != $filtros['hasta']){
                if($filtros['desde'] !=''){
                    $this->db->where('viviendas_positivas.fecha_positiva >=',$filtros['desde']);
                }
                if($filtros['hasta'] !=''){
                    $this->db->where('viviendas_positivas.fecha_positiva <=',$filtros['hasta']);
                }
            }else if($filtros['desde'] == $filtros['hasta'] && $filtros['desde']!=''){
                $this->db->where('viviendas_positivas.fecha_positiva',$filtros['desde']);
            }
            

            if($filtros['zona'] ==''){
                    if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                        foreach($filtros['filtro_ciclos'] as $ciclo){
                            if($ciclo !=''){
                                $this->db->or_where('viviendas_positivas.ciclo',$ciclo);
                            }
                        }
                    }else{
                        if($filtros['filtro_ciclos'] !=''){
                                $this->db->or_where('viviendas_positivas.ciclo',$filtros['filtro_ciclos']);
                            }
                    }
                }
            if(isset($ciclos)){
                foreach ($ciclos as $cic) {
                      $this->db->like('ciclo',$cic->id);
                }
            }
            $res = $this->db->get()->result();
            $lq = $this->db->last_query();
            //dump($lq);
            $peri=0;
            $intra=0;
            $total=0;

            
            foreach ($res as $r) {
                if($r->tipo=='intradomicilio'){
                    $intra++;
                }else if($r->tipo=='peridomicilio'){
                    $peri++;
                }
                $total++;   
            }

            $datos = array(
                'totales'=>$total,
                'intra'=>$intra,
                'peri'=>$peri

                );

            return $datos;


        
    }

    

    /**
     * [getByLugar Procesa una lista de viviendas positivas y
     * devuelve un hash con las infecciones por lugar 
     * de allazgo]
     * @param  string $tipo    [description]
     * @param  array  $ambos   [description]
     * @param  [type] $lugares [description]
     * @param  [type] $filtros [description]
     * @return [type]          [description]
     */
    public function getByLugar($tipo = '',$ambos=array(), $lugares,$filtros){

            $id= (int)$filtros['id_sede'];
            foreach ($lugares as $l) {
                /*****FILTROS******/
                if($filtros['id_sede'] > 0){
                    $this->db->where('viviendas.id_sede',(int)$filtros['id_sede']);
                }
                if($filtros['barrio'] > 0){
                        $this->db->where('barrios.id',$filtros['barrio']);
                        
                }
                if($filtros['desde'] != $filtros['hasta']){
                    if($filtros['desde'] !=''){
                        $this->db->where('viviendas_positivas.fecha_positiva >=',$filtros['desde']);
                    }
                    if($filtros['hasta'] !=''){
                        $this->db->where('viviendas_positivas.fecha_positiva <=',$filtros['hasta']);
                    }
                }else if($filtros['desde'] == $filtros['hasta'] && $filtros['desde']!=''){
                    $this->db->where('viviendas_positivas.fecha_positiva',$filtros['desde']);
                }
                 if($filtros['zona'] !=''){
                    $p = 0;
                    foreach ($filtros['ciclos'] as $cic) {
                         if($p == 0){
                          $this->db->where('ciclo',$cic->id);
                        }else{
                            $this->db->or_where('ciclo',$cic->id);
                        }
                        $p++;
                    }
                     
                }

                if($filtros['zona'] ==''){
                    if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                        foreach($filtros['filtro_ciclos'] as $ciclo){
                            if($ciclo !=''){
                                $this->db->or_where('viviendas_positivas.ciclo',$ciclo);
                            }
                        }
                    }else{
                        if($filtros['filtro_ciclos'] !=''){
                                $this->db->or_where('viviendas_positivas.ciclo',$filtros['filtro_ciclos']);
                            }
                    }
                }
                /*****FILTROS******/


                $this->db->join('viviendas','viviendas.id_vivienda=viviendas_positivas.id_vivienda');
                $this->db->join('lugares','lugares.id=viviendas_positivas.donde');
                $this->db->join('barrios', 'barrios.id = viviendas.id_barrio');
                
                $intraperi = ($tipo == 'intradomicilio')?'intradomicilio':'peridomicilio';
                $this->db->where('intraperi',$intraperi);
                $this->db->where('donde',$l->id);
                $vdas = $this->db->get('viviendas_positivas')->result();
               

                $rowcount[$l->nombre] = 0;
                if(is_array($ambos) && count($ambos)>0){

                    foreach ($vdas as $v) {
                        if(isset($ambos[$l->nombre])){
                            if(!in_array($v->id_vivienda, $ambos[$l->nombre])){
                                $rowcount[$l->nombre]++;
                            }
                        }
                    }
                }else{
                   foreach ($vdas as $v) {
                        
                            $rowcount[$l->nombre]++;
                        
                    }
                }
                
            }
            
        return $rowcount;
    }


    /**
     * [getCantViviendasInfectadas Procesa una lista de viviendas positivas y
     * devuelve un hash con las viviendas infectadas de un tipo particular]
     * @param  string $tipo    [description]
     * @param  array  $ambos   [description]
     * @param  [type] $lugares [description]
     * @param  [type] $filtros [description]
     * @return [type]          [description]
     */
    public function getCantViviendasInfectadas($tipo = '',$ambos=array(), $lugares,$filtros){
            $id= (int)$filtros['id_sede'];
            foreach ($lugares as $l) {
                if($filtros['id_sede'] > 0){
                    $this->db->where('viviendas.id_sede',(int)$filtros['id_sede']);
                }
                if($filtros['barrio'] > 0){
                        $this->db->where('barrios.id',$filtros['barrio']);
                        
                }
                if($filtros['desde'] != $filtros['hasta']){
                    if($filtros['desde'] !=''){
                        $this->db->where('viviendas_positivas.fecha_positiva >=',$filtros['desde']);
                    }
                    if($filtros['hasta'] !=''){
                        $this->db->where('viviendas_positivas.fecha_positiva <=',$filtros['hasta']);
                    }
                }else if($filtros['desde'] == $filtros['hasta'] && $filtros['desde']!=''){
                    $this->db->where('viviendas_positivas.fecha_positiva',$filtros['desde']);
                }

                if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                    foreach($filtros['filtro_ciclos'] as $ciclo){
                        if($ciclo !=''){
                            $this->db->or_where('viviendas_positivas.ciclo',$ciclo);
                        }
                    }
                }else{
                    if($filtros['filtro_ciclos'] !=''){
                            $this->db->or_where('viviendas_positivas.ciclo',$filtros['filtro_ciclos']);
                       }
                }


                
                $this->db->join('viviendas','viviendas.id_vivienda=viviendas_positivas.id_vivienda');
                $this->db->join('lugares','lugares.id=viviendas_positivas.donde');
                $this->db->join('barrios', 'barrios.id = viviendas.id_barrio');
                
                $intraperi = ($tipo == 'intradomicilio')?'intradomicilio':'peridomicilio';
                $this->db->where('intraperi',$intraperi);
                $this->db->where('donde',(int)$l->id);
                $this->db->group_by('viviendas_positivas.id_vivienda');
                $vdas = $this->db->get('viviendas_positivas')->result();
                $lq = $this->db->last_query();

                $rowcount[$l->nombre] = array();
                    foreach ($vdas as $v) {
                      
                            if(is_array($ambos) && count($ambos)>0 && isset($ambos[$l->nombre])){
                                if(!in_array($v->id_vivienda, $ambos[$l->nombre])){
                                    $rowcount[$l->nombre][]=$v->id_vivienda;

                                }
                            }else{
                                $rowcount[$l->nombre][]=$v->id_vivienda;
                            }
                    }
                
               
                
            }


            
        return $rowcount;
    }

    /**
     * [getViviendasBySede devuelve viviendas por sede]
     * @param  [type] $id_sede [description]
     * @return [type]          [description]
     */
    public function getViviendasBySede($id_sede){
        $id_sede = (int)$id_sede;
        $this->db->where('id_sede',$id_sede);
        $res = $this->db->get('viviendas')->result();
        return $res;
    }

    /**
     * [getPositivasByVivienda devuelve los tests positivos por vivienda y filtros ]
     * @param  string  $id_vivienda [description]
     * @param  boolean $agrupada    [description]
     * @param  [type]  $filtros     [description]
     * @return [type]               [description]
     */
    public function getPositivasByVivienda($id_vivienda='', $agrupada=false, $filtros){
        $id_sede = (int)$filtros['id_sede'];
        $this->db->join('viviendas','viviendas.id_vivienda=viviendas_positivas.id_vivienda');
        $this->db->join('barrios', 'barrios.id = viviendas.id_barrio');
        if($filtros['id_sede'] > 0){
                $this->db->where('viviendas.id_sede',(int)$filtros['id_sede']);
        }
        if($filtros['barrio'] > 0){
                $this->db->where('barrios.id',$filtros['barrio']);
                //$bb = $this->getBarrioId($filtros['barrio']);
                //$barri = $bb[0]->codigo;
        }
        if($filtros['desde'] != $filtros['hasta']){
            if($filtros['desde'] !=''){
                $this->db->where('viviendas_positivas.fecha_positiva >=',$filtros['desde']);
            }
            if($filtros['hasta'] !=''){
                $this->db->where('viviendas_positivas.fecha_positiva <=',$filtros['hasta']);
            }
        }else if($filtros['desde'] == $filtros['hasta'] && $filtros['desde']!=''){
            $this->db->where('viviendas_positivas.fecha_positiva',$filtros['desde']);
        }
        
        if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                foreach($filtros['filtro_ciclos'] as $ciclo){
                    if($ciclo !=''){
                        $this->db->or_where('viviendas_positivas.ciclo',$ciclo);
                    }
                }
        }else{
                if($filtros['filtro_ciclos'] !=''){
                        $this->db->or_where('viviendas_positivas.ciclo',$filtros['filtro_ciclos']);
                }
        }

        $this->db->where('viviendas.id_vivienda', $id_vivienda);
        if($agrupada===true){
            $this->db->group_by('intraperi');
        }
        $res = $this->db->get('viviendas_positivas')->result();
        
        $lq = $this->db->last_query();
        
        return $res;
    }

    /**
     * [getInfestaAmbos devuelve los domicilis con infestacion intra y peri]
     * @param  [type] $lugares [description]
     * @param  [type] $filtros [description]
     * @return [type]          [description]
     */
    public function getInfestaAmbos($lugares,$filtros){

           $id_sede= (int)$filtros['id_sede'];
            

            $viv = $this->getViviendasBySede($id_sede, $filtros);
           
            $intra =  array();
            $peri = array();
            $ambos = array();

            foreach($viv as $v){
               
                $viviendasPositivas = $this->getPositivasByVivienda($v->id_vivienda, true, $filtros);
                
                if(count($viviendasPositivas)>0){
                    if(count($viviendasPositivas)==2){
                        $ambos[] = $v;
                    }
                }

                
            }
            $donde = array();
            foreach($ambos as $a){
                $viviendasPositivas1 = $this->getPositivasByVivienda($a->id_vivienda, false, $filtros);
                foreach($viviendasPositivas1 as $vp1){
                    foreach($lugares as $l){
                        if($vp1->donde == $l->id){
                            $donde[$l->nombre][] = $vp1->id_vivienda; 
                        }
                    }
                }
            }
            return $donde;
  }

    /**
     * [isPeri devuelve las viviendas que son peri o intra]
     * @param  string  $id          [description]
     * @param  integer $id_sede     [description]
     * @param  integer $barrio      [description]
     * @param  string  $desde       [description]
     * @param  string  $hasta       [description]
     * @param  string  $ciclo_desde [description]
     * @param  string  $ciclo_hasta [description]
     * @return boolean              [description]
     */
    public function isPeri($id = '',$id_sede=0, $barrio = 0 ,$desde = '',$hasta= '', $ciclo_desde = '', $ciclo_hasta = ''){
            if($id!=''){
                $this->db->where('viviendas_positivas.id_vivienda', $id);
            }

            $id_sede= (int)$id_sede;
            $this->db->where('id_sede',$id_sede);

            if($barrio > 0){
                $this->db->where('barrios.id',$filtros['barrio']);
            }
            
            if($desde != $hasta){
                if($desde !=''){
                    $this->db->where('viviendas_positivas.fecha >=',$desde);
                }
                if($hasta !=''){
                    $this->db->where('viviendas_positivas.fecha <=',$hasta);
                }
            }else if($desde == $hasta && $desde!=''){
                $this->db->where('fecha',$desde);
            }



            if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                foreach($filtros['filtro_ciclos'] as $ciclo){
                    if($ciclo !=''){
                        $this->db->or_where('ciclo',$ciclo);
                    }
                }
            }else{
                    if($filtros['filtro_ciclos'] !=''){
                            $this->db->or_where('ciclo',$filtros['filtro_ciclos']);
                    }
            }
            
            $this->db->join('viviendas','viviendas.id_vivienda=viviendas_positivas.id_vivienda');
             $this->db->join('barrios', 'barrios.id = viviendas.id_barrio');
            $res = $this->db->get('viviendas_positivas')->result();
            return $res;

    }


    
    /**
     * [getViviendasPositivasExcel crea el excel de viviendas positivas]
     * @param  integer $id     [description]
     * @param  integer $barrio [description]
     * @param  string  $desde  [description]
     * @param  string  $hasta  [description]
     * @param  string  $ciclo  [description]
     * @return [type]          [description]
     */
    public function getViviendasPositivasExcel($id = 0,$barrio = 0 ,$desde = '',$hasta= '', $ciclo = ''){
        
        if($id!=0){
            if($desde != $hasta){
                if($desde !=''){
                    $this->db->where('viviendas_positivas.fecha >=',$desde);
                }
                if($hasta !=''){
                    $this->db->where('viviendas_positivas.fecha <=',$hasta);
                }
            }else if($desde == $hasta && $desde!=''){
                $this->db->where('viviendas_positivas.fecha',$desde);
            }

            if($barrio > 0){
                $this->db->where('id_barrio',$barrio);
            }

            if($ciclo!=''){
                $this->db->where('ciclo',$ciclo);
            }

            $this->db->join('viviendas','viviendas.id_vivienda=viviendas_positivas.id_vivienda');
            $this->db->where('id_sede',$id);
            $this->db->group_by('viviendas.id_vivienda');
            $q = $this->db->get('viviendas_positivas')->result();

            foreach ($q as $row) {
                $res[] = array('ID'=>$row->id_vivienda);
            }     

        }
            if(isset($res)){
                return $res;  
            }else{
                return false;
            }
        
    }

    /**
     * [getBarrioId trae barrio por id]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getBarrioId($id){
       
        $this->db->where('id',$id);
        $rr = $this->db->get('barrios')->result();
       
        return $rr;

    }
    
    
    /**
     * [get_user busca user por id]
     * @param  [type] $id [description]
     * @return [type]     [description]
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
     * [getUsuarioActual devuelve el usuario actual]
     * @return [type] [description]
     */
    public function getUsuarioActual(){
        $id     = $this->session->userdata('id');
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
     * [getSedeId devuelve sede por id]
     * @param  [type] $id_sede [description]
     * @return [type]          [description]
     */
    public function getSedeId($id_sede){
        $id = (int)$id_sede;
        $this->db->where('id',$id);
        $res = $this->db->get('sedes')->result();
        return $res;
    }

    /**
     * [Obj2ArrRecursivo parser de objeto a array]
     * @param object $Objeto [description]
     */
    function Obj2ArrRecursivo($Objeto) {
        if (is_object($Objeto))
            $Objeto = get_object_vars($Objeto);
        if (is_array($Objeto))
            foreach ($Objeto as $key => $value)
                $Objeto [$key] = $this->Obj2ArrRecursivo($Objeto [$key]);
        return $Objeto;
    }

    /**
     * [getDatosByIdForm old]
     * @param  integer $id    [description]
     * @param  string  $desde [description]
     * @param  string  $hasta [description]
     * @param  string  $ciclo [description]
     * @return [type]         [description]
     */
    public function getDatosByIdForm($id = 0, $desde='',$hasta='', $ciclo = ''){
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
