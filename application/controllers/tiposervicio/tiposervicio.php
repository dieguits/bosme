<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tiposervicio extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('menu/menu_model');
        $this->load->model('proveedor/proveedor_model');
        $this->load->model('tiposervicio/tiposervicio_model');
    }

    /**
     * Método index de la clase del controlador login.
     *
     * @date 05/04/2016
     * @author Diego.Pérez.
     */
    public function index() {
        
        $this->load->helper('form');
        $datos = array(
            'content' => 'tiposervicio/tiposervicio',
            'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/login.js"></script>',
            'titulo' => '<h2>BOSME</h2><p>BOLSA DE SOLICITUDES DE MERCADEO</p>',
            'controlador' => 'tiposervicio',
            'proveedores' => $this->proveedor_model->obtenerProveedores(),
            'menu' => $this->cargarMenu(),
            'idrol' => $this->session->userdata('idrol'),
            'clasebody' => 'top-navigation',
            'nomusua' => $this->session->userdata('nombres'),
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
     * Método para obtener las categorias de acuerdo a como las necesita la tabla.
     * 
     * @date 05/04/2016.
     * @author D4P.
     */
    public function obtenerTipoServicio() {

        $draw = $this->input->post('draw');
        //$start = $this->input->post('start');
        //$length = $this->input->post('length');

        $filtro = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $data = $this->tiposervicio_model->obtenerTodosTipoServicio();
        $datos = $this->tiposervicio_model->obtenerTipoServicioFiltrados($filtro);

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
    public function guardarTipoServicio() {
        
        $data = array(
            'cod' => $this->input->post('cod'),
            'cod_old' => $this->input->post('cod_old'),
            'descri' => $this->input->post('descri'),
            'activo' => $this->input->post('activo'),
            'usuario' => $this->session->userdata('usuario'),
            'seq_nro' => $this->input->post('seq_nro'),
            'valor' => $this->input->post('valor'),
            'prove' => $this->input->post('prove')
        );
        
        $rpt = $this->tiposervicio_model->guardarTipoServicio($data);
        
        echo $rpt;
    }
    
    /**
     * Método para actualizar tipo de servicio.
     * 
     * @date 05/04/2016.
     * @author D4P.
     */
    public function actualizarTipoServicio() {
        
        $data = array(
            'cod' => $this->input->post('cod'),
            'cod_old' => $this->input->post('cod_old'),
            'descri' => $this->input->post('descri'),
            'activo' => $this->input->post('activo'),
            'usurio' => $this->session->userdata('usuario')
        );
        
        $rpt = $this->tiposervicio_model->actualizarCategoria($data);
        
        echo $rpt;
    }

}

?>


