<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Solicitud extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('solicitud/solicitud_model');
        $this->load->model('usuario/usuario_model');
        $this->load->model('servicio/servicio_model');
        $this->load->model('categoria/categoria_model');
        $this->load->model('menu/menu_model');
    }

    /**
     * Método index de la clase del controlador login.
     *
     * @date 10/03/2016
     * @author Diego.Pérez.
     */
    public function index() {
        $this->load->helper('form');
        $datos = array('content' => 'solicitud/solicitud',
            'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/solicitud.js"></script>',
            'titulo' => 'BOSME<br>BOLSA DE SOLICITUDES DE MERCADEO',
            'controlador' => 'solicitud',
            'idrol' => $this->session->userdata('idrol'),
            'usuarios' => $this->obtenerUsuarios(),
            'menu' => $this->cargarMenu(),
            'categorias' => $this->obtenerCategorias(),
            'clasebody' => 'top-navigation',
            'nomusua' => $this->session->userdata('nombres')
        );

        $this->load->view('template/layout', $datos);

        //$this->load->view('login/login');
    }

    /**
     * Método para realizar la busqueda del contrato.
     *
     * @date 14/03/2016.
     * @author D4P.
     */
    public function buscar() {

        $busqueda = $this->input->post('term');
        
        echo json_encode($this->solicitud_model->getSolicitudBySearch($busqueda));
    }

    /**
     * Método para validar si la orden escogida existe en la base de solicitudes local.
     *
     * @date 14/03/2016.
     * @author D4P.
     */
    public function validarOrden() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        //echo json_encode($data);
        $rpt = $this->solicitud_model->vaidarNroOrden($request->nro_orden);
    }

    /**
     * Método para agregar una solicitud a la base de datos de BOSME.
     * 
     * @date 14/03/2016.
     * @author D4P.
     */
    public function agregarSolicitud() {

        $valortotal = str_replace(',', '.', str_replace('.', '', str_replace('$', '', $this->input->post('valorBolsa'))));
        //echo $valortotal.' - '.$this->input->post('valorBolsa');
        $nombrecompleto = $this->input->post('nombrecontacto');

        $nombresplit = explode(' ', $nombrecompleto);

        $nombre = '';
        $apellido = '';

        if (count($nombresplit) == 3) {
            $nombre = $nombresplit[0];
            $apellido = $nombresplit[1] . ' ' . $nombresplit[2];
        } else if (count($nombresplit) > 3) {
            $nombre = $nombresplit[0] . ' ' . $nombresplit[1];
            $apellido = $nombresplit[2] . ' ' . $nombresplit[3];
            if(count($nombresplit) > 3) {
                $apellido = $apellido .' '.$nombresplit[4];
            }
        } else if (count($nombresplit) == 2) {
            $nombre = $nombresplit[0];
            $apellido = $nombresplit[1];
        }

        $data = array(
            'cod_usr_prov' => $this->input->post('cod_usr_proveedor'),
            'nro_orden' => $this->input->post('nro_orden'),
            'valortotal' => $valortotal,
            'categoria' => $this->input->post('categoria'),
            'fecha_vence' => $this->input->post('fecha_entrega'),
            'usr_resp' => $this->input->post('selectusuario'),
            'codProveedor' => $this->input->post('idProveedor'),
            'idusuario' => $this->session->userdata('usuario'),
            'activo' => 'S',
            'nombre_proveedor' => $nombre,
            'apellido_proveedor' => $apellido,
            'correo_proveedor' => $this->input->post('correocontacto'),
            'chiva' => $this->input->post('chiva') === '1' ? 'S' : 'N',
            'nro_sol' => $this->input->post('nro_solicitud')
        );
        //echo json_encode($data);
        $rpt = $this->solicitud_model->agregarSolicitud($data);
        //$this->envio();
        echo $rpt; /* json_encode(.' - '..' - '..' - '.' - '..' - '.$usr_resp; */
    }

    /**
     * Método para obtener los usuarios que pueden administrar bolsas.
     *
     * @date 14/03/2016.
     * @author D4P.
     */
    public function obtenerUsuarios() {

        $usuarios = $this->usuario_model->getUsuarios();

        return $usuarios;
    }

    /**
     * Método para obtener los servicios por el proveedor.
     * 
     * @date 22/03/216.
     * @author D4P.
     */
    public function servicios() {

        $data = array(
            'nro_solicitud' => $this->input->post('nro_solicitud')
        );

        $rpt['servicios'] = $this->servicio_model->servicioPorSolicitud($data);

        $htmlrow = $this->load->view("solicitud/solicitud_row_ins", $rpt, TRUE);

        echo $htmlrow;

        /* $datarpt['inve'] = $this->inventario_model->getInventarioById($result);
          //var_dump($datarpt['inve']);

          $html_row = $this->load->view("inventario/inventario_row_view", $datarpt, TRUE);
          echo $html_row; */
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
     * Método para obtener los servicios registrados para la solicitud seleccionada.
     * 
     * @date 07/04/2016.
     * @author D4P. 
     */
    public function obtenerDatos() {

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $filtro = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length'),
            'nro_solicitud' => $this->input->post('nro_solicitud')
        );

        $data = $this->servicio_model->servicioPorSolicitud($filtro);
        $datos = $this->servicio_model->servicioPorSolicitudFiltrado($filtro);

        $rpt['draw'] = $draw;
        $rpt['recordsTotal'] = count($data);
        $rpt['recordsFiltered'] = count($data);
        $rpt['data'] = $datos;

        echo json_encode($rpt);
    }

    /**
     * Método para obtener las categorias de la solicitud.
     * 
     * @return $categorias las categorias para la solicitud.
     * @date 30/03/2016.
     * @author D4P.
     */
    public function obtenerCategorias() {

        $categorias = $this->categoria_model->obtenerCategorias();

        return $categorias;
    }

}

?>