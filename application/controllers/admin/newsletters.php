<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newsletters extends MY_Controller {

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
    }

    public function index() {
        $admin = $this->user->is_admin($this->session->userdata('id'));

        $data = array();
        $data['menusel'] = "newsletters";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/newsletters/listado';
        $data['col_derecha'] = 'admin/newsletters/col_derecha';
        $args = array('tabla' => 'newsletters', 'campo_orden' => 'id', 'dir_orden' => 'asc');
        $data['items'] = $this->varios->getItems($args);
        $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
        $this->load->view('admin/admin', $data);
    }

    public function crea() {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');
            $this->newsletter->registro($u);
            $this->session->set_flashdata('message', 'La newsletter se ha creado satisfactoriamente');
            redirect(base_url() . 'admin/newsletters/index', 'location');
        } else {

            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "newsletters";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/newsletters/form';
            $data['col_derecha'] = 'admin/newsletters/col_derecha';



            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function edita($id = 0) {
        $submit = $this->input->post('submit');
        if ($submit == "Guardar") {
            $u = $this->input->post('item');

            $this->newsletter->edicion($u);
            $this->session->set_flashdata('message', 'La newsletter se ha editado satisfactoriamente');
            redirect(base_url() . 'admin/newsletters/index', 'location');
        } else {

            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
            $data = array();
            $data['config'] = $this->config_editor;
            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "newsletters";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/newsletters/form_edit';
            $data['col_derecha'] = 'admin/newsletters/col_derecha';
            $args = array('tabla' => 'newsletters', 'campo' => 'id', 'valor' => $id);
            $data['item'] = $this->varios->getItem($args);
            $args = array('tabla' => 'newsletters', 'campo_orden' => 'id', 'dir_orden' => 'asc');

            $data['admin'] = $this->user->is_admin($this->session->userdata('id'));
            $this->load->view('admin/admin', $data);
        }
    }

    public function borra($id) {
        $args = array('tabla' => 'newsletters', 'campo' => 'id', 'valor' => $id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la newsletter ha sido eliminada');
        redirect(base_url() . 'admin/newsletters/index', 'location');
    }

    public function sorting() {
        $submit = $this->input->post('submit');
        if ($submit != '') {
            $order = explode(',', $this->input->post('sarasa'));
            foreach ($order as $key => $value) {
                $data = array('orden' => $key);
                $this->db->where('id', $value);
                $this->db->update('newsletters', $data);
            }
            redirect(base_url() . 'admin/newsletters/sorting/', 'refresh');
        } else {
            $data = array();
            $args = array(
                'tabla' => 'newsletters',
                'campo_orden' => 'orden',
                'dir_orden' => 'asc',
                'campo_where' => 'id_seccion',
                'valor_where' => 0
            );
            $data['items'] = $this->varios->getItems($args);

            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "newsletters";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/newsletters/sorting';
            $data['col_derecha'] = 'admin/newsletters/col_derecha';


            $this->load->view('admin/admin', $data);
        }
    }

    public function imagenes($id = 0) {
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;
        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => "../../assets/ckeditor/", 'outPut' => true));
        $data = array();
        $data['config'] = $this->config_editor;
        $args = array(
            'tabla' => 'assets_newsletter',
            'campo_orden' => 'id',
            'dir_orden' => 'asc',
            'campo_where' => 'id_newsletter',
            'valor_where' => $id
        );
        $data['items'] = $this->varios->getItems($args);
        //var_dump($data['items']);die;
        $args = array('tabla' => 'newsletters', 'campo' => 'id', 'valor' => $id);
        $data['item'] = $this->varios->getItem($args);
        $admin = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "newsletters";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/newsletters/imagenes';
        $data['col_derecha'] = 'admin/newsletters/col_derecha';


        $this->load->view('admin/admin', $data);
    }

    public function add_imagen() {
        $args = array(
            'path' => './assets/imagenes/',
            'ancho' => 900,
            'alto' => 300,
            'tabla' => 'assets_newsletters',
            'campo' => 'id',
            'valor' => 0,
            'campos' => array('copete' => 'copete', 'link' => 'link', 'id_newsletter' => 'id_newsletter')
        );



        $this->varios->addImage($args);
        redirect(base_url() . 'admin/newsletters/imagenes/' . $this->input->post('id_newsletter'), 'refresh');
    }

    public function borra_imagen_rotador($id = 0, $id_sec = 0) {
        $args = array('tabla' => 'assets_newsletters', 'campo' => 'id', 'valor' => $id);
        $item = $this->varios->getItem($args);

        if (is_file('./assets/imagenes/' . $item->path)) {
            unlink('./assets/imagenes/' . $item->path);
        }
        $args = array('tabla' => 'assets_newsletters', 'campo' => 'id', 'valor' => $id);
        $this->varios->borraItem($args);
        $this->session->set_flashdata('message', 'la imagen ha sido eliminada');
        redirect(base_url() . 'admin/newsletters/imagenes/' . $id_sec, 'location');
    }

    public function galeria($id = 0) {
        $data = array();
        $args = array(
            'tabla' => 'galeria_secciones',
            'campo_orden' => 'id',
            'dir_orden' => 'asc',
            'campo_where' => 'id_sec',
            'valor_where' => $id
        );
        $data['items'] = $this->varios->getItems($args);
        $args = array('tabla' => 'secciones', 'campo' => 'id', 'valor' => $id);
        $data['item'] = $this->varios->getItem($args);
        $admin = $this->user->is_admin($this->session->userdata('id'));
        $data['menusel'] = "secciones";
        $data['menu_top'] = 'admin/menu_top';
        $data['menu_iz'] = 'admin/menu_iz';
        $data['listado'] = 'admin/secciones/rotador';
        $data['col_derecha'] = 'admin/secciones/col_derecha';


        $this->load->view('admin/admin', $data);
    }

    public function enviar($id = 0) {
        $submit = $this->input->post('submit');
        if ($submit == "Enviar") {
            $this->load->library('email');
            $u = $this->input->post('item');
            $args1 = array('tabla' => 'newsletters', 'campo' => 'id', 'valor' => $u['id']);
            $item = $this->varios->getItem($args1);
            $email['title'] = $item->titulo;

            $texto = str_replace('src="/comarcas/assets/', 'src="http://localhost/comarcas/assets/', $item->texto);
            $email['content'] = $texto;


            $message = $this->load->view('admin/newsletters/newsletter', $email, TRUE); // include the HTML code before send

            $config['mailtype'] = 'html';

            $this->email->initialize($config);

            $this->email->from('enerone@gmail.com');
            $this->email->to('enerone@gmail.com');

            $pp = $this->email->print_debugger();


            $this->load->view('admin/newsletters/newsletter', $email);

            //$u = $this->input->post('item');
            //$this->newsletter->envio($u);
            // $this->session->set_flashdata('message', 'El newsletter se ha enviado satisfactoriamente');
            //redirect(base_url() . 'admin/newsletters/index', 'location');
        } else {

            $args = array(
                'tabla' => 'barrios',
                'campo_orden' => 'id',
                'dir_orden' => 'asc'
            );
            $data['barrios'][] = 'Todos';
            $data['barrios'] = $this->varios->getItemsForDropdown($args);


            $args1 = array('tabla' => 'newsletters', 'campo' => 'id', 'valor' => $id);
            $data['item'] = $this->varios->getItem($args1);


            $admin = $this->user->is_admin($this->session->userdata('id'));
            $data['menusel'] = "newsletters";
            $data['menu_top'] = 'admin/menu_top';
            $data['menu_iz'] = 'admin/menu_iz';
            $data['listado'] = 'admin/newsletters/envia';
            $data['col_derecha'] = 'admin/newsletters/col_derecha';
            $this->load->view('admin/admin', $data);
        }
    }

}
