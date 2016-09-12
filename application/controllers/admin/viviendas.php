<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Viviendas extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->config_editor = array();
		//indicamos la ruta para ckFinder
		$this->config_editor['filebrowserBrowseUrl'] = base_url()."assets/ckeditor/kcfinder/browse.php";
		// indicamos la ruta para el boton de la toolbar para subir imagenes
		$this->config_editor['filebrowserImageBrowseUrl'] = base_url()."assets/ckeditor/kcfinder/browse.php?type=images";
		// indicamos la ruta para subir archivos desde la pestaña de la toolbar (Quick Upload)
		$this->config_editor['filebrowserUploadUrl'] = base_url()."assets/ckeditor/kcfinder/upload.php?type=files";
		// indicamos la ruta para subir imagenesdesde la pestaña de la toolbar (Quick Upload)
		$this->config_editor['filebrowserImageUploadUrl'] = base_url()."assets/ckeditor/kcfinder/upload.php?type=images";
		$this->config_editor['toolbar']                   = array(
			array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'),
			array('Image', 'Link', 'Unlink', 'Anchor')
		);
		$this->load->model('vivienda');
		$this->load->model('lugar');
		$this->load->model('relacion');
		$this->load->model('barrio');
		$this->load->model('ciclo');
		$this->load->model('operador');
	}

	/**
	 * [index listado de viviendas]
	 * @param  integer $id_sede
	 * @return view
	 */
	public function index($id_sede = 1) {
		$data             = array();
		$data['admin']    = $this->admin;//this admin vive en My_Controller
		$data['menu_top'] = $this->menu;
		$data['menusel']  = "viviendas";
		$data['listado']  = 'admin/viviendas/selector';
		$data['sede']     = $id_sede;
		$data['barrios']  = $this->barrio->getBarrios();
		$data['sedes']    = $this->vivienda->getSedes();

		$this->load->view('admin/admin_n', $data);
	}

	/**
	 * [index listado de viviendas]
	 * @param  integer $id_sede
	 * @return view
	 */
	public function vvdas($id_sede = 1, $barrio = 0) {

		$u                = $this->input->post();
		$data             = array();
		$data['admin']    = $this->admin;//this admin vive en My_Controller
		$data['menu_top'] = $this->menu;
		$data['menusel']  = "viviendas";
		$data['listado']  = 'admin/viviendas/listado';
		$data['sede']     = $id_sede;
		$data['barrio']   = $this->barrio->getbarrioId($u['barrio']);
		$data['sedes']    = $this->vivienda->getSedes();
		$data['items']    = $this->vivienda->getViviendasByBarrio($u['barrio']);
		$this->load->view('admin/admin_n', $data);
	}

	/**
	 * [index listado de viviendas rociadas]
	 * @param  integer $id_sede
	 * @return view
	 */
	public function rociadas($id_sede = 1) {
		$data             = array();
		$data['admin']    = $this->admin;//this admin vive en My_Controller
		$data['menu_top'] = $this->menu;
		$data['menusel']  = "rociadas";
		$data['listado']  = 'admin/viviendas/listado_rociadas';
		$data['sede']     = $id_sede;
		$data['sedes']    = $this->vivienda->getSedes();
		$data['items']    = $this->vivienda->getViviendasRociadas($id_sede);
		$this->load->view('admin/admin_n', $data);
	}

	/**
	 * [listas creacion de ordenes de trabajo]
	 * @param  integer $id_sede
	 * @return view
	 */
	public function listas($id_sede = 1) {
		$data               = array();
		$id_sede            = (int) $id_sede;
		$data['admin']      = $this->admin;//this admin vive en My_Controller
		$data['menu_top']   = $this->menu;
		$data['menusel']    = "ordenes";
		$data['listado']    = 'admin/viviendas/listas_ambos';
		$data['sede']       = $id_sede;
		$data['ciclos']     = $this->ciclo->getCiclosBySede($id_sede);
		$data['items']      = $this->vivienda->getViviendasBySedeParaListas($id_sede);
		$data['barrios']    = $this->barrio->getBarriosBySede($id_sede);
		$data['operadores'] = $this->operador->getOperadoresBySede($id_sede);
		$this->load->view('admin/admin_n', $data);
	}

	/**
	 * [vista_previa pagina aparde de para imprimir la lista de trabajos]
	 * @return view
	 */
	public function vista_previa() {
		$viv = $this->input->post('viviendas');
		$this->vivienda->guardaLista();
		$data                  = array();
		$data['tipo']          = $this->input->post('tipo');
		$data['observaciones'] = $this->input->post('observaciones');
		$data['fecha']         = $this->input->post('fecha');
		$operadores            = $this->input->post('operador');
		$data['operadores']    = array();
		//dump($operadores);
		die;
		if (isset($operadores) && is_array($operadores)) {
			foreach ($operadores as $operador) {
				$ope                  = $this->operador->getOperador($operador);
				$data['operadores'][] = $ope->apellido.', '.$ope->nombre;
			}
		}
		$viviendas       = explode('-', $viv);
		$data['menusel'] = "viviendas";
		$data['ciclo']   = $this->ciclo->getcicloId($this->input->post('ciclo'));
		//dump($data['ciclo']);
		$data['admin']     = $this->admin;//this admin vive en My_Controller
		$data['menu_top']  = $this->menu;
		$data['listado']   = 'admin/viviendas/vp';
		$data['sede']      = 1;
		$data['viviendas'] = $viviendas;
		$this->vivienda->rociado($viv);
		$this->load->view('admin/admin_vp', $data);
	}

	/**
	 * [observaciones manda a guardar observaciones]
	 * @return void
	 */
	public function observaciones() {
		$idv = $this->input->post('idv');
		$this->vivienda->guardaObservacion();
		redirect(base_url().'admin/viviendas/verVivienda/'.$idv, 'location');

	}

	/**
	 * [verVivienda muestra la vivienda con sus detalles]
	 * @param  string $idv
	 * @return view
	 */
	public function verVivienda($idv) {
		$data             = array();
		$data['menusel']  = "viviendas";
		$data['admin']    = $this->admin;//this admin vive en My_Controller
		$data['menu_top'] = $this->menu;
		$data['listado']  = 'admin/viviendas/vivienda';
		$data['sede']     = 1;

		$data['items'] = $this->vivienda->getViviendaById($idv);
		$data['jefe']  = $this->vivienda->getUltimoJefedeFamilia($data['items'][0]->id_vivienda);

		$data['idv']          = $idv;
		$data['inspecciones'] = $this->vivienda->getInspecciones($data['items'][0]->id_vivienda);
		$data['grupo']        = $this->vivienda->getGrupo($data['items'][0]->id_vivienda);
		$this->load->view('admin/admin_n', $data);
	}

	/**
	 * [editarInspeccion modificacion de datos de inspeccion]
	 * @param  integer $id_inspeccion
	 * @param  string $idv
	 * @return view
	 */
	public function editarInspeccion($idv = 0, $orden = 0, $ciclo = 0) {
		$submit = $this->input->post('submit');
		if ($submit == "Guardar") {
			$idv = $this->input->post('idv');
			$this->vivienda->edicion_inspeccion();
			$item = $this->input->post('item');
			$this->session->set_flashdata('message', 'Los resultados se ha editado satisfactoriamente');
			redirect(base_url().'admin/ordenes/carga_inspeccion/'.$item['orden'], 'location');
		} else {

			$data             = array();
			$data['usuario']  = $this->session->userdata('id');
			$data['lugares']  = $this->lugar->getLugares();
			$args             = array('tabla' => 'sedes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
			$data['lugares']  = $this->lugar->getLugares();
			$data['sedes']    = $this->varios->getItems($args);
			$data['menusel']  = "viviendas";
			$data['admin']    = $this->admin;//this admin vive en My_Controller
			$data['menu_top'] = $this->menu;
			$data['listado']  = 'admin/viviendas/form_inspeccion_edit';
			$data['sede']     = 1;

			$data['item'] = $this->vivienda->getDatosInspeccion($idv, $orden);

			$data['ciclo_orden']   = $ciclo;
			$data['orden']         = $orden;
			$data['id_inspeccion'] = $data['item']->id_inspeccion;
			$data['jefe']          = $this->vivienda->getUltimoJefedeFamilia($data['item']->id_vivienda);
			$data['ciclos']        = $this->ciclo->getCiclosBySede($data['item']->id_sede);
			$data['operadores']    = $this->operador->getOperadoresBySede($data['item']->id_sede);
			$data['positivas']     = $this->vivienda->getPositivasByCicloYVivienda($data['item']->ciclo, $data['item']->id_vivienda);
			$data['idv']           = $idv;
			$this->load->view('admin/admin_n', $data);
		}
	}

	/**
	 * [delPos elimina desde el historial un positiva]
	 * @param  integer $id_inspeccion
	 * @param  integer $idv
	 * @param  integer $idPos
	 * @return void
	 */
	public function delPos($id_inspeccion, $idv, $idPos) {
		$id_inspeccion = (int) $id_inspeccion;
		$idv           = (int) $idv;
		$idPos         = (int) $idPos;
		$this->vivienda->delPos($idPos);
		redirect(base_url().'admin/viviendas/editarInspeccion/'.$id_inspeccion.'/'.$idv, 'location');
	}

	/**
	 * [lab formulario de resoluciones de laboratorio]
	 * @param  integer $id
	 * @return view
	 */
	public function lab($id) {
		$id               = (int) $id;
		$data             = array();
		$data['menusel']  = "viviendas";
		$data['admin']    = $this->admin;//this admin vive en My_Controller
		$data['menu_top'] = $this->menu;
		$data['listado']  = 'admin/viviendas/lab';
		$data['sede']     = 1;
		$data['items']    = $this->vivienda->getViviendaById($id);
		$data['lab']      = $this->vivienda->getLab($data['items'][0]->id_vivienda);
		$this->load->view('admin/admin_n', $data);
	}

	/**
	 * [edita_lab edita los datos cargados en laboratorio]
	 * @param  integer $id
	 * @param  integer $idv
	 * @return view
	 */
	public function edita_lab($id = 0, $idv = 0) {
		$submit = $this->input->post('submit');
		if ($submit == "Guardar") {
			$u = $this->input->post('item');
			$this->vivienda->edicion_lab($u);
			$this->session->set_flashdata('message', 'Los resultados se ha editado satisfactoriamente');
			redirect(base_url().'admin/viviendas/lab/'.$u['idv'], 'location');
		} else {
			$id               = (int) $id;
			$data             = array();
			$data['usuario']  = $this->session->userdata('id');
			$data['lugares']  = $this->lugar->getLugares();
			$data['menusel']  = "viviendas";
			$data['admin']    = $this->admin;//this admin vive en My_Controller
			$data['menu_top'] = $this->menu;
			$data['listado']  = 'admin/viviendas/form_lab';
			$data['sede']     = 1;
			$data['items']    = $this->vivienda->getViviendaById($idv);
			$data['idv']      = $idv;
			$data['lab']      = $this->vivienda->getLabItem($id);
			$this->load->view('admin/admin_n', $data);
		}
	}

	/**
	 * [eliminaInspeccion baja de una inspeccion ( desde el historial )]
	 * @param  integer $id_inspeccion [description]
	 * @param  integer $id_vivienda   [description]
	 * @return view
	 */
	public function eliminaInspeccion($id_inspeccion, $id_vivienda) {
		$id_inspeccion = (int) $id_inspeccion;
		$id_vivienda   = (int) $id_vivienda;
		$this->vivienda->borraInspeccion($id_inspeccion, $id_inspeccion);
		redirect(base_url().'admin/viviendas/verVivienda/'.$id_vivienda, 'location');
	}

	/**
	 * [eliminaPositiva elimina hallazgos]
	 * @param  integer $id_positiva
	 * @param  integer $id_vivienda
	 * @return void
	 */
	public function eliminaPositiva($id_positiva, $id_vivienda) {

		$id_vivienda = (int) $id_vivienda;
		$id_positiva = (int) $id_positiva;
		$this->vivienda->borraPositiva($id_positiva);
		redirect(base_url().'admin/viviendas/verVivienda/'.$id_vivienda, 'location');

	}

	/**
	 * [eliminaGrupo elimina un miembro del grupo familiar de la vivienda ( desde el historial)]
	 * @param  integer $id_grupo
	 * @param  integer $id_vivienda
	 * @return void
	 */
	public function eliminaGrupo($id_grupo, $id_vivienda) {

		$id_vivienda = (int) $id_vivienda;
		$id_grupo    = (int) $id_grupo;
		$this->vivienda->borraMiembroGrupo($id_grupo);
		redirect(base_url().'admin/viviendas/verVivienda/'.$id_vivienda, 'location');

	}

	/**
	 * [crea alta viviendas]
	 * @return view
	 */
	public function crea() {
		$submit = $this->input->post('submit');
		if ($submit == "Guardar") {
			$this->vivienda->registro();
			$this->session->set_flashdata('message', 'La vivienda se agreg&oacute; correctamente');
			redirect(base_url().'admin/viviendas/index', 'location');
		} else {
			$data             = array();
			$data['config']   = $this->config_editor;
			$data['menusel']  = "viviendas";
			$data['admin']    = $this->admin;//this admin vive en My_Controller
			$data['menu_top'] = $this->menu;
			$data['listado']  = 'admin/viviendas/form';
			$args             = array('tabla' => 'sedes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
			$data['sedes']    = $this->varios->getItems($args);
			$data['sede']     = 1;
			$this->load->view('admin/admin_n', $data);
		}
	}

	/**
	 * [edita modificacion viviendas]
	 * @param  integer $id [description]
	 * @return view
	 */
	public function edita($id = 0) {
		$submit = $this->input->post('submit');
		if ($submit == "Guardar") {
			$u = $this->input->post('item');
			$this->vivienda->edicion($u);
			$this->session->set_flashdata('message', 'La vivienda se ha editado satisfactoriamente');
			redirect(base_url().'admin/viviendas/index', 'location');
		} else {
			$data             = array();
			$data['config']   = $this->config_editor;
			$admin            = $this->user->is_admin($this->session->userdata('id'));
			$data['menusel']  = "viviendas";
			$data['menu_top'] = 'admin/menu';
			$data['listado']  = 'admin/viviendas/form_edit';
			$args             = array('tabla' => 'viviendas', 'campo' => 'id', 'valor' => $id);
			$data['item']     = $this->varios->getItem($args);
			$args             = array('tabla' => 'sedes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
			$data['sedes']    = $this->varios->getItems($args);
			$data['sede']     = 1;
			$data['admin']    = $this->user->is_admin($this->session->userdata('id'));
			$this->load->view('admin/admin_n', $data);
		}
	}

	/**
	 * [inspeccion alta de inspeccion en viv[description]
	 * @return view
	 */
	public function inspeccion($id = 0, $orden = 0, $ciclo = 0) {
		$submit = $this->input->post('submit');

		if ($submit == "Guardar") {
			$todo = $this->input->post();

			$u = $this->input->post('item');

			$this->vivienda->inspeccion($u);
			//dump($u);
			$this->session->set_flashdata('message', 'La vivienda se ha editado satisfactoriamente');
			redirect(base_url().'admin/ordenes/carga_inspeccion/'.$u['orden'], 'location');
		} else {
			$data             = array();
			$data['config']   = $this->config_editor;
			$data['menusel']  = "viviendas";
			$data['admin']    = $this->admin;//this admin vive en My_Controller
			$data['menu_top'] = $this->menu;
			$data['listado']  = 'admin/viviendas/form_inspeccion';

			$args         = array('tabla' => 'viviendas', 'campo' => 'id_vivienda', 'valor' => $id);
			$data['item'] = $this->varios->getItem($args);

			$data['ciclos']      = $this->ciclo->getCiclosBySede($data['item']->id_sede);
			$data['ciclo_orden'] = $ciclo;
			$data['orden']       = $orden;

			$data['operadores'] = $this->operador->getOperadoresBySede($data['item']->id_sede);
			$args               = array('tabla' => 'sedes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
			$data['lugares']    = $this->lugar->getLugares();
			$data['sedes']      = $this->varios->getItems($args);
			$data['usuario']    = $this->session->userdata('id');
			$this->load->view('admin/admin_n', $data);
		}
	}

	/**
	 * [grupo alta de miembro de familia en vivienda]
	 * @param  integer $id
	 * @return view
	 */
	public function grupo($id = 0) {
		$submit = $this->input->post('submit');

		if ($submit == "Guardar") {
			$todo = $this->input->post();
			//dump($todo);
			die;
			$u = $this->input->post('item');
			$this->vivienda->vivienda_grupo($u);
			$this->session->set_flashdata('message', 'La vivienda se ha editado satisfactoriamente');
			redirect(base_url().'admin/viviendas/index', 'location');
		} else {
			$data               = array();
			$data['config']     = $this->config_editor;
			$data['menusel']    = "viviendas";
			$data['admin']      = $this->admin;//this admin vive en My_Controller
			$data['menu_top']   = $this->menu;
			$data['listado']    = 'admin/viviendas/form_grupo';
			$args               = array('tabla' => 'viviendas', 'campo' => 'id', 'valor' => $id);
			$data['item']       = $this->varios->getItem($args);
			$data['ciclos']     = $this->ciclo->getCiclosBySede($data['item']->id_sede);
			$args               = array('tabla' => 'sedes', 'campo_orden' => 'id', 'dir_orden' => 'asc');
			$data['relaciones'] = $this->relacion->getRelaciones();
			$data['sedes']      = $this->varios->getItems($args);
			$this->load->view('admin/admin_n', $data);
		}
	}

	/**
	 * [borra baja de viviendas]
	 * @param  integer $id
	 * @return void
	 */
	public function borra($id, $id_vivienda) {

		$args = array('tabla' => 'viviendas', 'campo' => 'id', 'valor' => $id);
		$this->varios->borraItem($args);
		$this->vivienda->sanitiza_base_cuando_elimina_vivienda($id_vivienda);
		$this->session->set_flashdata('message', 'La vivienda ha sido eliminada');
		redirect(base_url().'admin/viviendas/index', 'location');
	}

	public function borrabulk() {
		$ids = array(
			'001001261',
			'001002320',
			'001004081',
			'001004401',
			'001004441',
			'001004571',
			'001005251',
			'001005261',
			'001005300',
			'001005310',
			'001005311',
			'001005320',
			'001005330',
			'001005340',
			'001005350',
			'001005351',
			'001005360',
			'001005370',
			'001005371',
			'001005380',
			'001005390',
			'001005400',
			'001005401',
		);

		foreach ($ids as $id) {
			$this->vivienda->sanitiza_base_cuando_elimina_vivienda($id);
			echo '-'.$id.'-';
		}

	}

	/**
	 * [getBarrioById devuelve barrio por id y sede]
	 * @param  integer $id
	 * @param  integer $sede
	 * @return json
	 */
	public function getBarrioById($id = 0, $sede = 0) {
		$barrio = $this->barrio->getBarrioById($id, $sede);
		if ($barrio != 'no existe') {
			echo json_encode($barrio);
		} else {
			echo json_encode('no existe');
		}
	}

	/**
	 * [getBarrioByCodigo devuelve barrio por codigo]
	 * @param  integer $cod  [description]
	 * @param  integer $sede [description]
	 * @return [type]        [description]
	 */
	public function getBarrioByCodigo($cod = 0, $sede = 0) {
		$this->db->where('codigo', $cod);
		$res = $this->db->get('barrios')->result();
		return $res[0];
	}

	/**
	 * [imp SCRIPT DE IMPORTACION DE DATOS]
	 * @return [type] [description]
	 */
	public function imp($id_barrio, $tipo, $ceros) {
		$res = $this->db->get('vivi')->result();
		$a   = 0;
		foreach ($res as $r) {
			$cod = substr($r->id_vivienda, 0, 3);
			//$barrio = $this->getBarrioByCodigo($cod);

			$data = array(
				'id_vivienda' => $ceros.$r->id_vivienda,
				'latitud'     => $r->latitud,
				'longitud'    => $r->longitud,
				'id_barrio'   => $id_barrio,
				'id_sede'     => 1,
				'tipo'        => 'urbano',
			);
			$this->db->insert('viviendas', $data);
			$a++;
			echo $a.'-';
		}

	}

	/**
	 * [agregaManzana script para agregar manzanas al final de la tabla]
	 * @return [type] [description]
	 */
	public function agregaManzana() {
		$res = $this->db->get('viviendas')->result();
		foreach ($res as $r) {
			$man  = substr($r->id_vivienda, 3, 3);
			$data = array('id_manzana' => $man);
			$this->db->where('id_vivienda', $r->id_vivienda);
			$this->db->update('viviendas', $data);
			dump($r->id_vivienda);
		}

	}

	public function backup() {
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup = &$this->dbutil->backup();

		// Load the file helper and write the file to your server
		$ahora       = date('Ymd');
		$path_arch   = '../../../assets/img/backup_'.$ahora.'_db_msano.gz';
		$nombre_arch = 'backup_'.$ahora.'_db_msano.gz';
		$this->load->helper('file');
		write_file($path_arch.$nombre_arch, $backup);

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($nombre_arch, $backup);

	}

	public function importaCSV() {
		$csv_file = base_url()."archivo.csv";// Name of your CSV file
		$csvfile  = fopen($csv_file, 'r');
		$theData  = fgets($csvfile);
		$i        = 0;
		while (!feof($csvfile)) {
			$csv_data[] = fgets($csvfile, 1024);
			$csv_array  = explode(",", $csv_data[$i]);
			$insert_csv = array();

			$char_count = strlen($csv_array[0]);

			if ($char_count < 9) {
				$cat_de_ceros_a_agregar = 9-$char_count;
				$vv                     = '';
				for ($a = 1; $a < ($cat_de_ceros_a_agregar+1); $a++) {
					$vv .= '0';
				}
				$vv1 = $vv.$csv_array[0];
			}

			$insert_csv['id_vivienda'] = $vv1;
			$insert_csv['latitud']     = substr_replace($csv_array[1], '.', 3, 0);
			$insert_csv['longitud']    = substr_replace($csv_array[2], '.', 3, 0);
			$insert_csv['id_barrio']   = 59;
			$insert_csv['id_sede']     = 1;
			$insert_csv['tipo']        = 'rural';

			dump($insert_csv);
			$this->db->insert('viviendas', $insert_csv);

			$i++;
		}
		echo $i;
		fclose($csvfile);
	}

	public function correccion() {
		$this->db->where('vigilancia_entomologica', 'positiva');
		$q = $this->db->get('viviendas_inspeccion')->result();
		$t = 0;
		foreach ($q as $i) {
			$t++;
			$this->db->where('id_inspeccion', $i->id_inspeccion);
			$this->db->limit(1);
			$vp    = $this->db->get('viviendas_positivas')->result();
			$fecha = $vp[0]->fecha_positiva;

			$this->db->where('id_inspeccion', $i->id_inspeccion);
			$data = array('fecha_inspeccion' => $fecha);
			$this->db->update('viviendas_inspeccion', $data);
			echo $t.'<br>';
		}

	}

	public function correccion1() {
		$this->db->where('fecha_inspeccion', '0000-00-00');
		$q = $this->db->get('viviendas_inspeccion')->result();
		$t = 0;
		foreach ($q as $i) {
			$t++;
			$this->db->where('id_vivienda', $i->id_vivienda);
			$this->db->limit(1);
			$vp    = $this->db->get('viviendas_grupo')->result();
			$fecha = $vp[0]->fecha;

			$this->db->where('id_inspeccion', $i->id_inspeccion);
			$data = array('fecha_inspeccion' => $fecha);
			$this->db->update('viviendas_inspeccion', $data);
			echo $t.'<br>';
		}

	}

	public function agrega_orden() {
		$this->db->order_by('fecha_orden', 'asc');
		$ordenes = $this->db->get('ordenes')->result();
		$cop     = 0;
		foreach ($ordenes as $o) {
			if ($o->tipo == 'Inspección') {
				$vivs     = explode('-', $o->orden);
				$id_orden = $o->id;
				foreach ($vivs as $v) {

					$this->db->where('id_vivienda', $v);
					$this->db->where('ciclo', $o->ciclo);
					$re = $this->db->get('viviendas_inspeccion')->result();

					if (count($re) != 0) {

						$data = array('id_orden' => $id_orden);
						$this->db->where('id_inspeccion', $re[0]->id_inspeccion);
						$this->db->update('viviendas_inspeccion', $data);

					} else {
						dump('vivienda: '.$v.' id_orden: '.$id_orden.' fecha_orden: '.$o->fecha_orden);
						$cop++;
						dump($cop);
					}
				}
			}
		}

	}

	public function agrega_orden_pos() {
		$this->db->order_by('fecha_orden', 'asc');
		$ordenes = $this->db->get('ordenes')->result();
		$cop     = 0;
		foreach ($ordenes as $o) {
			if ($o->tipo == 'Inspección') {
				$vivs     = explode('-', $o->orden);
				$id_orden = $o->id;
				foreach ($vivs as $v) {

					$this->db->where('id_vivienda', $v);
					$this->db->where('ciclo', $o->ciclo);
					$re = $this->db->get('viviendas_positivas')->result();

					if (count($re) != 0) {

						$data = array('id_orden' => $id_orden);
						$this->db->where('id_inspeccion', $re[0]->id_inspeccion);
						$this->db->update('viviendas_inspeccion', $data);

						$this->db->where('id_inspeccion', $re[0]->id_inspeccion);
						$this->db->where('ciclo', $o->ciclo);
						$this->db->update('viviendas_positivas', $data);

					} else {
						dump('vivienda: '.$v.' id_orden: '.$id_orden.' fecha_orden: '.$o->fecha_orden);
						$cop++;
						dump($cop);
					}

				}
			}
		}

	}

	public function correccion2() {
		$this->db->where('id_barrio', 59);
		$res = $this->db->get('viviendas')->result();
		$a   = 0;
		foreach ($res as $r) {
			$a++;
			$datos = array(
				'latitud'  => str_replace('..', '.', $r->latitud),
				'longitud' => str_replace('..', '.', $r->longitud)
			);

			$this->db->where('id_vivienda', $r->id_vivienda);
			$this->db->update('viviendas', $datos);
		}

		echo "listo ".$a;
	}

	public function correccion3() {
		$this->db->where('id_barrio', 59);
		$res = $this->db->get('viviendas')->result();
		$a   = 0;
		foreach ($res as $r) {
			$a++;
			$datos = array(

				'longitud' => $r->longitud+'',
			);

			$this->db->where('id_vivienda', $r->id_vivienda);
			$this->db->update('viviendas', $datos);
		}

		echo "listo ".$a;
	}

	public function arreglo($codigo, $id) {
		$this->db->where('id_barrio', $codigo);
		$data = array(
			'id_barrio' => $id,
		);
		$this->db->update('viviendas', $data);
		echo "listo ".$codigo." a ".$id;
	}

}//class end bracket
