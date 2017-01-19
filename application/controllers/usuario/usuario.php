<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('menu/menu_model');
        $this->load->model('rol/rol_model');
        $this->load->model('usuario/usuario_model');
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
            'content' => 'usuario/usuario',
            'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/login.js"></script>',
            'titulo' => '<h2>BOSME</h2><p>BOLSA DE SOLICITUDES DE MERCADEO</p>',
            'controlador' => 'usuario',
            'roles' => $this->obtenerRoles(),
            'menu' => $this->cargarMenu(),
            'usuarios' => $this->usuario_model->getUsuariosSinRol(),
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
    public function obtenerUsuarios() {

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $filtro = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $data = $this->usuario_model->obtenerTodosUsuarios();
        $datos = $this->usuario_model->obtenerUsuariosFiltrados($filtro);

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
    public function guardarUsuario() {
        
        $data = array(
            'cod' => $this->input->post('cod'),
            'cod_old' => $this->input->post('cod_old'),
            'rol' => $this->input->post('rol'),
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'correo' => $this->input->post('correo'),
            'clave' => $this->input->post('clave'),
            'activo' => $this->input->post('activo'),
            'usuario' => $this->session->userdata('usuario'),
            'usrback' => $this->input->post('usrback') == '-1' ? '' : $this->input->post('usrback')
        );
        //echo json_encode($data);
        $rpt = $this->usuario_model->guardarUsuario($data);
        
        echo $rpt;
    }
    
    /**
     * Método para actualizar el usuario.
     * 
     * @date 06/04/2016.
     * @author D4P.
     */
    public function actualizarUsuario() {
        
        if($this->input->post('usrback') == '-1') {
            $usr_backup = '';
        }else {
            $usr_backup = $this->input->post('usrback');
        }
            
        
        $data = array(
            'cod' => $this->input->post('cod'),
            'cod_old' => $this->input->post('cod_old'),
            'rol' => $this->input->post('rol'),
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'correo' => $this->input->post('correo'),
            'clave' => $this->input->post('clave'),
            'activo' => $this->input->post('activo'),
            'usuario' => $this->session->userdata('usuario'),
            'usrback' => $usr_backup
        );
        
        $rpt = $this->usuario_model->actualizarUsuario($data);
        
        echo $rpt;//.' - '.  json_encode($data);
    }
    
    /**
     * Método para listar los roles del sistema.
     * 
     * @return array con el listado de roles.
     * @date 06/04/2016.
     * @author D4P.
     */
    public function obtenerRoles() {
        
        $rpt = $this->rol_model->obtenerRoles();
        
        return $rpt;
    }

}

?>
