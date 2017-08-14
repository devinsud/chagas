<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ordenes extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->config_editor = array();
        //indicamos la ruta para ckFinder
        $this->config_editor['filebrowserBrowseUrl'] = base_url() . "assets/ckeditor/kcfinder/browse.php";
        // indicamos la ruta para el boton de la toolbar para subir imagenes
        $this->config_editor['filebrowserImageBrowseUrl'] = base_url() . "assets/ckeditor/kcfinder/browse.php?type=images";
        // indicamos la ruta para subir archivos desde la pestaña de la toolbar (Quick Upload)
        $this->config_editor['filebrowserUploadUrl'] = base_url() . "assets/ckeditor/kcfinder/upload.php?type=files";
        // indicamos la ruta para subir imagenesdesde la pestaña de la toolbar (Quick Upload)
        $this->config_editor['filebrowserImageUploadUrl'] = base_url() . "assets/ckeditor/kcfinder/upload.php?type=images";
        $this->config_editor['toolbar'] = array(
            array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'),
            array('Image', 'Link', 'Unlink', 'Anchor')
        );
        $this->load->model('vivienda');
        $this->load->model('lugar');
        $this->load->model('relacion');
        $this->load->model('barrio');
        $this->load->model('ciclo');
        $this->load->model('operador');
        $this->load->model('orden');
    }

    /**
     * [index muestra un listado con todas las ordenes de la sede]
     * @param  integer $id_sede [description]
     * @return [type]           [description]
     */
    public function index($id_sede = 1) {
        $data = array();
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['menusel'] = "ordenes";
        $data['listado'] = 'admin/ordenes/listado';
        $data['sede'] = $id_sede;
        $data['sedes'] = $this->vivienda->getSedes();
        $data['items'] = $this->orden->getOrdenes($id_sede);
        $this->load->view('admin/admin_n', $data);
    }

    public function carga_inspeccion($orden) {
        $orden = (int) $orden;
        $data = array();
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['menusel'] = "ordenes";
        $data['listado'] = 'admin/viviendas/listado_carga_inspec';
        $data['id_orden'] = $orden;

        $data['items'] = $this->vivienda->getViviendasByOrder($orden);
        $this->load->view('admin/admin_n', $data);
    }

    public function getCicloByIdOrden($id_orden) {
        $id_orden = (int) $id_orden;

        $this->db->where('id', $id_orden);
        $r = $this->db->get('ordenes')->result();

        return $r[0]->ciclo;
    }

    /**
     * [procesar muestra una lista de todas las viviendas procesadas mediante una orden de trabajo]
     * @param  [type] $id_orden [description]
     * @return [type]           [description]
     */
    public function procesar($id_orden) {
        $id_orden = (int) $id_orden;
        $data['orden'] = $this->orden->getOrdenById($id_orden);
        $data['menusel'] = "ordenes";
        $data['listado'] = 'admin/ordenes/procesar';
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [asientaRociado controller para agregar datos sobre el rociado de cada vivienda]
     * @param  [type] $idv      [description]
     * @param  [type] $id_orden [description]
     * @return [type]           [description]
     */
    public function asientaRociado($idv, $id_orden) {

        $id_orden = (int) $id_orden;
        $data['vivienda'] = $idv;
        $data['orden'] = $id_orden;
        $data['datos_orden'] = $this->orden->getOrdenById($id_orden);
        $data['menusel'] = "ordenes";
        $data['listado'] = 'admin/ordenes/asentar';
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [verDatos trae los datos de lo sucedido con el rociado de una vivienda en una orden determinada]
     * @param  [string] $idv
     * @param  [int] $orden
     * @return [view]
     */
    public function verDatos($idv, $orden) {
        $id_orden = (int) $orden;
        $data['vivienda'] = $idv;
        $data['orden'] = $id_orden;
        $data['datos'] = $this->orden->getDatos($orden, $idv);
        $data['menusel'] = "ordenes";
        $data['listado'] = 'admin/ordenes/verDatos';
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [verDatos trae los datos de lo sucedido con el rociado de una vivienda en una orden determinada]
     * @param  [string] $idv
     * @param  [int] $orden
     * @return [view]
     */
    public function verDatosTratadas($idv, $orden) {
        $id_orden = (int) $orden;
        $data['vivienda'] = $idv;
        $data['orden'] = $id_orden;
        $data['datos'] = $this->orden->getDatos($orden, $idv);
        $data['menusel'] = "ordenes";
        $data['listado'] = 'admin/ordenes/verDatosTratadas';
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $this->load->view('admin/admin_n', $data);
    }

    /**
     * [asienta guarda los datos particulares del rociado en cada vivienda]
     *
     */
    public function asienta() {
        $this->orden->asienta();
        $orden = $this->input->post('orden');
        redirect(base_url() . 'admin/ordenes/procesar/' . $orden, 'location');
    }

    /**
     * [observaciones guarda observaciones sobre la vivienda]
     * @return [type] [description]
     */
    public function observaciones() {
        $idv = $this->input->post('idv');
        $this->vivienda->guardaObservacion();
        redirect(base_url() . 'admin/viviendas/verVivienda/' . $idv, 'location');
    }

    /**
     * [vista_previa pagina aparte de para imprimir la lista de trabajos]
     * @return view
     */
    public function ver($id = 0) {
        $id = (int) $id;
        $data = array();
        $orden = $this->orden->getOrdenById($id);
        $data['orden'] = $orden[0];
        $data['tipo'] = $orden[0]->tipo;
        $data['observaciones'] = $orden[0]->observaciones;
        $data['fecha'] = $orden[0]->fecha;
        $operadores = explode('-', $orden[0]->operador);
        $data['operadores'] = array();

        foreach ($operadores as $operador) {
            if ($operador != '') {
                $ope = $this->operador->getOperador($operador);
                if (is_object($ope)) {
                    $data['operadores'][] = $ope->apellido . ', ' . $ope->nombre;
                }
            }
        }
        $data['id'] = $id;
        $data['super'] = $this->super;
        $viviendas = explode('-', $orden[0]->orden);
        $data['menusel'] = "ordenes";
        $data['ciclo'] = $this->orden->getNombreCiclo($orden[0]->ciclo);
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['listado'] = 'admin/ordenes/vp2';
        $data['sede'] = 1;
        $data['viviendas'] = $viviendas;
        //$this->vivienda->rociado($viv);
        $this->load->view('admin/admin_orden_view1', $data);
    }

    public function ver2($id = 0) {
        $id = (int) $id;
        $data = array();
        $orden = $this->orden->getOrdenById($id);
        
       
        $data['orden'] = $orden[0];
        $data['tipo'] = $orden[0]->tipo;
        $data['observaciones'] = $orden[0]->observaciones;
        $data['fecha'] = $orden[0]->fecha;
        $operadores = explode('-', $orden[0]->operador);
        $data['operadores'] = array();

        foreach ($operadores as $operador) {
            if ($operador != '') {
                $ope = $this->operador->getOperador($operador);
                if (is_object($ope)) {
                    $data['operadores'][] = $ope->apellido . ', ' . $ope->nombre;
                }
            }
        }
        $data['id'] = $id;
        $data['super'] = $this->super;
        $viviendas = explode('-', $orden[0]->orden);
         $vivienda=0;
         $contador=0;
         foreach ($viviendas as $ornd) {
                  $vivienda=$ornd;
               
             $contador++;

          }
          $getViviendaById=null;
          if($vivienda!=0){
            $getViviendaByIdBarrio=$this->vivienda->getViviendaByIdBarrio($vivienda);
          }
                 
        $data['menusel'] = "ordenes";
        $data['ciclo'] = $this->orden->getNombreCiclo($orden[0]->ciclo);
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['listado'] = 'admin/ordenes/vp1';
        $data['sede'] = 1;
        $data["barrio"]=$getViviendaByIdBarrio;
        $data['viviendas'] = $viviendas;
        //$this->vivienda->rociado($viv);
        $this->load->view('admin/admin_orden_view1', $data);
    }

    /**
     * [vista_previa pagina aparte de para imprimir la lista de trabajos]
     * @return view
     */
    public function imprimir($id = 0) {
        $id = (int) $id;
        $data = array();
        $orden = $this->orden->getOrdenById($id);
        $data['orden'] = $orden[0];
        $data['tipo'] = $orden[0]->tipo;
        $data['observaciones'] = $orden[0]->observaciones;
        $data['fecha'] = $orden[0]->fecha;
        $data['id'] = $id;
        $data['super'] = $this->super;
        $viviendas = explode('-', $orden[0]->orden);
        $data['menusel'] = "ordenes";
        $data['admin'] = $this->admin; //this admin vive en My_Controller
        $data['menu_top'] = $this->menu;
        $data['listado'] = 'admin/ordenes/vp';
        $data['sede'] = 1;
        $data['viviendas'] = $viviendas;
        //$this->vivienda->rociado($viv);
        $this->load->view('admin/admin_orden_print', $data);
    }

    /**
     * [aprueba_orden permite que un superusuario marque una orden como aprobada]
     * @param  [type] $id [description]
     * @return void
     */
    public function aprueba_orden($id) {
        $this->orden->aprueba($id);
        redirect(base_url() . 'admin/ordenes/index', 'location');
    }

    /**
     * [aprueba_orden permite que un superusuario marque una orden como aprobada]
     * @param  [type] $id [description]
     * @return void
     */
    public function elimina_orden($id) {
        $this->orden->elimina($id);
        redirect(base_url() . 'admin/ordenes/index', 'location');
    }

}

//class end bracket
