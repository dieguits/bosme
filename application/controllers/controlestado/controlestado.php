<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controlestado extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('menu/menu_model');
        $this->load->model('estado/estado_model');
        $this->load->model('controlestado/controlestado_model');
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
            'content' => 'controlestado/controlestado',
            'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/login.js"></script>',
            'titulo' => '<h2>BOSME</h2><p>BOLSA DE SOLICITUDES DE MERCADEO</p>',
            'controlador' => 'controlestado',
            'estados' => $this->estado_model->obtenerTodosEstados(),
            'idrol' => $this->session->userdata('idrol'),
            'clasebody' => 'top-navigation',
            'nomusua' => $this->session->userdata('nombres'),
            'showMenu' => FALSE,
            'menu' => $this->cargarMenu(),
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
     * Método para obtener las categorias de acuerdo a como las necesita la tabla.
     * 
     * @date 05/04/2016.
     * @author D4P.
     */
    public function obtenerControlEstados() {

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $filtro = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $data = $this->controlestado_model->obtenerTodosControlEstados();
        $datos = $this->controlestado_model->obtenerControlEstadosFiltrados($filtro);

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
    public function guardarControlEstado() {

        $data = array(
            'cod_old' => $this->input->post('cod_old'),
            'cod_new' => $this->input->post('cod_new'),
            'activo' => $this->input->post('activo'),
            'usuario' => $this->session->userdata('usuario')
        );

        $rpt = $this->controlestado_model->guardarControlEstado($data);

        echo $rpt;
    }

    /**
     * Método para actualizar estado.
     * 
     * @date 07/04/2016.
     * @author D4P.
     */
    public function actualizarControlEstado() {

        $data = array(
            'cod_new' => $this->input->post('cod_new'),
            'cod_old' => $this->input->post('cod_old'),
            'seq_nro' => $this->input->post('seq_nro'),
            'activo' => $this->input->post('activo'),
            'usuario' => $this->session->userdata('usuario')
        );

        $rpt = $this->controlestado_model->actualizarControlEstado($data);

        echo $rpt;
    }

}
?>


