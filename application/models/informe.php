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
      
//        $cant=0;
//        $paquete = array();
//        foreach ($pack as $amb) {
//            if(is_array($amb)){
//
//                //$cant += count($amb);
//                foreach($amb as $a){
//                    if(!in_array($a, $paquete)){
//                        $paquete[] = $a;
//                    }
//                }
//                $cant = count($paquete);
//
//            }else{
//                $cant +=$amb;
//            }
//        }
        //Agregado por Alejandro - 20161020
        $cant=0;

        foreach ($pack as $ambiente){
            $cant = count($ambiente) + $cant;
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
    public function getInformeReceptividadByCaso($filtros,$casos){
        $data = array();

        //$casos=array('receptiva','cerrada', 'renuente', 'deshabitada', 'desarmada');

        foreach ($casos as $caso) {
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
                    $this->db->where_in('ciclo',$filtros['filtro_ciclos']);   
            
                }
            }else{
                $this->db->where('tipo',$filtros['zona']);
            }
            
 
            $this->db->select('COUNT(*) as cant');

            $this->db->join('viviendas_inspeccion','viviendas_inspeccion.id_vivienda=viviendas.id_vivienda', 'left outer');
            $this->db->where('receptividad_vivienda', $caso);
            $receptiv[$caso] = $this->db->get('viviendas')->result();
            //$query = $this->db->last_query();
            //prueba
            //var_dump($this->db->last_query()); die;
            //fin prueba

        }/*******/

        
        $datos['receptiva']=$receptiv['receptiva'][0]->cant;
        $datos['cerrada']=$receptiv['cerrada'][0]->cant;
        $datos['renuente']=$receptiv['renuente'][0]->cant;
        $datos['deshabitada']=$receptiv['deshabitada'][0]->cant;
	    $datos['desarmada']=$receptiv['desarmada'][0]->cant;
        $datos['totales']=$receptiv['receptiva'][0]->cant+$receptiv['cerrada'][0]->cant+$receptiv['renuente'][0]->cant+$receptiv['deshabitada'][0]->cant; //+$receptiv['desarmada'][0]->cant;
        return $datos;
    }


    /**
     * [getInformeReceptividad arma el informe de receptividad ]
     * @param  [type] $filtros [description]
     * @return [type]          [description]
     */
    public function getInformeReceptividad($filtros){
        $data = array();

        $casos=array('receptiva','cerrada', 'renuente', 'deshabitada', 'desarmada');

        foreach ($casos as $caso) {
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
                    $this->db->where_in('ciclo',$filtros['filtro_ciclos']);   
            
                }
            }else{
                $this->db->where('tipo',$filtros['zona']);
            }
            
 
            $this->db->select('COUNT(*) as cant');

            $this->db->join('viviendas_inspeccion','viviendas_inspeccion.id_vivienda=viviendas.id_vivienda', 'left outer');
            $this->db->where('receptividad_vivienda', $caso);
            $receptiv[$caso] = $this->db->get('viviendas')->result();
            //$query = $this->db->last_query();
            //prueba
            //var_dump($this->db->last_query()); die;
            //fin prueba

        }/*******/

        $total=$receptiv['receptiva'][0]->cant+$receptiv['cerrada'][0]->cant+$receptiv['renuente'][0]->cant+$receptiv['deshabitada'][0]->cant;
        $datos['receptiva']=array("cantidad"=>$receptiv['receptiva'][0]->cant,"porcentaje"=>round(($receptiv['receptiva'][0]->cant*100)/$total,2));
        $datos['cerrada']=array("cantidad"=>$receptiv['cerrada'][0]->cant,"porcentaje"=>round(($receptiv['cerrada'][0]->cant*100)/$total,2));
        $datos['renuente']=array("cantidad"=>$receptiv['renuente'][0]->cant,"porcentaje"=>round(($receptiv['renuente'][0]->cant*100)/$total,2));
        $datos['deshabitada']=array("cantidad"=>$receptiv['deshabitada'][0]->cant,"porcentaje"=>round(($receptiv['deshabitada'][0]->cant*100)/$total,2));
	    $datos['desarmada']=$receptiv['desarmada'][0]->cant;
        $datos['totales']=$total; //+$receptiv['desarmada'][0]->cant;
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
                    
                    $ciclosarray=array();
                    foreach ($filtros['ciclos'] as $cic) {
                        $ciclosarray[]=$cic->id;
                        $p++;
                    }
                    $this->db->where_in('ciclo',$ciclosarray);   

                }
        //Pruebas
        //var_dump($filtros['zona']);
        //Fin Pruebas

            $this->db->select('viviendas_positivas.*, lugares.id as id_lugar, lugares.nombre as nom, lugares.tipo as tipo, viviendas.id_sede as ids ');
            $this->db->from('viviendas_positivas');
            $this->db->join('viviendas','viviendas.id_vivienda = viviendas_positivas.id_vivienda','left' );
            $this->db->join('lugares','lugares.id = viviendas_positivas.donde','left');
            $this->db->join('barrios', 'barrios.id = viviendas.id_barrio','left');
            $this->db->group_by('viviendas_positivas.id_vivienda');
            $this->db->group_by('viviendas_positivas.ciclo'); // Agregado por Alejandro - 20161020 - Para contar aquellas viviendas que fueron visitadas en más de un ciclo
            $this->db->group_by('viviendas_positivas.etapa');
            $this->db->group_by('viviendas_positivas.cantidad');
            $this->db->group_by('viviendas_positivas.id');

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
                    $this->db->where_in('ciclo',$filtros['filtro_ciclos']);   
            
                }
            }
            
            
          
            
            if(isset($ciclos)){
                foreach ($ciclos as $cic) {
                      $this->db->like('ciclo',$cic->id);
                }
            }
                        $this->db->group_by('viviendas.id_sede');

            $res = $this->db->get()->result();
            $lq = $this->db->last_query();
            //Pruebas
           // dump($this->db->last_query()); die;
            //Fin pruebas
            $peri=0;
            $intra=0;
            $total=0;
            $intraperi=0;
            
            $totalArray=array();
            foreach ($res as $r) {
                if($r->tipo=='intradomicilio'){
                    $intra++;
                }else if($r->tipo=='peridomicilio'){
                    $peri++;
                }
                $totalArray[$r->id_vivienda]=$r->id_vivienda;
                $total++;   
            }
            
  

             $datos = array(
                'totales'=> count($totalArray),
                'intra'=>$intra,
                'peri'=>$peri,
                'intra-peri'=>$intraperi
                );
            //pruebas
             //Fin pruebas
            return $datos;


        
    }
    
    
    
      public function getInfestadasRev($filtros){
       
              if($filtros['zona'] !=''){
                    $p = 0;
                    
                    $ciclosarray=array();
                    foreach ($filtros['ciclos'] as $cic) {
                        $ciclosarray[]=$cic->id;
                        $p++;
                    }
                    $this->db->where_in('ciclo',$ciclosarray);   

                }
        //Pruebas
        //var_dump($filtros['zona']);
        //Fin Pruebas

            $this->db->select('viviendas_positivas.*');
            $this->db->from('viviendas_positivas');
            $this->db->group_by('viviendas_positivas.id_vivienda');
            $this->db->group_by('viviendas_positivas.ciclo'); // Agregado por Alejandro - 20161020 - Para contar aquellas viviendas que fueron visitadas en más de un ciclo
            $this->db->join('viviendas','viviendas.id_vivienda = viviendas_positivas.id_vivienda','left' );

                $this->db->join('barrios', 'barrios.id = viviendas.id_barrio','left');

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
                    $this->db->where_in('ciclo',$filtros['filtro_ciclos']);   
            
                }
            }
            
            
          
            
            if(isset($ciclos)){
                foreach ($ciclos as $cic) {
                      $this->db->like('ciclo',$cic->id);
                }
            }

            $res = $this->db->get()->result();
         
            
            $lq = $this->db->last_query();
            //Pruebas
           // dump($this->db->last_query()); die;
            //Fin pruebas
            $peri=0;
            $intra=0;
            $total=0;
            $intraperi=0;
            $data=array();
            $totalArray=array();
            foreach ($res as $r) {
                $perisum=$this->viviendaSitio($r->id_vivienda, "peridomicilio");
                $intrasum=$this->viviendaSitio($r->id_vivienda, "intradomicilio");
          
                if(count($perisum)!=0 && count($intrasum) !=0){
                    $intraperi++;
                }
                if(count($perisum)==0){
                    $intra++;
                }
                if(count($intrasum)==0){
                    $peri++;
                }
                $total++;
                $data[]=$r;
               // echo "peri".count($peri)." intra".count($intra).$r->id_vivienda."<br>";
            } 
            


             $datos = array(
                'totales'=>$total,
                'intra'=>$intra,
                'peri'=> $peri,
                'intra-peri'=>$intraperi,
                'data'=>$data
                );
            
            return $datos;


        
    }
    
    public function viviendaSitio($id,$type){
            $this->db->select('viviendas_positivas.*');
            $this->db->from('viviendas_positivas');
            $this->db->where('viviendas_positivas.id_vivienda',$id);
            $this->db->where('viviendas_positivas.intraperi',$type);

            
            $res = $this->db->get()->result();  
            return $res;
    }
    
    
    function filtroperi($array,$id){
        $arrayResult=array();
 
        foreach ($array as $value) {
            if($id==$value["id_vivienda"]){
                $arrayResult=$value;
            }
        }
        return $arrayResult;
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

 /*                if($filtros['zona'] !=''){
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

                 if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                    $this->db->where_in('ciclo',$filtros['filtro_ciclos']);   
                        
                }*/


                if($filtros['zona'] ==''){
                    if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                        $this->db->where_in('ciclo',$filtros['filtro_ciclos']);

                    }
                }else{
                    $this->db->where('viviendas.tipo',$filtros['zona']);
                }

                /*****FILTROS******/





                $this->db->join('viviendas','viviendas.id_vivienda=viviendas_positivas.id_vivienda');
                $this->db->join('lugares','lugares.id=viviendas_positivas.donde');
                $this->db->join('barrios', 'barrios.id = viviendas.id_barrio');
                
                $intraperi = ($tipo == 'intradomicilio')?'intradomicilio':'peridomicilio';
                $this->db->where('intraperi',$intraperi);
                $this->db->where('donde',$l->id);
                $this->db->from('viviendas_positivas');
                $this->db->select("viviendas_positivas.id_vivienda"); //Agregado por Alejandro - 26/09/2016
                $this->db->distinct(); //Agregado por Alejandro - 26/09/2016
                $vdas = $this->db->get()->result();
                //$vdas = $this->db->get('viviendas_positivas')->result();
               

                //$rowcount[$l->nombre] = 0;

                $rowcount[$l->nombre] = count($vdas);

/*              Comentado por Alejandro 26/09/16
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
                }*/
                
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
            //var_dump($lugares);
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


                if($filtros['zona'] ==''){
                    if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                        $this->db->where_in('ciclo',$filtros['filtro_ciclos']);

                    }
                }else{
                    $this->db->where('viviendas.tipo',$filtros['zona']);
                }


               /* if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                    $this->db->where_in('ciclo',$filtros['filtro_ciclos']);   
                        
                }*/


                
                $this->db->join('viviendas','viviendas.id_vivienda=viviendas_positivas.id_vivienda');
                $this->db->join('lugares','lugares.id=viviendas_positivas.donde');
                $this->db->join('barrios', 'barrios.id = viviendas.id_barrio');
                
                $intraperi = ($tipo == 'intradomicilio')?'intradomicilio':'peridomicilio';
                $this->db->where('intraperi',$intraperi);
                $this->db->where('donde',(int)$l->id);
                $this->db->group_by('viviendas_positivas.id_vivienda');
                $this->db->group_by('viviendas_positivas.ciclo'); //Agregado por Alejandro - 20161020 - Para tener en cuenta viviendas que fueron visitadas más de una vez
                $this->db->group_by('viviendas_positivas.etapa');
                $this->db->group_by('viviendas_positivas.cantidad');
                $this->db->group_by('viviendas.id');
                $this->db->group_by('viviendas_positivas.id');
                
                $vdas = $this->db->get('viviendas_positivas')->result();
                $lq = $this->db->last_query();
                //prueba
                //var_dump($lq); die;
                //fin prueba
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
        //Prueba
        //var_dump($rowcount); die;
        return $rowcount;
    }

    
    
    
    function filtrarPeri($intra,$peri){
        
         
    
        $intraId=array();
        $arrayTempoIntra=array();
        foreach ($intra as $value) {
                foreach($value as $in){
                    if(!in_array($in, $arrayTempoIntra)){
                        $intraId[] =array("tipo"=>"intradomicilio","id_vivienda"=>$in);
                        $arrayTempoIntra[]=$in;
                    }
                }
        }
      
        $periId=array();
        $arrayTempPeri=array();
        foreach ($peri as $value) {
            foreach($value as $pe){
                if(!in_array($pe, $arrayTempPeri)){
                    $intraId[] =array("tipo"=>"peridomicilio","id_vivienda"=>$pe);
                    $arrayTempPeri[]=$pe;

                }
            }
        }
        
        
          
        $totalArray=array();
        $totalArray["peridomicilio"]=array();
        $totalArray["intradomicilio"]=array();
        
        $pericount=0;
        $intracount=0;
        $intraperi=0;
        
        foreach ($intraId as $r) {
            
            if($r["tipo"]=="peridomicilio" ){
                   $totalArray["peridomicilio"][$r["id_vivienda"]]=$r["id_vivienda"];
            }
            
            if($r["tipo"]=="intradomicilio" ){
                   $totalArray["intradomicilio"][$r["id_vivienda"]]=$r["id_vivienda"];
            }
          
        }
        
        $result=array_intersect($totalArray["peridomicilio"],$totalArray["intradomicilio"]);
        $cantidadperi=array_diff($totalArray["peridomicilio"], $result);
        $cantidadintra=array_diff($totalArray["intradomicilio"], $result);
           
               
      return   $resulta=array("intra"=>count($cantidadintra),"peri"=>count($cantidadperi),"intraperi"=>count($result));
 
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

        //Agregado por  Alejandro - 2016-09-15
        if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
            $this->db->where_in('ciclo',$filtros['filtro_ciclos']);

        }

        /* Comentado por Alejandro - 2016-06-15 - Se encontró que estaba realizando mal la query
         *
         *          if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
                foreach($filtros['filtro_ciclos'] as $ciclo){
                    if($ciclo !=''){
                        $this->db->or_where('viviendas_positivas.ciclo',$ciclo);
                    }
                }
        }else{
                if($filtros['filtro_ciclos'] !=''){
                        $this->db->or_where('viviendas_positivas.ciclo',$filtros['filtro_ciclos']);
                }
        }*/

        $this->db->where('viviendas.id_vivienda', $id_vivienda);
        if($agrupada===true){
            $this->db->group_by('intraperi');
        }
        $res = $this->db->get('viviendas_positivas')->result();
        
        $lq = $this->db->last_query();
        //Pruebas
        //var_dump($lq); die;
        //Fin pruebas
        return $res;
    }


    public function getInfestaAmbos($lugares,$filtros){

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
        $a=0;

        if(isset($filtros['filtro_ciclos'])&& is_array($filtros['filtro_ciclos'])){
            $this->db->where_in('ciclo',$filtros['filtro_ciclos']);   
                
        }

        //$this->db->select("id_vivienda, COUNT(distinct intraperi) FROM `viviendas_positivas` GROUP BY `id_vivienda` HAVING COUNT(distinct `intraperi`) > 1'");
        $this->db->select("viviendas_positivas.id_vivienda, viviendas_positivas.donde, lugares.tipo, COUNT(distinct intraperi)");
        $this->db->from('viviendas_positivas');
        $this->db->join('viviendas','viviendas.id_vivienda = viviendas_positivas.id_vivienda');
        $this->db->join('barrios','viviendas.id_barrio = barrios.id');
        $this->db->join('lugares','viviendas_positivas.donde = lugares.id');

        $this->db->group_by('id_vivienda');
        $this->db->group_by('ciclo'); //Agregado por Alejandro - 20161020 - Para tener en cuenta viviendas que fueron visitadas más de una vez
        $this->db->group_by('donde');
        $this->db->having('COUNT(distinct intraperi) > 1');
        $ambos = $this->db->get()->result();
        //pruebas
        //var_dump($this->db->last_query()); die;
        //fin pruebas
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
     * [getInfestaAmbos devuelve los domicilis con infestacion intra y peri]
     * @param  [type] $lugares [description]
     * @param  [type] $filtros [description]
     * @return [type]          [description]
     */
    /*public function getInfestaAmbos($lugares,$filtros){

           $id_sede= (int)$filtros['id_sede'];
            
            $viv = $this->getViviendasBySede($id_sede, $filtros);
            
            $intra =  array();
            $peri = array();
            $ambos = array();

            foreach($viv as $v){
               
                $viviendasPositivas = $this->getPositivasByVivienda($v->id_vivienda, true, $filtros);
                
                if(count($viviendasPositivas)>0){
                    if(count($viviendasPositivas)==2){
                         dump($v);
                        $ambos[] = $v;
                    }
                }

                
            }

           // dump($filtros);die;
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
  */

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
            $this->db->group_by('viviendas_positivas.etapa');
            $this->db->group_by('viviendas_positivas.cantidad');
            $this->db->group_by('viviendas_positivas.id');
            $this->db->group_by('viviendas.id');
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
