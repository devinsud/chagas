<?php

class Varios extends CI_Model {

    /**
     * function getItems
     * trae todos los items de una tabla
     * recibe un array con parametros
     * @param string tabla*
     * @param string campo_orden
     * @param string dir_orden
     * @param string campo_where
     * @param string valor_where
     * @param integer limite
     */
    function getItems($args=array()) {
        $arg = $args;
        $tabla = $arg['tabla'];
        $campo_orden = (isset($arg['campo_orden'])) ? $arg['campo_orden'] : '';
        $dir_orden = (isset($arg['dir_orden'])) ? $arg['dir_orden'] : 'asc';
        $campo_where = (isset($arg['campo_where'])) ? $arg['campo_where'] : '';
        $valor_where = (isset($arg['valor_where'])) ? $arg['valor_where'] : '';
        $limite = (isset($arg['limite'])) ? $arg['limite'] : '';
        if ($limite != '') { $this->db->limit($limite); }
        if ($campo_where != '' && $valor_where != '') { $this->db->where($campo_where, $valor_where); }
        if ($campo_orden != '') { $this->db->order_by($campo_orden, $dir_orden); }
        $Q = $this->db->get($tabla);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result() as $row) {
                $items[] = $row;
            }
        }
        if (isset($items)) { return $items; }
    }

    /**
     * function getItems
     * trae todos los items de una tabla
     * recibe un array con parametros
     * @param string tabla*
     * @param string campo_orden
     * @param string dir_orden
     * @param string campo_where
     * @param string valor_where
     * @param integer limite
     */
    function getItemsArray($args=array()) {
        $arg = $args;
        $tabla = $arg['tabla'];
        $campo_orden = (isset($arg['campo_orden'])) ? $arg['campo_orden'] : '';
        $dir_orden = (isset($arg['dir_orden'])) ? $arg['dir_orden'] : 'asc';
        $campo_where = (isset($arg['campo_where'])) ? $arg['campo_where'] : '';
        $valor_where = (isset($arg['valor_where'])) ? $arg['valor_where'] : '';
        $limite = (isset($arg['limite'])) ? $arg['limite'] : '';
        $campos = (isset($arg['campos'])) ? $arg['campos'] : '';
        if ($campos != '') { $this->db->select($campos); }
        if ($limite != '') { $this->db->limit($limite); }
        if ($campo_where != '' && $valor_where != '') { $this->db->where($campo_where, $valor_where); }
        if ($campo_orden != '') { $this->db->order_by($campo_orden, $dir_orden); }
        $Q = $this->db->get($tabla);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $items[] = $row;
            }
        }
        if (isset($items)) { return $items; }
    }

    /**
     * function getItem
     * trae todos los datos de un registro
     * recibe un array con parametros
     * @param string tabla
     * @param string campo
     * @param string valor
     */
    public function getItem($args = array()) {
        $arg = $args;
        $tabla = $arg['tabla'];
        $campo = $arg['campo'];
        $valor = $arg['valor'];
        $data = array($campo => $valor);
        $Q = $this->db->get_where($tabla, $data);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result() as $row) {
                $items = $row;
            }
        }
        if (isset($items)) { return $items; }
    }

    /**
     * function borraItem
     * borra un registro
     * recibe un array con parametros
     * @param string tabla
     * @param string campo
     * @param string valor
     */
    public function borraItem($args=array()) {
        $arg = $args;
        $tabla = $arg['tabla'];
        $campo = $arg['campo'];
        $valor = $arg['valor'];
        $data = array($campo => $valor);
        $this->db->delete($tabla, $data);
    }

     /**
     * function getItemsForDropdown
     * trae datos en formato para dropdown
     * recibe un array con parametros
     * @param string tabla*
     * @param string campo_orden
     * @param string dir_orden
     * @param string campo_where
     * @param string valor_where
     * @param integer limite
     */
    public function getItemsForDropdown($args=array()) {
        $arg = $args;
        $tabla = $arg['tabla'];
        $titulo = ($arg['campo_titulo']=='')?'titulo':$arg['campo_titulo'];
        $campo_orden = (isset($arg['campo_orden'])) ? $arg['campo_orden'] : '';
        $dir_orden = (isset($arg['dir_orden'])) ? $arg['dir_orden'] : 'asc';
        $campo_where = (isset($arg['campo_where'])) ? $arg['campo_where'] : '';
        $valor_where = (isset($arg['valor_where'])) ? $arg['valor_where'] : '';
        $limite = (isset($arg['limite'])) ? $arg['limite'] : '';
        if ($limite != '') { $this->db->limit($limite); }
        if ($campo_where != '' && $valor_where != '') { $this->db->where($campo_where, $valor_where); }
        if ($campo_orden != '') { $this->db->order_by($campo_orden, $dir_orden); }
        $Q = $this->db->get($tabla);
        foreach ($Q->result_array() as $row) {
            $data[$row['id']] = $row[$titulo];
        }
        return $data;
    }

    /**
     * function objectToArray
     * convierte un objeto en un array
     * recibe un array con parametros
     *
     * @param type $obj
     * @return array
     */
    function Obj2ArrRecursivo($Objeto) {
        if (is_object($Objeto)){ $Objeto = get_object_vars($Objeto); }
        if (is_array($Objeto)){
            foreach ($Objeto as $key => $value){
                $Objeto [$key] = $this->Obj2ArrRecursivo($Objeto [$key]);
            }
        }
        return $Objeto;
    }

    /**
     * function objectToArray
     * convierte un objeto en un array
     * recibe un array con parametros
     *
     * @param type $args
     *         path
     *         ancho
     *         alto
     *         tabla
     *         campo
     *         valor
     *         campo_imagen
     *
     * @return string
     */
    public function addImage($args=array()) {

        $path = $args['path'];
        $max_width = $args['ancho'];
        $max_height = $args['alto'];
        $tabla = $args['tabla'];
        $campo = (isset($args['campo'])) ? $args['campo'] : 'id';
        $valor = $args['valor'];
        $nombre_campo_imagen = (isset($args['campo_imagen'])) ? $args['campo_imagen'] : 'img';
        $campos = $args['campos'];
        $cont = 0;
        if ($_FILES['fileField']['name'] != "") {
            if ($_FILES['fileField']['name'] != "") {
                $this->load->library('upload');
                $_FILES['fileField']['name'] = str_replace(' ', '_', $_FILES['fileField']['name']);
                $cont += 1;
                $ahora = @strtotime("now");
                $exten = strrchr($_FILES['fileField']['name'], ".");
                $nomm = str_replace($exten, '', $_FILES['fileField']['name']);
                $nomm = str_replace(' ', '_', $_FILES['fileField']['name']);
                $nombre_ext = md5($nomm . '_' . $ahora . $cont) . $exten;
                $nombre = md5($nomm . '_' . $ahora . $cont);
                $asset_type = array(
                    'type' => 'image',
                    'mimes' => 'gif|jpg|png'
                );
                $config['file_name'] = $nombre;
                $config['upload_path'] = $path;
                $config['allowed_types'] = $asset_type['mimes'];
                $this->upload->initialize($config);
                $this->upload->do_upload('fileField');
                $property = getimagesize($path . $nombre_ext);
                if ($property[0] > $property[1]) {
                    $width = ceil($property[0] * $max_height / $property[1]);
                    $height = $max_height;
                } else {
                    $width = ceil($property[0] * $max_width / $property[1]);
                    $height = $max_width;
                }
                $config['image_library'] = 'gd2';
                $config['source_image'] = $path . $nombre_ext;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $width;
                $config['height'] = $height;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $data = array();
                foreach ($campos as $k => $v) {
                    $data[$k] = $this->input->post($v);
                }
                $data['path'] = $nombre_ext;
                if ($valor > 0) {
                    $this->db->where($campo, $valor);
                    $this->db->update($tabla, $data);
                } else {
                    $this->db->insert($tabla, $data);
                }
                $pp = $this->db->last_query();
                //var_dump($pp);
                return $nombre_ext;
            } else {
                foreach ($campos as $k => $v) {
                    $data[$k] = $this->input->post($v);
                }
                if ($valor > 0) {
                    $this->db->where($campo, $valor);
                    $this->db->update($tabla, $data);
                } else {
                    $this->db->insert($tabla, $data);
                }
                return false;
            }
        } else {
            foreach ($campos as $k => $v) {
                if($k!='tipo'){
                    $data[$k] = $this->input->post($v);
                }
            }
            if ($valor > 0) {
                $this->db->where($campo, $valor);
                $this->db->update($tabla, $data);
            } else {
                $this->db->insert($tabla, $data);
            }
            /*$ultimo = $this->db->last_query();
            dump($ultimo);die;*/
            return false;
        }
    }

    /**
     *   function create
     *   funcion plana de creacion de registros 
     *   basicamente la C de mi crud
     *   @author  Fabian Mesaglio <[email]>
     *   @param array $args array con los datos para crear el registro
     *   @param  string tabla la tabla en la que se agregara el registro
     *                  
     */
    public function create($args = array(), $tabla = ''){
        $this ->db->insert($tabla,$args);
    }

    /**
     *   function update
     *   funcion plana de edicion de registros 
     *   basicamente la U de mi crud
     *   @author  Fabian Mesaglio <[email]>
     *   @param array $args array con los datos para crear el registro
     *   @param  string tabla la tabla en la que se agregara el registro
     *   @param string campo_where nombre del campo contra el que voy a comparar por default id
     *   @param string valor_campo valor contra el que voy a comparar
     *                  
     */
    public function update($args = array(), $tabla = '', $campo_where='id', $valor_where){

        $this->db->where($campo_where, $valor_where);
        $this->db->update($tabla, $args);
    }

    /**
     * [email_exists verifica se un email existe en una tabla]
     * @param  string $tabla [la tabla en la que va a buscar]
     * @param  string $email [el email que va a buscar]
     * @return [bool]        [devuelve verdadero o falso]
     */
    public function email_exists($tabla='', $email='') {
        $data = array('email' => $email);
        $Q = $this->db->get_where($tabla, $data);
        if ($Q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * [formatTree funcion recursiva para armado de un arbol]
     * @param  [array] $tree   [description]
     * @param  [string]  $parent [description]
     * @return [array]         [description]
     */
    public function formatTree($tree, $parent) {
        $tree2 = array();
        foreach ($tree as $i => $item) {
            if ($item['id_seccion'] == $parent) {
                $tree2[$item['id']] = $item;
                $tree2[$item['id']]['submenu'] = $this->formatTree($tree, $item['id']);
            }
        }
        return $tree2;
    }

    public function tieneAdentro($id) {
        $args1 = array(
            'tabla' => 'secciones',
            'campo_orden' => 'orden',
            'dir_orden' => 'asc',
            'campo_where' => 'id_seccion',
            'valor_where' => $id
        );
        $tiene = $this->getItemsArray($args1);
        if (is_array($tiene) && count($tiene) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getGaleryType($id){
        $this->db->select('tipo');
        $this->db->where('id',$id);
        $tipo = $this->db->get('galerias')->result();
        return $tipo[0]->tipo;

    }

    public function arma_menu($tree, $parent, $datos='') {
        $datos2 = '';
        $datos2 .= $datos;
        $datos2 .= '<ul>';
        foreach ($tree as $i => $item) {
            if ($item['id_seccion'] == $parent) {
                if ($this->tieneAdentro($item['id'])) {
                    $datos2 .= '<li><span class="toggle" rel="' . base_url() . 'home/index/' . $item['seccion'] . '"  onclick="change(\'' . $item['titulo'] . '\',\'' . $item['seccion'] . '\')" >' . $item['titulo'] . '</span>';
                } else {

                    $datos2 .= '<li><a href="' . base_url() . 'home/index/' . $item['seccion'] . '" rel="' . $item['seccion'] . '" alt="' . $item['titulo'] . '"  id="item' . $item['id'] . '">' . $item['titulo'] . '</a>';
                    //$datos2 .= '<li><a href="'.base_url().'home/index/'.$item['seccion'].'" rel="'.$item['seccion'].'" onclick="change(\''.$item['titulo'].'\',\''.$item['seccion'].'\')" id="item'.$item['id'].'">'. $item['titulo'].'</a>';
                    //$datos2 .= '<li><a href="'.base_url().'secciones/get_secciones/'.$item['seccion'].'" rel="ajax" id="item'.$item['id'].'">'. $item['titulo'].'</a>';
                }
                $datos2 .= $this->arma_menu($tree, $item['id'], $datos);
                $datos2 .= '</li>';
            }
        }
        $datos2 .= '</ul>';
        //return $tree2;
        return $datos2;
    }

    /**
     * Cambia de estado el item que se le pase
     * @param <int> $id
     * @param <string> $tabla
     */
    function changeState($id, $tabla) {
        $arg = array('tabla'=>$tabla,'campo'=>'id','valor'=>$id);
        $item = $this->getItem($arg);
        if ($item->status == 'activo') {
            $data = array('status' => 'inactivo');
        } else if ($item->status == 'inactivo') {
            $data = array('status' => 'activo');
        }
        $this->db->where('id', $id);
        $this->db->update($tabla, $data);
    }

    /**
     * [fecha toma una fecha y la devuelve en formato mysql]
     * @param  [string] $fecha           [description]
     * @param  string $separador       [description]
     * @param  string $nuevo_separador [description]
     * @return [type]                  [description]
     */
    public function fecha($fecha, $separador='/', $nuevo_separador='-'){
        if(strlen($fecha)==10){
            $f = explode($separador,$fecha);
            $fecha = $f[2].$nuevo_separador.$f[1]-$nuevo_separador.$f[0];
            return $fecha;
        }

    }

}
