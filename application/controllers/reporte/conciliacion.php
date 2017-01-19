<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Conciliacion extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('menu/menu_model');
        $this->load->model('categoria/categoria_model');
        $this->load->model('proveedor/proveedor_model');
        $this->load->model('servicio/servicio_model');
        $this->load->model('solicitud/solicitud_model');
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
            'content' => 'reporte/conciliacion',
            'script' => '<script type="text/javascript" src="' . base_url() . 'public/js/conciliacion.js"></script>',
            'titulo' => '<h2>BOSME</h2><p>BOLSA DE SOLICITUDES DE MERCADEO</p>',
            'controlador' => 'conciliacion',
            'proveedores' => $this->proveedores(),
            'menu' => $this->cargarMenu(),
            'idrol' => $this->session->userdata('idrol'),
            'clasebody' => 'top-navigation',
            'nomusua' => $this->session->userdata('nombres'),
            'showMenu' => FALSE
        );

        $this->load->view('template/layout', $datos);
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
     * Método para cargar menu de aplicación.
     * 'menu' => $this->cargarMenu(),
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
    public function generar() {

        $draw = $this->input->post('draw');
        //$start = $this->input->post('start');
        //$length = $this->input->post('length');

        $filtro = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length'),
            'codprove' => $this->input->post('codprove'),
            'fechaini' => $this->input->post('fechaini'),
            'fechafin' => $this->input->post('fechafin'),
            'nro_soli' => $this->input->post('nro_soli')
        );
        //echo json_encode($filtro);
        $data = $this->servicio_model->reporteConciliacion($filtro);
        $datos = $this->servicio_model->reporteConciliacionFiltrado($filtro);

        $rpt['draw'] = $draw;
        $rpt['recordsTotal'] = count($data);
        $rpt['recordsFiltered'] = count($data);
        $rpt['data'] = $datos;

        echo json_encode($rpt);
    }

    /**
     * Método para obtener el numero de la solicitud por el Proveedor seleccionado.
     * 
     * @date 25/04/2016.
     * @author D4P.
     */
    public function nroSolicitudProveedor() {

        $codProvee = $this->input->post('codprove');

        $rpt = $this->servicio_model->serviciosSolicitudReporte($codProvee);

        echo json_encode($rpt);
    }

    /**
     * Función para generar PDF con la libreria DomPdf.
     *
     * @date 26/04/2016.
     * @author D4P.
     */
    public function generarPdf() {
        
        $filtro = array(
            'codprove' => $this->input->post('codprove'),
            'fechaini' => $this->input->post('fechaini'),
            'fechafin' => $this->input->post('fechafin'),
            'nro_soli' => $this->input->post('nro_soli')
        );
        
        $data = array(
            'datos' => $this->servicio_model->reporteConciliacion($filtro),
            'fechaini' => $this->input->post('fechaini'),
            'fechafin' => $this->input->post('fechafin'),
            'proveedor' => $this->solicitud_model->descripcionProveedor($filtro['codprove'])->NOMBREC,
            'admin' => $this->solicitud_model->descripcionAdministrador($filtro['nro_soli'])->NOMBREC
        );
        //$vista = utf8_decode($this->load->view('../pdf', $data, true));
        //$rpt_data = $this->servicio_model->reporteConciliacion($filtro);
        //echo json_encode($data['datos']);
        $this->load->library('html2pdf');

        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();
        
        //importante el slash del final o no funcionará correctamente
        $this->html2pdf->folder('./public/docs/pdfs/');
        
        //establecemos el nombre del archivo
        $filename = 'concilia'.date('d_m_y_h:i').'.pdf';
        $this->html2pdf->filename($filename);
        
        //establecemos el tipo de papel
        $this->html2pdf->paper('letter', 'portrait');
        
        //echo $vista;
        //hacemos que coja la vista como datos a imprimir
        //importante utf8_decode para mostrar bien las tildes, ñ y demás
        $vista = $this->load->view("pdf_1", $data, true);
        $this->html2pdf->html(utf8_decode($vista));
        //echo "por aca paso";
        if ($this->html2pdf->create('save')) {
            //se muestra el pdf
            
            $this->show($filename);
            //echo "<script language='javascript'>window.print();</javascript>";
            //echo base_url();
        }else {
            echo "No se ha podido generar el pdf";
        }
    }

    /**
     * Función para mostrar el pdf en pantalla.
     *
     * @date 26/04/2016.
     * @author D4P.
     */
    public function show($filename) {
        /*if (is_dir("./files/pdfs")) {
            $filename = "test.pdf";
            $route = base_url("files/pdfs/test.pdf");
            echo $route;
            if (file_exists("./files/pdfs/" . $filename)) {
                header('Content-type: application/pdf');
                readfile($route);
            }
        }*/
        
        if (is_dir("./public/docs/pdfs")) {
            //$filename = "concilia.pdf";
            $route = base_url("public/docs/pdfs/".$filename);
            
            echo $route;
            if (file_exists("./public/docs/pdfs/" . $filename)) {
                //header('Content-type: application/pdf');
                //readfile("./public/docs/pdfs/" . $filename);
            }
        }
    }

    /**
     * Función para crear foldel de donde se va a crear el pdf.
     *
     * @date 26/04/2016.
     * @author D4P.
     */
    private function createFolder() {
        /*if (!is_dir("./files")) {
            mkdir("./files", 0777);
            mkdir("./files/pdfs", 0777);
        }*/
        
        if (!is_dir("./public/docs/pdfs")) {
            
            //mkdir("./public/docs", 0777);
            mkdir("./public/docs/pdfs", 0777);
        }
    }

}

?>
