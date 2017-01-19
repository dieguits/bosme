<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Solservicio extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('proveedor/proveedor_model');
        $this->load->model('servicio/servicio_model');
        $this->load->model('solicitud/solicitud_model');
        $this->load->model('estado/estado_model');
        $this->load->model('menu/menu_model');
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
        $data = '';

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

        $this->load->view('template/layout', $datos);

        //$this->load->view('login/login');
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
     * Método para obtener los tipos de servicios.
     *
     * @date 16/03/2016.
     * @author D4P.
     */
    public function tipoServicios($data) {

        $rpt = $this->servicio_model->obtenerTipoServicios($data);

        return $rpt;
    }

    /**
     * Método para obtener los valores de la bolsa.
     *
     * @date 16/03/2016, 28/03/2016.
     * @author D4P.
     */
    public function valorBolsaSolicitud() {

        $data = array(
            'codprove' => $this->input->post('codprove'),
            'nro_sol' => $this->input->post('nro_sol'),
            'nro_orden' => $this->input->post('nro_orden')
        );


        $tabla = array(
            'datos' => $this->solicitud_model->obtenerSolicitudValor($data),
            //'servicios' => $this->serviciosProveedor($valor),
            'tipo_servicios' => $this->tipoServicios($data['codprove'])
        );

        echo json_encode($tabla);
    }

    /**
     * Método para crear una solicitud de un servicio para una Solicitud con nro de orden especifica.
     *
     * @date 16/03/2016.
     * @author D4P.
     */
    public function registrarSolServicio() {

        $isarchivo = $this->input->post('isarchivo');
        $moveResult = 1;
        $nombreArchivo = '';
        if ($isarchivo == '1') {

            $archivo = isset($_FILES['archivo-0']) ? $_FILES['archivo-0'] : null;
            $url = '../bosme/public/docs/';

            $fileN = $archivo["name"]; // The file name
            $kaboom = explode(".", $fileN);
                        
            $pos_ext = count($kaboom) - 1;
            $nom_extension = strtolower($kaboom[$pos_ext]);
            
            $archivo["name"] = $this->session->userdata('usuario') . '_' . $this->input->post('seq_nro_sol') . '_' . time() . '.' . $nom_extension;
            $fileName = $archivo["name"];
            $nombreArchivo = $archivo["name"];

            $ext_validas = array('jpg','jpeg', 'png', 'pdf', 'doc', 'docx', 'txt', 'cvs', 'xls', 'zip', 'mp3', 'wav', 'wma', 'cda', 'mp4', 'xlsx');
            
            if (file_exists($url . $archivo["name"])) {
                echo "EL archivo seleccionado ya existe en la base de datos";
            } else {
                if (!$archivo['error']) {

                    if (in_array($nom_extension, $ext_validas)) {

                        $fileTmpLoc = $archivo["tmp_name"]; // File in the PHP tmp folder
                        $fileType = $archivo["type"]; // The type of file it is
                        $fileSize = $archivo["size"]; // File size in bytes
                        $fileErrorMsg = $archivo["error"]; // 0 for false... and 1 for true
                        // Split file name into an array using the dot
                        //$fileExt = end($kaboom);

                        $moveResult = move_uploaded_file($fileTmpLoc, $url . $fileName);

                        //echo "resultado-> ".$moveResult;
                    } else {
                        echo "El archivo seleccionado no cumple con los parametros.";
                    }
                } else {
                    echo "ERROR";
                }
            }
        }

        //=====================================================================//
        if ($moveResult) {

            $data = array(
                'nro_solicitud' => $this->input->post('seq_nro_sol'),
                'cod_tipo_servicio' => $this->input->post('tipServicio'),
                'estado' => $this->input->post('slcMovimiento'),
                'fecha_solicita' => $this->input->post('fechareq'),
                'valor' => str_replace(',', '.', str_replace('.', '', str_replace('$', '', $this->input->post('valor')))), //$this->input->post('valor')
                'cantidad' => $this->input->post('canti'),
                'fecha_servicio' => $this->input->post('fechaser'),
                'nro_factura' => $this->input->post('facnro'),
                'comision' => $this->input->post('comi'),
                'fecha_radicado' => $this->input->post('radifac'),
                'observaciones' => $this->input->post('descripcion'),
                'cod_usr_solicita' => $this->session->userdata('usuario'),
                'activo' => $this->input->post('activo'),
                'idusuario' => $this->session->userdata('usuario'),
                'archivo' => ($nombreArchivo === '' ? $this->servicio_model->obtenerNombreArchivo($this->input->post('nro_servicio'))->ARCHIVO : $nombreArchivo),
                'trobs' => $this->input->post('trobs'),
                'mensaje' => '',
                'seq_nro_servicio' => $this->input->post('nro_servicio'),
                'usr_respon' => $this->input->post('usr_respon'),
                'usr_contact' => $this->input->post('usr_contact'),
                'archiname' => $this->input->post('archiname')
            );
            //echo json_encode($data);
            $rpt = $this->servicio_model->crearSolServicio($data);
            if ($data['activo'] == 'S') {
                $this->envio($data, $rpt);
            }
            /* $resp['servicios'] = $this->servicio_model->serviciosPorSecuencia($rpt);

              if($this->input->post('nro_servicio') == '-1') {
              $html_row = $this->load->view('servicio/servicio_row_ins', $resp, TRUE);
              }else {
              $html_row = $this->load->view('servicio/servicio_row_upd', $resp, TRUE);
              }
              echo json_encode($data); */

            echo $rpt;
        }


        //echo json_encode($data);

        /*
          $this->input->post('codProveedor')
          $this->input->post('nro_orden')
          $this->input->post('saldo')
         */
    }

    /**
     * Método para enviar correo.
     * 
     * @date 11/04/2016.
     * @author D4P.
     */
    public function envio($data, $nro_servicio) {

        $this->load->library('email');

        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'no-responder@telebucaramanga.com.co',
            'smtp_pass' => 'hDq9VnVzVx',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );

        $this->email->initialize($configGmail);

        $this->email->from('no-responder@telebucaramanga.com.co', 'No Responder');
        $usrto = '';
        $dirigido = '';
        $dirigido_backup = '';
        $mensaje = '';
        //echo json_encode($data);
        if ($data['estado'] == 'SOL') {

            $this->email->subject('Nueva Solicitud - '.$nro_servicio);
            $datos = array(
                'activo' => 'S',
                'usuario' => $data['usr_respon']
            );
            $rpt = $this->usuario_model->obtenerDatosUsuario($datos);
            $usrto = $rpt->CORREO;
            $dirigido = $rpt->NOMBREC;
            if ($rpt->COD_BACKUP != null && $rpt->COD_BACKUP != '') {
                $dirigido_backup = $rpt->COD_BACKUP;
            }
            $mensaje = 'Solicitud pendiente por aprobaci&oacute;n, ';
        } else if ($data['estado'] == 'REC') {

            $this->email->subject('Rechazo de Solicitud');
            $datos = array(
                'activo' => 'S',
                'usuario' => $data['cod_usr_solicita']
            );
            $rpt = $this->usuario_model->obtenerDatosUsuario($datos);
            $usrto = $rpt->CORREO;
            $dirigido = $rpt->NOMBREC;
            $mensaje = 'Solicitud de servicio rechazada, ';
        } else if ($data['estado'] == 'APR') {

            $this->email->subject('Aprobación de Solicitud - '.$nro_servicio);
            $datos = array(
                'activo' => 'N',
                'usuario' => $data['usr_contact']
            );
            $rpt = $this->usuario_model->obtenerDatosUsuario($datos);
            $usrto = $rpt->CORREO;
            $dirigido = $rpt->NOMBREC;
            if ($rpt->COD_BACKUP != null && $rpt->COD_BACKUP != '') {
                $dirigido_backup = $rpt->COD_BACKUP;
            }
            $mensaje = 'Estamos necesitando de sus servicios, ';
        } else {

            $this->email->subject('Pago de Servicio');
            $datos = array(
                'activo' => 'N',
                'usuario' => $data['usr_contact']
            );
            $rpt = $this->usuario_model->obtenerDatosUsuario($datos);
            $usrto = $rpt->CORREO;
            $dirigido = $rpt->NOMBREC;
            if ($rpt->COD_BACKUP != null && $rpt->COD_BACKUP != '') {
                $dirigido_backup = $rpt->COD_BACKUP;
            }
            $mensaje = 'Los servicios solicitados con usted han sido pagados, ';
        }
        //echo $dirigido;
        $this->email->to($usrto);
        //$this->email->to('mlaverde@telebucaramanga.com.co');
        $this->email->cc('mlaverde@telebucaramanga.com.co, daperez@telebucaramanga.com.co');
        //$this->email->cc('daperez@telebucaramanga.com.co');
        //$this->email->cc('daperez@telebucaramanga.com.co');

        if ($dirigido_backup != '') {
            $this->email->bcc('daperez@telebucaramanga.com.co');
        }
        ///////////////////////////////////////////////////////////////////////
        ///////////////////CONFIGURACION DEL MENSAJE///////////////////////////
        ///////////////////////////////////////////////////////////////////////
        $texto = '<table style="width: 500px;font-family: Helvetica Neue, Helvetica,Arial, Lucida Grande, sans-serif;border: 1px solid #CDCDCD; border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; padding: 20px;">
                    <tr>
                        <td style="text-align: center;">
                            <div class="col-lg-4">
                            <img class="image img-responsive" src="http://aplicaciones.telebucaramanga.com.co/phgo/tpl/inspinia/img/logo.png"></div>
                            <br/>
                            <h3>BIENVENIDO AL TABLERO DE SGC</h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 0;">
                            <p>Saludos  <br/> <br/> 
                                <strong>
                                    ' . $dirigido . '
                                </strong>, <br/> <br/> 
                                ' . $mensaje . '
                                a continuacion encontrar&aacute; los datos del servicio.
                                <br/><br/>Observaciones:    <strong> ';
        if ($data['estado'] == 'REC') {
            $texto .= $data['observaciones'] . '</strong><br/><br/> Observación Tramite: 
                                         <strong>' . $data['trobs'] . ' </strong>';
        } elseif ($data['estado'] == 'APR' && $data['trobs'] != '') {
            $texto .= $data['observaciones'] . '</strong><br/><br/> Observación Tramite: 
                                         <strong>' . $data['trobs'] . ' </strong>';
        } else {
            $texto .= $data['observaciones'];
        }
        $texto .= '</strong><br/><br/> 
                                Cantidad: '.$data['cantidad'].' <br/> <br/> 
                                Fecha Entrega: ' . $data['fecha_servicio'] . '
                                <br/> <br/> <strong>';
        //Entra cuando se ha hecho el pago del servicio,
        //cuando se tiene el nro de la factura.
        if ($data['nro_factura'] != '0' && $data['nro_factura'] != '') {
            $texto .= 'Nro Factura: </strong>
                                    ' . $data['nro_factura'] . '
                                    <br/> <br/> <strong>
                                    Radicado Factura: </strong>
                                    ' . $data['fecha_radicado'] . ' ';
        }
        $texto .= '</p>
                        </td>
                    </tr>';
        if ($data['estado'] != 'APR' && $data['estado'] != 'PAG') {
            $texto .= '<tr>
                        <td style="padding: 20px 0 10px 0;
                               text-align: center;">
                            <a style="background-color: #006dcc;
                               color: white;
                               border: 1px solid #CDCDCD;
                               border-radius: 5px;
                               -moz-border-radius: 5px;
                               -webkit-border-radius: 5px;
                               padding: 9px 7px;
                               text-decoration: none;" href="http://aplicaciones.telebucaramanga.com.co/bosme">Ingresar al sistema</a>
                        </td>
                    </tr>';
        }
        $texto .= '</table>';
        ///////////////////////////////////////////////////////////////////////
        ///////////////////CONFIGURACION DEL MENSAJE///////////////////////////
        ///////////////////////////////////////////////////////////////////////

        $this->email->message($texto);
        //echo $texto;
        //Adjuntar archivo
        $nombreArchivo = $this->servicio_model->obtenerNombreArchivo($data['seq_nro_servicio'])->ARCHIVO;
        if ($data['seq_nro_servicio'] != '-1' && $nombreArchivo != null && $nombreArchivo != '') {
            //$nombreArchivo = $this->servicio_model->obtenerNombreArchivo($data['seq_nro_servicio'])->ARCHIVO;
            //echo "Consulte la base de datos -> " . $nombreArchivo;
            $path = $_SERVER["DOCUMENT_ROOT"];
            $file = $path . "/bosme/public/docs/" . $nombreArchivo;
            //echo "Antes de adjuntar ";
            $this->email->attach($file);
        } else {
            //echo "Use el archivo -> " . $data['archivo'];
            if ($data['archivo'] != null && $data['archivo'] != '') {
                $path = $_SERVER["DOCUMENT_ROOT"];
                $file = $path . "/bosme/public/docs/" . $data['archivo'];
                //echo "Antes de adjuntar ";
                $this->email->attach($file);
                //echo "Depues de adjuntar ";
            }
            
        }

        $result = $this->email->send();
        
        $datosc = array(
            'seq_nro_servicio' => ($data['seq_nro_servicio'] === '-1' ? $nro_servicio : $data['seq_nro_servicio']),
            'cod_estado' => $data['estado'],
            'usu_dest' => $data['usr_contact'],
            'archivo' => ($nombreArchivo == '' ? $data['archivo'] : $nombreArchivo),
            'ruta' => '/bosme/public/docs/',
            'mensaje' => $texto,
            'activo' => 'S',
            'usuario' => $data['idusuario']
        );
        
        $this->servicio_model->registraCorreo($datosc);
        //echo "Enviara.. " . $result;
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
     * Método para obtener los servicios por proveedor y asignarlos a la tabla.
     * 
     * @return type filas de la tabla con los servicios.
     * @date 23/03/2016.
     * @author D4P.
     */
    public function serviciosProveedor($codProve) {

        //$data = $this->input->post('cod_proveedor');

        $rpt['servicios'] = $this->servicio_model->serviciosPorProveedor($codProve);

        $html_row = $this->load->view('servicio/servicio_row_ins', $rpt, TRUE);

        //echo $html_row;

        return $html_row;
    }

    public function obtenerDatos() {

        $codProve = $this->input->post('codprove');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order');
        $search = $this->input->post('search');
        $columns = $this->input->post('columns');

        $datos = array(
            'codprove' => $codProve,
            'start' => $start,
            'length' => $length,
            'nro_sol' => $this->input->post('nro_sol'),
            'order' => $columns[$order[0]['column']]['data'] . ' ' . $order[0]['dir'],
            'search' => $search['value']
        );

        $draw = $this->input->post('draw');

        $data = $this->servicio_model->serviciosPorProveedor($datos);

        $datas = array(
            'codprove' => $this->input->post('codprove'),
            'start' => false,
            'length' => 0,
            'nro_sol' => $this->input->post('nro_sol'),
            'search' => $search['value']
        );

        $rpt['draw'] = $draw;
        $rpt['recordsTotal'] = $this->servicio_model->serviciosPorProveedor_total($datas);
        $rpt['recordsFiltered'] = count($this->servicio_model->serviciosPorProveedor($datas));
        $rpt['data'] = $data;

        echo json_encode($rpt);
    }

    /**
     * Método para actualizar el estado del servicio solicitado.
     * 
     * @date 29/03/2016.
     * @author D4P.
     */
    public function actualizarEstadoSolServicio() {

        $data = array(
            'estado' => $this->input->post('slcMovimiento'),
            'seq_nro_sol' => $this->input->post('seq_nro_sol'),
            'seq_nro_servicio' => $this->input->post('seq_nro_servicio')
        );

        $rpt = $this->servicio_model->actualizarEstadoServicio($data);

        echo $rpt;
    }

    /**
     * Método para actualizar el combo de tipo de moviemientos dinamicamente.
     * 
     * @date 31/03/2016.
     * @author D4P.
     */
    public function estadosDinamicos() {

        $data = $this->input->post('cod_estado');
        $rpt = $this->estados($data);

        echo json_encode($rpt->result());
    }

    public function valorServicio() {

        $data = array(
            'codprove' => $this->input->post('codprove'),
            'tipservi' => $this->input->post('tipservi')
        );

        $rpt = $this->servicio_model->valorServicio($data);

        echo json_encode($rpt);
    }

}

?>