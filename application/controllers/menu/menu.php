<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('menu/menu_model');
    }

    /**
     * Método index de la clase del controlador login.
     *
     * @date 04/03/2016
     * @author Diego.Pérez.
     */
    public function index() {
        $this->load->helper('form');
        $datos = array(
            'content' => 'menu/menu',
            'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/login.js"></script>',
            'titulo' => '<h2>BOSME</h2><p>BOLSA DE SOLICITUDES DE MERCADEO</p>',
            'controlador' => 'menu',
            'menus' => $this->ObtenerMenuPadres(),
            'idrol' => $this->session->userdata('idrol'),
            'clasebody' => 'top-navigation',
            'nomusua' => $this->session->userdata('nombres'),
            'menu' => $this->cargarMenu(),
            'showMenu' => FALSE
        );

        $this->load->view('template/layout', $datos);
    }
    
    /**
     * Método para cargar menu de aplicación.
     * 
     * @date 11/04/2016.
     * @author D4P.
     */
    public function cargarMenu() {

        $data = array(
            'rol' => $this->session->userdata('idrol'),
            'nivel' => '1',
            'subnivel' => false
        );

        $rpt['menuspadres'] = $this->menu_model->dibujarMenu($data);

        $data1 = array(
            'rol' => $this->session->userdata('idrol'),
            'nivel' => '2',
            'subnivel' => true
        );

        $rpt['menushijos'] = $this->menu_model->dibujarMenu($data1);

        $htmlrow = $this->load->view("menu/menu_din", $rpt, TRUE);

        return $htmlrow;
    }

    /**
     * Método para obtener los menus a los cuales pueden pertener los submenus.
     * 
     * @date 08/04/2016.
     * @author D4P.
     */
    public function ObtenerMenuPadres() {

        $rpt = $this->menu_model->ObtenerMenuPadres();

        return $rpt;
    }

    /**
     * Método para obtener las categorias de acuerdo a como las necesita la tabla.
     * 
     * @date 05/04/2016.
     * @author D4P.
     */
    public function obtenerMenus() {

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $filtro = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $data = $this->menu_model->obtenerTodosMenus();
        $datos = $this->menu_model->obtenerMenusFiltrados($filtro);

        $rpt['draw'] = $draw;
        $rpt['recordsTotal'] = count($data);
        $rpt['recordsFiltered'] = count($data);
        $rpt['data'] = $datos;

        echo json_encode($rpt);
    }

    /**
     * Método para guardar una nueva categoria.
     * 
     * @date 05/04/2016.
     * @author D4P.
     */
    public function guardarMenu() {

        $data = array(
            'descri' => $this->input->post('descri'),
            'nivel' => $this->input->post('nivel'),
            'subnivel' => $this->input->post('subnivel'),
            'orden' => $this->input->post('orden'),
            'ruta' => $this->input->post('ruta'),
            'activo' => $this->input->post('activo'),
            'usuario' => $this->session->userdata('usuario')
        );

        $rpt = $this->menu_model->guardarMenu($data);

        echo $rpt;
    }

    /**
     * Método para actualizar el usuario.
     * 
     * @date 06/04/2016.
     * @author D4P.
     */
    public function actualizarMenu() {

        $data = array(
            'descri' => $this->input->post('descri'),
            'seq' => $this->input->post('seq'),
            'nivel' => $this->input->post('nivel'),
            'subnivel' => $this->input->post('subnivel'),
            'orden' => $this->input->post('orden'),
            'ruta' => $this->input->post('ruta'),
            'activo' => $this->input->post('activo'),
            'usuario' => $this->session->userdata('usuario')
        );

        $rpt = $this->menu_model->actualizarMenu($data);

        echo $rpt;
    }
    
    /**
     * Método para pintar el menu padre de la aplicación.
     * 
     * @date 11/04/2016.
     * @author D4P.
     */
    public function dibujarMenuPadre() {
        
        $data = array(
            'rol' => $this->session->userdata('idrol'),
            'nivel' => '1',
            'subnivel' => 'IS NULL'
        );
        
        $rpt = $this->menu_model->dibujarMenu($data);
    }

}

?>
