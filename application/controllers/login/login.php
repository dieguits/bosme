<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('login/login_model');
        $this->load->model('usuario/usuario_model');
        $this->load->model('categoria/categoria_model');
        $this->load->model('proveedor/proveedor_model');
        $this->load->model('estado/estado_model');
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
            'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/login.js"></script>',
            'titulo' => '<h2>BOSME</h2><p>BOLSA DE SOLICITUDES DE MERCADEO</p>',
            'controlador' => 'login',
            'clasebody' => 'gray-bg',
            'showMenu' => FALSE
        );

        $nuevosdatos = array(
            'usuario' => '',
            'nombres' => '',
            'correo' => '',
            'idrol' => '',
            'ingresado' => FALSE
        );

        $this->session->set_userdata($nuevosdatos);

        $this->load->view('login/login', $datos);

        //$this->load->view('login/login');
    }

    public function pruebaLogin() {
        //$postdata = file_get_contents("php://input");
        //$request = json_decode($postdata);

        /*$data = array(
            'codusuario' => $request->idusuario,
            'clave' => $request->clave
        );
        
        echo json_encode($data);*/
        
        echo "Ingresamos bien";
    }

    /**
     * Función para validar si el usuario puede ingresar o no.
     *
     * @date 08/03/2016.
     * @author D4P.
     */
    public function validar_ingreso() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $data = array(
            'codusuario' => $request->idusuario,
            'clave' => $request->clave
        );

        //echo json_encode($data);
        $rpt = $this->login_model->vaidar_ingreso($data);

        if ($rpt->RPT == 'S') {
            //Se obtiene los datos del usuario logueado
            $result = $this->login_model->obtenerUsuarioByCodUsuario($data);

            //Se crea un arreglo para ingresar en session.
            $nuevosdatos = array(
                'usuario' => $result->COD_USUA,
                'nombres' => $result->NOMBREC,
                'correo' => $result->CORREO,
                'idrol' => $result->COD_ROL,
                'ingresado' => TRUE
            );

            $this->session->set_userdata($nuevosdatos);

            if ($this->session->userdata('idrol') == 'ADM') {
                //echo "Solicitud";
                $datos = array('content' => 'solicitud/solicitud',
                    'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/solicitud.js"></script>',
                    //'solicitudes' => $this->solicitud_model->obtenerSolicitudes(),
                    'titulo' => 'CONTROL SOLICITUDES',
                    'controlador' => 'solicitud',
                    'idrol' => $this->session->userdata('idrol'),
                    'usuarios' => $this->usuario_model->getUsuarios(),
                    'categorias' => $this->categoria_model->obtenerCategorias(),
                    //'showMenu' => TRUE,
                    'clasebody' => 'top-navigation',
                    'nomusua' => $this->session->userdata('nombres')
                );
            } else {
                //echo "Servicio";
                $datos = array('content' => 'servicio/solservicio',
                    'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/solservicio.js"></script>',
                    'titulo' => 'BOSME<br>CREACION DE SOLICITUD DE SERVICIO',
                    'controlador' => 'solservicio',
                    'proveedores' => $this->proveedores(),
                    'estados' => $this->estados($data),
                    'menu' => $this->cargarMenu(),
                    'clasebody' => 'top-navigation',
                    'idrol' => $this->session->userdata('idrol'),
                    'nomusua' => $this->session->userdata('nombres')
                );
            }

            //$this->load->view('template/layout', $datos);

            $respuesta = array(
                'ingreso' => 'S',
                'idrol' => $result->COD_ROL
            );
        } else {
            $respuesta = array('ingreso' => 'N');
        }

        echo json_encode($respuesta);
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
     * Método para obtener los estados de los servicios.
     * 
     * @date 22/03/2016.
     * @author D4P.
     */
    public function estados($data) {

        $rpt = $this->estado_model->obtenerEstados($data);

        return $rpt;
    }

    /**
     * Método para obtener los proveedores relacionados con la solicitud.
     *
     * @date 16/03/2016.
     * @author D4P.
     */
    public function proveedores() {

        $rpt = $this->proveedor_model->obtenerProveedores();

        return $rpt;
    }

    /**
     * Método para salir de la aplicación.
     * 
     * @date 06/04/2016.
     * @D4P.
     */
    public function logout() {

        $nuevosdatos = array(
            'usuario' => '',
            'nombres' => '',
            'correo' => '',
            'idrol' => '',
            'ingresado' => FALSE
        );

        $this->session->unset_userdata($nuevosdatos);
        session_destroy();
        redirect(base_url());
    }

    /**
     * Método para recuperar clave.
     * 
     * @date 07/04/2016.
     * @author D4P.
     */
    public function recuperarClave() {

        $idusuario = $this->input->post('idusuario');

        $rpt = $this->login_model->recuperarClave($idusuario);

        echo $rpt;
    }

    public function probarConexion() {
        //echo "hasta aca todo bien";

        $prueba = $this->login_model->pruebaObtener();

        echo $prueba;
    }

}

?>