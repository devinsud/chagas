<?php

class Vivienda extends CI_Model {

    /**
     * [get_user trae usuario por id]
     * @param  integer $id
     * @return array
     */
    public function get_user($id) {
        $data = array('id' => $id);
        $Q = $this->db->get_where('usuarios', $data);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result() as $row) {
                $users = $row;
            }
        }
        return $users;
    }

    /**
     * [guardaObservacion alta de observaciones]
     * @return void
     */
    public function guardaObservacion() {
        $idv = $this->input->post('idv');
        $observ = $this->input->post('observacion');
        $data = array('observaciones' => $observ);
        $this->db->where('id', $idv);
        $this->db->update('viviendas', $data);
    }

    /**
     * [getBarrioByCodigo trae barrio por codigo]
     * @param  integer $codigo_barrio
     * @return string
     */
    public function getBarrioByCodigo($codigo_barrio) {
        $id = (int) $codigo_barrio;
        $this->db->where('codigo', $id);
        $res = $this->db->get('barrios')->result();
        if (isset($res[0]->nombre)) {
            return $res[0]->nombre;
        } else {
            return "barrio no nomenclado";
        }
    }

    /**
     * [esPositiva trae los hallazgos positivos de una vivienda]
     * @param  string $idv
     * @return obj
     */
    public function esPositiva($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->group_by('ciclo');
        $this->db->group_by('viviendas_positivas.etapa');
        $this->db->group_by('viviendas_positivas.cantidad');
        $this->db->group_by('viviendas_positivas.id');
        $res = $this->db->get('viviendas_positivas')->result();
        return $res;
    }

    /**
     * [getLab devuelve el listado de hallazgos por vivienda y ciclo]
     * @param  string $idv
     * @return object
     */
    public function getLab($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->order_by('ciclo', 'desc');
        $res = $this->db->get('viviendas_positivas')->result();
        return $res;
    }

    /**
     * [inspecciones devuelve inspecciones por vivienda]
     * @param  string $idv [description]
     * @return object
     */
    public function inspecciones($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->distinct();
        $this->db->group_by('ciclo');
        $this->db->group_by('viviendas_inspeccion.id_inspeccion');
        $res = $this->db->get('viviendas_inspeccion')->result();
        return $res;
    }

    /**
     * [explode_id desarma el codigo de vivienda en sus componentes barrio, manzana vivienda]
     * @param  string $id
     * @return array
     */
    public function explode_id($idv) {
        $dato['barrio'] = intval(substr($idv, 0, 3));
        if (count($idv) == 8) {
            $dato['barrio'] = '0' . $dato['barrio'];
        }
        $nombre = $this->getBarrioByCodigo($dato['barrio']);
        $dato['nombre_barrio'] = $nombre;
        $dato['manzana'] = intval(substr($idv, 3, 3));
        $dato['vivienda'] = intval(substr($idv, 6, 3));
        return $dato;
    }

    /**
     * [registro alta vivienda]
     * @return void
     */
    public function registro() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $f = date('Y-m-d');
        $barrio = $this->getBarrioByCodigoYSede($u['id_barrio'], $u['id_sede']);

        $idBarrio = isset($barrio[0]) ? $barrio[0]->id : 0;
        $lat = preg_replace("/[^0-9.-]/", '', $u['latitud']);
        $long = preg_replace("/[^0-9.-]/", '', $u['longitud']);
        $char_count = strlen($u['idvivienda']);

        if ($char_count < 9) {
            $cat_de_ceros_a_agregar = 9 - $char_count;
            $vv = '';
            for ($a = 1; $a < ($cat_de_ceros_a_agregar + 1); $a++) {
                $vv .= '0';
            }
            $vv1 = $vv . $u['idvivienda'];
        } else {
            $vv1 = $u['idvivienda'];
        }

        $data = array(
            'id_vivienda' => $vv1,
            'latitud' => $u['latitud'],
            'longitud' => $u['longitud'],
            'id_sede' => $u['id_sede'],
            'id_barrio' => $idBarrio,
            'latitud' => $lat,
            'longitud' => $long,
            'habitantes' => $u['habitantes'],
            'tipo' => $u['tipo'],
            'id_manzana' => (int) $u['manzana'],
            'fecha' => $f,
            'clasificacion' => "1",
            'control' => 1,
            'observaciones' => ""
        );
        $this->db->insert('viviendas', $data);
    }

    /**
     * [edicion modificacion de vivienda]
     * @return void
     */
    public function edicion() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $f = date('Y-m-d');
        $barrio = $this->getBarrioByCodigoYSede($u['id_barrio'], $u['id_sede']);
        $idBarrio = isset($barrio[0]) ? $barrio[0]->id : 0;

        $char_count = strlen($u['idvivienda']);

        if ($char_count < 9) {
            $cat_de_ceros_a_agregar = 9 - $char_count;
            $vv = '';
            for ($a = 1; $a < ($cat_de_ceros_a_agregar + 1); $a++) {
                $vv .= '0';
            }
            $vv1 = $vv . $u['idvivienda'];
        } else {
            $vv1 = $u['idvivienda'];
        }
        $data = array(
            'id_vivienda' => $vv1,
            'latitud' => $u['latitud'],
            'longitud' => $u['longitud'],
            'id_sede' => $u['id_sede'],
            'id_barrio' => $idBarrio,
            'latitud' => $u['latitud'],
            'longitud' => $u['longitud'],
            'habitantes' => $u['habitantes'],
            'tipo' => $u['tipo'],
            'id_manzana' => (int) $u['manzana'],
            'fecha' => $f,
        );
        $this->db->where('id', $u['id']);
        $this->db->update('viviendas', $data);
    }

    /**
     * [getBarrioByCodigoYSede Devuelve el el barrio basado en sede y codigo]
     * @param  integer $id_barrio
     * @param  integer $id_sede
     * @return object
     */
    public function getBarrioByCodigoYSede($id_barrio, $id_sede) {
        $this->db->where('codigo', (int) $id_barrio);
        $this->db->where('id_sede', $id_sede);
        $res = $this->db->get('barrios')->result();
        return $res;
    }

    /* no hace nada */

    public function rociado($viv) {
        $viviendas = explode('-', $viv);
        foreach ($viviendas as $v) {
            $data = array(
                'id_vivienda' => $v,
            );
        }
    }

    /**
     * [edicion_lab modifica laboratorio]
     * @return [type] [description]
     */
    public function edicion_lab() {
        $u = $this->input->post('item');
        $admin = $this->get_user($this->session->userdata('id'));
        $f = date('Y-m-d');
        $data = array(
            'codigo' => $u['codigo'],
            'donde' => $u['lugar'],
            'etapa' => $u['etapa'],
            'cantidad' => $u['cantidad'],
            'que_en_lab' => $u['informe'],
            'insecto_infectado' => $u['infectado'],
            'id_usuario_edicion' => $u['usuario'],
            'fecha_positiva' => $f,
        );
        $this->db->where('id', $u['id']);
        $this->db->update('viviendas_positivas', $data);
    }

    /**
     * [getUserById trae usuario por id]
     * @param  integer $id
     * @return object
     */
    public function getUserById($id) {
        $this->db->where('id', $id);
        $res = $this->db->get('usuarios')->result();
        return $res;
    }

    /**
     * [getOperdorById trae usuario por id]
     * @param  integer $id
     * @return object
     */
    public function getOperadorById($id) {
        $this->db->where('id', $id);
        $res = $this->db->get('operadores')->result();

        return $res;
    }

    /**
     * Borra en cascada al borrar una vivienda
     */
    public function sanitiza_base_cuando_elimina_vivienda($id_vivienda) {
        $id_vivienda = $id_vivienda;
        $this->db->like('orden', $id_vivienda);
        $res = $this->db->get('ordenes')->result();
        foreach ($res as $r) {

            $orden = str_replace('-' . $id_vivienda, '', $r->orden);
            $data = array('orden' => $orden);
            $this->db->where('id', $r->id);
            $this->db->update('ordenes', $data);
        }

        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->delete('viviendas_inspeccion');

        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->delete('viviendas_positivas');

        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->delete('viviendas_tratadas');

        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->delete('viviendas_grupo');

        //dump('listo');
    }

    /**
     * [getIntraPeri devuelve lugares por id]
     * @param  integer $id
     * @return object
     */
    public function getIntraPeri($id) {
        $id = (int) $id;
        $this->db->where('id', $id);
        $res = $this->db->get('lugares')->result();
        return $res;
    }

    /**
     * [inspeccion alta de inspeccion de la vivienda]
     * @return void
     */
    public function inspeccion() {
        $u = $this->input->post('item');
      
        $et = $this->input->post('etim');
        $cod = $this->input->post('cod');
        $etapa = $this->input->post('etapa');
        $cantidad = $this->input->post('cantidad');
        $c = 0;
        $lugar = array();
        $operadores = '';
        if (isset($u['operador'])) {
            foreach ($u['operador'] as $oper) {
                $operadores .= $oper;
            }
        }

        $admin = $this->get_user($this->session->userdata('id'));
        $f = date('Y-m-d h:i:s');

        //Agregado 22/11/2016 por Alejandro, cambio de versión MySQL a 5.7 no acepta strings vacíos donde espera int
        if ($u['habitantes'] == '') {
            $aa_habitantes = 0;
        } else {
            $aa_habitantes = $u['habitantes'];
        }
        //FIN Agregado 22/11/2016 por Alejandro, cambio de versión MySQL a 5.7 no acepta strings vacíos donde espera int

        $data = array(
            'id_vivienda' => $u['id_vivienda'],
            'ciclo' => $u['ciclo'],
            // 'id_operador' => $u['operador'],
            'receptividad_vivienda' => $u['receptividad'],
            'vigilancia_entomologica' => $u['vigilancia'],
            'id_operador' => $operadores,
            'jefe_flia' => $u['jefe'],
            'id_usuario' => $u['usuario'],
            'fecha_inspeccion' => $u['fecha_inspeccion'],
            'fecha_carga_inspeccion' => $f,
            'activa' => 1,
            'observaciones' => $u['observaciones'],
            'habitantes' => $aa_habitantes, //Corregido por Alejandro - 22/11/2016
            'id_orden' => $u['orden'],
        );
        $this->db->trans_start();
        $this->db->insert('viviendas_inspeccion', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        foreach ($et as $eti) {
            $intraperi = $this->getIntraPeri($eti);
            if (isset($intraperi[0]->tipo)) {
                $lugar = array(
                    'id_vivienda' => $u['id_vivienda'],
                    'id_inspeccion' => $insert_id,
                    'donde' => $eti,
                    'intraperi' => $intraperi[0]->tipo,
                    'codigo' => $cod[$c],
                    'etapa' => $etapa[$c],
                    'cantidad' => $cantidad[$c],
                    'id_operador' => $operadores,
                    'ciclo' => $u['ciclo'],
                    'fecha_positiva' => $u['fecha_inspeccion'],
                    'activa' => 1,
                    'que_en_lab' => 0,
                    'id_usuario_edicion' => $this->session->userdata('id'),
                    'id_orden' => $u["orden"]
                );
            } else {
                $lugar = array(
                    'id_vivienda' => $u['id_vivienda'],
                    'id_inspeccion' => $insert_id,
                    'donde' => $eti,
                    'codigo' => $cod[$c],
                    'etapa' => $etapa[$c],
                    'cantidad' => $cantidad[$c],
                    'id_operador' => $operadores,
                    'ciclo' => $u['ciclo'],
                    'fecha_positiva' => $u['fecha_inspeccion'],
                    'activa' => 1,
                    'que_en_lab' => 0,
                    'id_usuario_edicion' => $this->session->userdata('id'),
                    'id_orden' => $u["orden"]
                );
            }

            if ($cod[$c] != '') {
                $this->db->insert('viviendas_positivas', $lugar);
            }

            $lugar = array();
            $c++;
        }

        $data1 = array(
            'id_vivienda' => $u['id_vivienda'],
            'fecha' => $f,
            'nombre' => $u['jefe'],
            'relacion' => 1,
            'activa' => 1,
            'edad' => 0,
            'sexo' => '',
            'ciclo' => $u['ciclo'],
        );
        $this->db->insert('viviendas_grupo', $data1);
    }

    /**
     * [delPos Elimina items de la lista de hallazgos por vivienda]
     * @param  [type] $idPos [id del hallazgo ]
     * @return [type]        [description]
     */
    public function delPos($idPos) {
        $this->db->where('id', $idPos);
        $this->db->delete('viviendas_positivas');
    }

    /**
     * [edicion_inspeccion edicion de la inspeccion de la vivienda]
     * @return void
     */
    public function edicion_inspeccion() {
        $u = $this->input->post('item');

        $et = $this->input->post('etim');
        $cod = $this->input->post('cod');
        $etapa = $this->input->post('etapa');
        $cantidad = $this->input->post('cantidad');
        $idpos = $this->input->post('idpos');
        $actual = $this->input->post('actual');
        $new = $this->input->post('new');



        $operadores = '';

        if (isset($u['operador'])) {
            foreach ($u['operador'] as $oper) {
                $operadores .= $oper."&&";
            }
        }

        foreach ($new as $n) {
            if ($n["etim"]) {


                $intraperi = $this->getIntraPeri($n["etim"]);

                $lugar = array(
                    'id_vivienda' => $u['id_vivienda'],
                    'id_inspeccion' => $u["inspeccion"],
                    'donde' => $n["etim"],
                    'intraperi' => $intraperi[0]->tipo,
                    'codigo' => $n["cod"],
                    'etapa' => $n["etapa"],
                    'cantidad' => $n["cantidad"],
                    'id_operador' => $operadores,
                    'ciclo' => $u['ciclo'],
                    'id_orden' => $u['orden'],
                    'fecha_positiva' => $u['fecha_inspeccion'],
                    'activa' => 1,
                    'que_en_lab' => 0,
                    'id_usuario_edicion' => $this->session->userdata('id'),
                );
                $this->db->insert('viviendas_positivas', $lugar);
            }
        }



        foreach ($actual as $a) {
            $intraperi = $this->getIntraPeri($a["etim"]);

            $lugar = array(
                'id_vivienda' => $u['id_vivienda'],
                'id_inspeccion' => $u["inspeccion"],
                'donde' => $a["etim"],
                'intraperi' => $intraperi[0]->tipo,
                'codigo' => $a["cod"],
                'etapa' => $a["etapa"],
                'cantidad' => $a["cantidad"],
                'id_operador' => $operadores,
                'ciclo' => $u['ciclo'],
                'id_orden' => $u['orden'],
                'fecha_positiva' => $u['fecha_inspeccion'],
                'activa' => 1,
                'que_en_lab' => 0,
                'id_usuario_edicion' => $this->session->userdata('id'),
            );
            $this->db->where('id', $a["post_id_count"]);
            $this->db->update('viviendas_positivas', $lugar);
        }



        $f = date('Y-m-d');


        $data = array(
            'id_vivienda' => $u['id_vivienda'],
            'ciclo' => $u['ciclo'],
            'receptividad_vivienda' => $u['receptividad'],
            'vigilancia_entomologica' => $u['vigilancia'],
            'id_operador' => $operadores,
            'jefe_flia' => '',
            'id_usuario' => $u['usuario'],
            'habitantes' => $u['habitantes'],
            'fecha_inspeccion' => $u['fecha_inspeccion'],
            'activa' => 1,
        );
        $this->db->where('id_inspeccion', $u['idi']);
        $this->db->update('viviendas_inspeccion', $data);

        $lq = $this->db->last_query();
        $findGroupByIdVivienda = $this->findGroupByIdVivienda($u['id_vivienda'], $u['jefe']);

        $data1 = array(
            'id_vivienda' => $u['id_vivienda'],
            'fecha' => $f,
            'nombre' => $u['jefe'],
            'relacion' => 1,
            'activa' => 1,
            'ciclo' => $u['ciclo'],
        );
        if (count($findGroupByIdVivienda) == 0) {
            $this->db->insert('viviendas_grupo', $data1);
        }
    }

    public function findGroupByIdVivienda($id, $nombre) {
        $id = (int) $id;
        $this->db->where('id_vivienda', $id);
        $this->db->where('nombre', $nombre);
        $res = $this->db->get('viviendas_grupo')->result();
        return $res;
    }

    public function findByIdVivienda($id_vivienda, $id_inspeccion, $id) {

        $id = (int) $id;
        $this->db->where('id_inspeccion', $id_inspeccion);
        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->where('id', $id);
        $res = $this->db->get('viviendas_positivas')->result();
        return $res;
    }

    /**
     * [getLabItem trae los items de lab de cada vivienda]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getLabItem($id) {
        $id = (int) $id;
        $this->db->where('id', $id);
        $res = $this->db->get('viviendas_positivas')->result();
        return $res;
    }

    /**
     * [borraInspeccion baja de inspeccion]
     * @param  integer $id
     * @param  integer $idv
     * @return void
     */
    public function borraInspeccion($id, $idv) {
        $id = (int) $id;
        $data = array('activa' => 0);
        $this->db->where('id_inspeccion', $id);
        $this->db->update('viviendas_inspeccion', $data);
    }

    /**
     * [borraPositiva baja de positivas]
     * @param  integer $id
     * @return void
     */
    public function borraPositiva($id) {
        $id = (int) $id;
        $data = array('activa' => 0);
        $this->db->where('id', $id);
        $this->db->update('viviendas_positivas', $data);
    }

    /**
     * [borraMiembroGrupo se explica sola]
     * @param  integer $id
     * @return void
     */
    public function borraMiembroGrupo($id) {
        $id = (int) $id;
        $data = array('activa' => 0);
        $this->db->where('id', $id);
        $this->db->update('viviendas_grupo', $data);
    }

    /**
     * [getLugarById trae lugar por id]
     * @param  integer $id
     * @return object
     */
    public function getLugarById($id) {
        $id = (int) $id;
        $this->db->where('id', $id);
        $res = $this->db->get('lugares')->result();
        return $res;
    }

    /**
     * [getPositivasByCicloYVivienda ]
     * @param  integer $ciclo
     * @param  string $id_vivienda
     * @return object
     */
    public function getPositivasByCicloYVivienda($ciclo, $id_vivienda) {
        $ciclo = (int) $ciclo;
        $id_vivienda = (int) $id_vivienda;

        $this->db->where('ciclo', $ciclo);
        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->where('activa', 1);
        $this->db->order_by('fecha_positiva', 'desc');
        $res = $this->db->get('viviendas_positivas')->result();
        return $res;
    }
    
    /**
     * [getPositivasByCicloYVivienda ]
     * @param  integer $ciclo
     * @param  string $id_vivienda
     * @return object
     */
    public function getPositivasByCicloYViviendaYOrden($ciclo, $id_vivienda,$orden) {
        $ciclo = (int) $ciclo;
        $id_vivienda = (int) $id_vivienda;

        $this->db->where('ciclo', $ciclo);
        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->where('activa', 1);
        $this->db->where('id_orden', $orden);
        $this->db->order_by('fecha_positiva', 'desc');
        $res = $this->db->get('viviendas_positivas')->result();
        return $res;
    }


    /**
     * [getPositivasByIdInspeccionYVivienda ]
     * @param  integer $ciclo
     * @param  string $id_vivienda
     * @return object
     */
    public function getPositivasByIdInspeccionYVivienda($id, $id_vivienda) {
        $id = (int) $id;
        $id_vivienda = (int) $id_vivienda;
        $this->db->where('id_inspeccion', $id);
        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->where('activa', 1);
        $this->db->order_by('fecha_positiva', 'desc');
        $res = $this->db->get('viviendas_positivas')->result();
        return $res;
    }

    /**
     * [vivienda_grupo alta de familiares]
     * @return void
     */
    public function vivienda_grupo() {
        $u = $this->input->post('item');
        $f = date('Y-m-d');
        $relac = $this->input->post('relac');
        $nom = $this->input->post('nom');
        $edad = $this->input->post('edad');
        $sexo = $this->input->post('sex');
        $c = 0;
        $relacion = array();
        foreach ($relac as $rel) {
            $relacion = array(
                'id_vivienda' => $u['id_vivienda'],
                'relacion' => $rel,
                'nombre' => $nom[$c],
                'edad' => $edad[$c],
                'sexo' => $sexo[$c],
                'activa' => 1,
                'ciclo' => $u['ciclo'],
                'fecha' => $u['fecha_inspeccion'],
            );
            if ($relac != '' && $nom != '') {
                $this->db->insert('viviendas_grupo', $relacion);
            }
            $relacion = array();
            $c++;
        }
    }

    /**
     * [inspeccion_positiva agrega hallazgos positivos a la vivienda]
     * @param  string $id            [description]
     * @param  string $afueraAdentro [description]
     * @param  integer $donde         [description]
     * @param  string $que           [description]
     * @return void
     */
    public function inspeccion_positiva($id, $id_inspeccion, $afueraAdentro, $donde, $que) {
        $f = date('Y-m-d');
        $data = array(
            'id_vivienda' => $id,
            'id_inspeccion' => $id_inspeccion,
            'adentro_afuera' => $afueraAdentro,
            'donde' => $donde,
            'que_en_campo' => $que,
            'ciclo' => $u['ciclo'],
            'fecha' => $f,
        );
        $this->db->insert('viviendas_positivas', $data);
    }

    /**
     * [edita_positiva edita el hallazgo positivo]
     * @param  integer $id
     * @param  string  $que
     * @return void
     */
    public function edita_positiva($id, $que) {
        $data = array(
            'que_en_lab' => $que,
        );
        $this->db->where('id', $id);
        $this->db->update('viviendas_positivas', $data);
    }

    /**
     * [getByCiclo trae viviendas por ciclo]
     * @param  [type] $idv [description]
     * @return [type]      [description]
     */
    public function getByCiclo($idv) {
        $this->db->select('viviendas.id_vivienda as idv,viviendas.id as id, viviendas_inspeccion.ciclo, viviendas.tipo as tipo, viviendas.id_sede as id_sede, latitud, longitud ');
        $this->db->from('viviendas');
        $this->db->distinct();
        $this->db->join('viviendas_inspeccion', 'viviendas_inspeccion.id_vivienda = viviendas.id_vivienda', 'left');
        $this->db->group_by('idv');
        $res = $this->db->get()->result();
        return $res;
    }

    /**
     * [getViviendaById trae vivienda por id]
     * @param  integer $idv
     * @return object
     */
    public function getViviendaById($idv) {
        $this->db->where('id', $idv);
        $res = $this->db->get("viviendas")->result();
        return $res;
    }
    
     /**
     * [getViviendaById trae vivienda por id]
     * @param  integer $idv
     * @return object
     */
    public function getViviendaByIdBarrio($idv) {
                $this->db->select('barrios.*,viviendas.*');

             $this->db->where('id_vivienda', $idv);
            $this->db->join('barrios', 'barrios.id = viviendas.id_barrio');
        return  $this->db->get('viviendas')->result();
    } 

    /**
     * [getInspecciones trae inspecciones de una vivienda]
     * @param  string $idv
     * @return object
     */
    public function getInspecciones($idv) {


        $this->db->where('id_vivienda', $idv);
        $this->db->where('activa', 1);
        $this->db->order_by('ciclo', 'desc');
        $res = $this->db->get("viviendas_inspeccion")->result();
        return $res;
    }

    /**
     * [getGrupo trae grupo familiar por id de vivienda]
     * @param  string $idv
     * @return object
     */
    public function getGrupo($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->where('activa', '1');
        $this->db->order_by('ciclo', 'desc');
        $res = $this->db->get("viviendas_grupo")->result();
        return $res;
    }

    public function getGrupoByCiclo($idv, $filtro) {
        $this->db->where('id_vivienda', $idv);
        $this->db->where('activa', '1');
        $this->db->where_in('ciclo', $filtro['filtro_ciclos']);

        $res = $this->db->get("viviendas_inspeccion")->result();
        return $res;
    }

    /**
     * [getViviendasBySedeParaListas trae viviendas por sede para el armado de las listas]
     * @param  integer $id_sede [description]
     * @return object
     */
    public function getViviendasBySedeParaListas($id_sede = 0) {
        $this->db->select('viviendas.id_vivienda as idv,viviendas.id as id, viviendas_inspeccion.ciclo, viviendas.tipo as tipo, viviendas.id_sede as id_sede, latitud, longitud, id_barrio');
        $this->db->from('viviendas');
        $this->db->distinct();
        $this->db->join('viviendas_inspeccion', 'viviendas_inspeccion.id_vivienda = viviendas.id_vivienda', 'left');
        $this->db->where('id_sede', $id_sede);
        $this->db->group_by('idv');
        $this->db->group_by('id');
        $this->db->group_by('viviendas_inspeccion.ciclo');
        $this->db->group_by('tipo');
        $this->db->group_by('id_sede'); 
        $this->db->group_by('latitud');
        $this->db->group_by('longitud');
        $this->db->group_by('id_barrio');
        $res = $this->db->get()->result();
        return $res;
    }

    /**
     * [getViviendasBySedeParaListas trae viviendascon o sin sede]
     * @param  integer $id_sede [description]
     * @return object
     */
    public function getViviendas($id_sede = 0) {

        $this->db->select('viviendas.id_vivienda as idv,viviendas.id as id, viviendas_inspeccion.ciclo, viviendas.tipo as tipo, viviendas.id_sede as id_sede, latitud, longitud, id_barrio');
        $this->db->from('viviendas');
        $this->db->distinct();
        $this->db->join('viviendas_inspeccion', 'viviendas_inspeccion.id_vivienda = viviendas.id_vivienda', 'left');
        if ($id_sede > 0) {
            $this->db->where('id_sede', $id_sede);
        }
        $this->db->group_by('idv');
        $res = $this->db->get()->result();

        return $res;
    }

    /**
     * [getViviendasBySedeParaListas trae viviendascon o sin sede]
     * @param  integer $id_sede [description]
     * @return object
     */
    public function getViviendasRociadas($id_sede = 1) {

        $this->db->select('viviendas.id_vivienda as idv,viviendas.id as id,  viviendas.tipo as tipo, viviendas.id_sede as id_sede, latitud, longitud, id_barrio, quimico, cantidad, fecha_rociado, id_orden, motivo');
        $this->db->from('ordenes_datos');
        //$this->db->distinct();
        $this->db->join('viviendas', 'viviendas.id_vivienda = ordenes_datos.id_vivienda', 'left');
        if ($id_sede > 0) {
            $this->db->where('id_sede', $id_sede);
        }

        $res = $this->db->get()->result();

        return $res;
    }

    /**
     * [getNombreBarrioByCodigo devuelve barrio por codigo de barrio]
     * @param  integer $id
     * @return string
     */
    public function getNombreBarrioByCodigo($id) {
        $this->db->where('codigo', $id);
        $res = $this->db->get('barrios')->result();
        return $res[0]->nombre;
    }

    /**
     * [getViviendasByBarrioId devuelve viviendas por barrio]
     * @param  integer $id
     * @return object
     */
    public function getViviendasByBarrioId($id) {
        $id = (int) $id;
        $this->db->where('id_barrio', $id);
        $this->db->order_by('id_vivienda', 'asc');
        $res = $this->db->get('viviendas')->result();
        return $res;
    }

    /**
     * [getViviendasByBarrioId devuelve viviendas por barrio]
     * @param  integer $id
     * @return object
     */
    public function getViviendasByOrder($id) {
        $id = (int) $id;

        $this->db->where('id', $id);
        $orden = $this->db->get('ordenes')->result();

        $viviendasEnLaOrden = explode('-', $orden[0]->orden);
        $vivs = array();
        $vivs['orden'] = $orden[0]->ciclo;
        foreach ($viviendasEnLaOrden as $v) {
            if ($v != '') {
                $this->db->where('id_vivienda', $v);
                $r = $this->db->get('viviendas')->result();
                $vivs['vivienda'][] = $r;
            }
        }

        /* 		$this->db->select('viviendas.id_vivienda as id_vivienda,viviendas.id as id, viviendas_inspeccion.ciclo,viviendas_inspeccion.id_orden, viviendas.tipo as tipo, viviendas.id_sede as id_sede, latitud, longitud, id_barrio, id_orden');
          $this->db->from('viviendas');
          $this->db->distinct();
          $this->db->join('viviendas_inspeccion', 'viviendas_inspeccion.id_vivienda = viviendas.id_vivienda', 'left');
          $this->db->group_by('id_vivienda');
          $this->db->where('id_orden', $id);
          $res = $this->db->get()->result();
         */
        return $vivs;
    }

    /**
     * [getViviendasByBarrioId devuelve viviendas por barrio]
     * @param  integer $id
     * @return object
     */
    public function getViviendasByBarrio($id) {
        $id = (int) $id;
        $this->db->select('viviendas.id_vivienda as idv,viviendas.id as id, viviendas.tipo as tipo, viviendas.id_sede as id_sede, latitud, longitud, id_barrio');
        $this->db->from('viviendas');
        $this->db->distinct();

        $this->db->group_by('idv');
        $this->db->group_by('viviendas.id');

        $this->db->where('id_barrio', $id);
        $res = $this->db->get()->result();

        return $res;
    }

    /**
     * [getViviendasBySede trae todas las viviendas de una sede]
     * @param  integer $id
     * @return object
     */
    public function getViviendasBySede($id) {
        $id = (int) $id;
        $this->db->where('id_sede', $id);
        $this->db->order_by('id_vivienda', 'asc');
        $res = $this->db->get('viviendas')->result();
        return $res;
    }

    public function getViviendasBySedeFiltrada($id, $filtros) {
        $casos = array('receptiva');
        $data = array();

        if ($filtros['id_sede'] > 0) {
            $this->db->where('id_sede', (int) $filtros['id_sede']);
        }
        if ($filtros['barrio'] > 0) {
            $barrio = (int) $filtros['barrio'];
            $this->db->where('id_barrio', $barrio);
        }
        if ($filtros['manzana'] > 0) {
            $manzana = (int) $filtros['manzana'];
            $this->db->where('id_manzana', $manzana);
        }
        if ($filtros['desde'] != $filtros['hasta']) {
            if ($filtros['desde'] != '') {
                $this->db->where('viviendas_inspeccion.fecha_inspeccion >=', $filtros['desde']);
            }
            if ($filtros['hasta'] != '') {
                $this->db->where('viviendas_inspeccion.fecha_inspeccion <=', $filtros['hasta']);
            }
        } else if ($filtros['desde'] == $filtros['hasta'] && $filtros['desde'] != '') {
            $this->db->where('viviendas_inspeccion.fecha_inspeccion', $filtros['desde']);
        }


        if ($filtros['zona'] == '') {
            if (isset($filtros['filtro_ciclos']) && is_array($filtros['filtro_ciclos'])) {
                $this->db->where_in('ciclo', $filtros['filtro_ciclos']);
            }
        } else {
            $this->db->where('tipo', $filtros['zona']);
        }


        $this->db->select('*');

        $this->db->join('viviendas_inspeccion', 'viviendas_inspeccion.id_vivienda=viviendas.id_vivienda', 'left outer');
        $this->db->where('receptividad_vivienda', "receptiva");
        $res = $this->db->get('viviendas')->result();

        return $res;
    }

    /**
     * [getViviendasBySede trae todas las viviendas de una sede]
     * @param  integer $id
     * @return object
     */
    public function getViviendasRelevadasBySede($id, $filtros) {

        /*         * *FILTROS*** */

        if ($filtros['id_sede'] > 0) {
            $this->db->where('id_sede', (int) $filtros['id_sede']);
        }
        if ($filtros['barrio'] > 0) {
            $barrio = (int) $filtros['barrio'];
            $this->db->where('id_barrio', $barrio);
        }
        if ($filtros['manzana'] > 0) {
            $manzana = (int) $filtros['manzana'];
            $this->db->where('id_manzana', $manzana);
        }
        if ($filtros['desde'] != $filtros['hasta']) {
            if ($filtros['desde'] != '') {
                $this->db->where('viviendas_inspeccion.fecha_inspeccion >=', $filtros['desde']);
            }
            if ($filtros['hasta'] != '') {
                $this->db->where('viviendas_inspeccion.fecha_inspeccion <=', $filtros['hasta']);
            }
        } else if ($filtros['desde'] == $filtros['hasta'] && $filtros['desde'] != '') {
            $this->db->where('viviendas_inspeccion.fecha_inspeccion', $filtros['desde']);
        }

        /* if ($filtros['zona'] != '') {

          foreach ($filtros['ciclos'] as $cic) {
          $this->db->or_where('ciclo', $cic->id);
          }

          } */

        //var_dump($filtros['zona'] );die();
        if ($filtros['zona'] == '') {
            if (isset($filtros['filtro_ciclos']) && is_array($filtros['filtro_ciclos'])) {
                $this->db->where_in('ciclo', $filtros['filtro_ciclos']);
            }
        } else {
            $this->db->where('viviendas.tipo', $filtros['zona']);
        }
        /*         * *FILTROS*** */

        $id = (int) $id;
        $this->db->select('count(distinct viviendas.id_vivienda) as cant');
        $this->db->join('viviendas_inspeccion', 'viviendas_inspeccion.id_vivienda=viviendas.id_vivienda', 'right');

        $res = $this->db->get('viviendas')->result();
        $lq = $this->db->last_query();
        //Pruebas
        //var_dump($this->db->last_query());die;
        //fin Pruebas
        return (int) $res[0]->cant;
    }

    /**
     * [getDatosLista set de datos para listas de trabajo]
     * @param  string $idv
     * @return object
     */
    public function getDatosLista($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->join('barrios', 'barrios.codigo = viviendas.id_barrio', 'left');
        $res = $this->db->get('viviendas')->result();
        return $res;
    }

    /**
     * [esPos verifica si una vivienda es o no positiva]
     * @param  string $idv
     * @return boolean
     */
    public function esPos($idv) {
        $this->db->where('id_vivienda', $idv);
        $res = $this->db->get('viviendas_positivas')->result();
        if (count($res) != 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * [esPos1 verifica si una vivienda es o no positiva]
     * @param  string $idv
     * @return boolean
     */
    public function esPos1($idv, $orden) {
        $this->db->where('id_vivienda', $idv);
        $this->db->where('id_orden', $orden);

        $this->db->limit(1);
        $res = $this->db->get('viviendas_inspeccion')->result();
        //$lq = $this->db->last_query();

        if (isset($res[0])) {

            if ($res[0]->vigilancia_entomologica == 'positiva') {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * [esPos1 verifica si una vivienda es o no positiva]
     * @param  string $idv
     * @return boolean
     */
    public function getEstado($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->order_by('fecha_carga_inspeccion', 'desc');
        $this->db->limit(1);
        $res = $this->db->get('viviendas_inspeccion')->result();
        $receptividad = array();
        if (isset($res[0])) {
            $receptividad = $res[0]->receptividad_vivienda;
        }
        return $receptividad;
    }

    /**
     * [getDatosUltimaInspeccion devuelve los datos de la ultima inspeccion a una vivienda]
     * @param  string $idv
     * @return object
     */
    public function getDatosUltimaInspeccion($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->order_by('fecha', 'desc');
        $this->db->limit(1);
        $res = $this->db->get('viviendas_grupo')->result();
        return $res;
    }

    /**
     * [getUltimoJefedeFamilia devuelve el jevfe de familai de la ultima inspeccion de una vivienda]
     * @param  string $idv
     * @return object
     */
    public function getUltimoJefedeFamilia($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->where('relacion', 1);
        $this->db->order_by('fecha', 'desc');
        $this->db->limit(1);
        $res = $this->db->get('viviendas_grupo')->result();
        return $res;
    }

    /**
     * [guardaOrden description]
     * @return void
     */
    public function guardaOrden() {
        $viv = $this->input->post('viviendas');
        $data = array('orden' => $viv);
        $this->db->insert('ordenes', $data);
    }

    /**
     * [getRelacionById devuelve el nombre de una relacion por su id]
     * @param  integer $relid
     * @return string
     */
    public function getRelacionById($relid) {
        $ri = (int) $relid;
        $this->db->where('id', $ri);
        $res = $this->db->get('relaciones_familiares')->result();
        if (isset($res[0]->relacion)) {
            return $res[0]->relacion;
        } else {
            return '';
        }
    }

    /**
     * [getbarrioId devuelve barrio por id]
     * @param  intetger $id_barrio
     * @return object
     */
    public function getbarrioId($id_barrio) {
        $id = (int) $id_barrio;
        $this->db->where('id', $id);
        $res = $this->db->get('barrios')->result();
        return $res;
    }

    /**
     * [getBarrioById devuelve barrio por codigo de barrio y sede]
     * @param  integer $id_barrio
     * @param  integer $id_sede
     * @return object
     */
    public function getBarrioById($id_barrio, $id_sede) {
        $id = (int) $id_barrio;
        $id_sede = (int) $id_sede;
        if ($id != 0) {
            $this->db->where('id_sede', $id_sede);
            $this->db->where('codigo', $id);
            $res = $this->db->get('barrios')->result();
            return $res;
        } else {
            return 'no existe';
        }
    }

    /**
     * [getDatosInspeccion devuelve una inspeccio por su id]
     * @param  integer $idi
     * @return object
     */
    public function getDatosInspeccion($idi, $orden) {
        $idi = (int) $idi;
        $orden = (int) $orden;
        $this->db->select('viviendas_inspeccion.*, viviendas.*, viviendas_inspeccion.habitantes as hab');
        $this->db->where('viviendas_inspeccion.id_vivienda', $idi);
        $this->db->where('viviendas_inspeccion.id_orden', $orden);
        $this->db->join('viviendas', 'viviendas.id_vivienda=viviendas_inspeccion.id_vivienda');
        $res = $this->db->get('viviendas_inspeccion')->result();
        return $res[0];
    }

    /**
     * [getSedes devuelve sedes]
     * @return object
     */
    public function getSedes() {
        $res = $this->db->get('sedes')->result();
        return $res;
    }

    /**
     * [getInfestByViv Funcion que devuelve la cantidad de lugares positivos en una vivienda]
     * @param  string $idv
     * @return integer
     */
    public function getInfestByViv($idv) {
        $this->db->where('id_vivienda', $idv);
        $res = $this->db->get('viviendas_positivas');
        $rowcount = $res->num_rows();
        return $rowcount;
    }

    /**
     * [getPositivasAgrupadasyPorSede trae todas las viviendas positivas por sede/barrio y demas]
     * @param  array $data [id_sede, barrio, desde, hasta, ciclo_desde, ciclo_hasta]
     * @return [type]       [description]
     */
    public function getPositivasAgrupadasyPorSede($data) {

        if ($data['id_sede'] > 0) {
            $id_sede = (int) $data['id_sede'];
            $this->db->where('id_sede', $id_sede);
        }
        if ($data['barrio'] > 0) {
            $barrio = (int) $data['barrio'];
            $this->db->where('id_barrio', $barrio);
        }
        if ($data['desde'] != $data['hasta']) {
            if ($data['desde'] != '') {
                $this->db->where('viviendas_positivas.fecha_positiva >=', $data['desde']);
            }
            if ($data['hasta'] != '') {
                $this->db->where('viviendas_positivas.fecha_positiva <=', $data['hasta']);
            }
        } else if ($data['desde'] == $data['hasta'] && $data['desde'] != '') {
            $this->db->where('viviendas_positivas.fecha_positiva', $data['desde']);
        }

        if ($data['zona'] != '') {
            $p = 0;
            $ciclosarray = array();
            foreach ($data['ciclos'] as $cic) {
                $ciclosarray[] = $cic->id;
                if ($p == 0) {
                    //$this->db->where('ciclo', $cic->id);
                } else {
                    //$this->db->or_where('ciclo', $cic->id);
                }
                $p++;
            }
            $this->db->where_in('ciclo', $ciclosarray);
        }

        if (isset($data['filtro_ciclos']) && is_array($data['filtro_ciclos'])) {
            foreach ($data['filtro_ciclos'] as $ciclo) {
                if ($ciclo != '') {
                    $this->db->where('viviendas_positivas.ciclo', $ciclo);
                }
            }
        } else {
            if ($data['filtro_ciclos'] != '') {
                $this->db->where('viviendas_positivas.ciclo', $data['filtro_ciclos']);
            }
        }

        $this->db->where('id_sede', (int) $data['id_sede']);
        $this->db->join('viviendas', 'viviendas.id_vivienda=viviendas_positivas.id_vivienda');
        $this->db->group_by('viviendas_positivas.id_vivienda');
        $this->db->group_by('viviendas_positivas.etapa');
        $this->db->group_by('viviendas_positivas.cantidad');
        $this->db->group_by('viviendas_positivas.id');
        $this->db->group_by('viviendas.id');

        $res = $this->db->get('viviendas_positivas')->result();
        $lq = $this->db->last_query();
        //dump($lq);
        //die;

        $result = array();
        foreach ($res as $r) {
            $result[$r->id_vivienda] = $r;
        }
        $final = array();
        foreach ($result as $re) {
            $final[] = $re;
        }

        return $final;
    }

    public function estaCargada($id_vivienda, $id_orden) {
        $this->db->where('id_vivienda', $id_vivienda);
        $this->db->where('id_orden', $id_orden);
        $r = $this->db->get('viviendas_inspeccion');
        if ($r->num_rows() > 0) {
            return true;
        }
    }

    public function getSedeByViviendaId($id_vivienda) {
        $this->db->select('id_sede');
        $this->db->where('id_vivienda', $id_vivienda);
        $r = $this->db->get('viviendas')->result();
        return $r;
    }

    /**
     * [guardaLista guarda ordenes de trabajo]
     * @return void
     */
    public function guardaLista() {
        $u = $_POST;
        $op = '';
        if (isset($u['operador'])) {
            if (is_array($u['operador'])) {
                foreach ($u['operador'] as $ope) {
                    $op .= '-' . $ope;
                }
            } else {
                $op = "sin seleccionar";
            }
        } else {
            $op = "sin seleccionar";
        }

        if ($u['fecha'] == '') {
            $fech = date('Y-m-d');
        } else {
            $fecha = explode("-", $u['fecha']);
            $fech = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
        }

        $data = array(
            'id_sede' => $u['sede'],
            'ciclo' => $u['ciclo'],
            'tipo' => $u['tipo'],
            'fecha_orden' => $fech,
            'operador' => $op,
            'observaciones' => $u['observaciones'],
            'orden' => $u['viviendas'],
            'quimico' => $u['quimico'],
            'aprobada' => 0,
            'fecha_aprob' => date('Y-m-d'),
        );
        $this->db->insert('ordenes', $data);
        redirect('/admin/ordenes/index');
    }

    /**
     * [getHabitantes trae la cantidad de habitantes de una vivienda segun la ultima inspeccion]
     * @param  [str] $idv [description]
     * @return int
     */
    public function getHabitantes($idv) {
        $this->db->where('id_vivienda', $idv);
        $this->db->order_by('id_inspeccion', 'desc');
        $this->db->limit(1);
        $res = $this->db->get('viviendas_inspeccion')->result();
        if (isset($res[0]->habitantes)) {
            return $res[0]->habitantes;
        } else {
            return "sin registrar";
        }
    }

}
