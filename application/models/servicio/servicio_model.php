<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servicio_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener los proveedores relacionados con las solicitudes.
     *
     * @date 16/03/2016.
     * @author D4P.
     */
    function obtenerTipoServicios($data) {

        $sql = "SELECT COD, 
                       DESCRI, 
                       VALOR, 
                       COD_PROVEE
                FROM   BSME.V_TIPO_SERV_PROVE
                WHERE  COD_PROVEE = '" . $data . "' ";

        $query = $this->db->query($sql);
        $resultado = $query->result();

        return $resultado;
    }

    /**
     * Método para hacer la insercion del servicio solicitado.
     *
     * @date 16/03/2016.
     * @author D4P.
     */
    function crearSolServicio($data) {

        $seq_servicio = $data['seq_nro_servicio'];
        //echo $data['valor'];
        $params = array(
            array('name' => ':p_seq_nro_servicio',
                'value' => &$seq_servicio,
                'type' => OCI_B_INT, //SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_seq_nro_solicitud',
                'value' => intval($data['nro_solicitud']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_cod_tipo_servicio',
                'value' => strval($data['cod_tipo_servicio']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_estado',
                'value' => $data['estado'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_fecha_solicita',
                'value' => $data['fecha_solicita'],
                'type' => SQLT_ODT,
                'length' => 32
            ),
            array('name' => ':p_valor',
                'value' => $data['valor'],
                'type' => SQLT_NUM,
                'length' => 40
            ),
            array('name' => ':p_cantidad',
                'value' => strval($data['cantidad']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_fecha_servicio',
                'value' => $data['fecha_servicio'],
                'type' => SQLT_ODT,
                'length' => 32
            ),
            array('name' => ':p_nro_factura',
                'value' => $data['nro_factura'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_comision',
                'value' => intval($data['comision']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_fecha_radicado',
                'value' => $data['fecha_radicado'],
                'type' => SQLT_ODT,
                'length' => 32
            ),
            array('name' => ':p_observaciones',
                'value' => strval($data['observaciones']),
                'type' => SQLT_CHR,
                'length' => 4000
            ),
            array('name' => ':p_cod_usr_solicita',
                'value' => strval($data['cod_usr_solicita']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_activo',
                'value' => strval($data['activo']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_usuario',
                'value' => strval($data['idusuario']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_archivo',
                'value' => strval($data['archivo']),
                'type' => SQLT_CHR,
                'length' => 100
            ),
            array('name' => ':p_observacion_tramite',
                'value' => strval($data['trobs']),
                'type' => SQLT_CHR,
                'length' => 4000
            )
        );
        //echo "Estos son los parametros->".json_encode($params);
        $sql = "declare
                mensaje varchar2(250);
                BEGIN
                    bsme.pak_servicio.registra_servicio (:p_seq_nro_servicio,
                                                         :p_seq_nro_solicitud,
                                                         :p_cod_tipo_servicio,
                                                         :p_cod_estado,
                                                         to_date(:p_fecha_solicita, 'dd/mm/yyyy'),
                                                         :p_valor,
                                                         :p_cantidad,
                                                         to_date(:p_fecha_servicio, 'dd/mm/yyyy'),
                                                         :p_nro_factura,
                                                         :p_comision, ";
        if (is_null($data['fecha_radicado'])) {
            $sql .= ":p_fecha_radicado,";
        } else {
            $sql .= "to_date(:p_fecha_radicado, 'dd/mm/yyyy'),";
        }

        $sql .= "                                        :p_observaciones,
                                                         :p_cod_usr_solicita,
                                                         :p_activo,
                                                         :p_usuario,
                                                         :p_archivo,
                                                         :p_observacion_tramite,
                                                         mensaje);
                commit;
                END;";

        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {
            
            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        
        $r = ociexecute($stmt);
        
        if ($r == 1) {
            return $seq_servicio;
        } else {
            return 0;
        }
    }

    /**
     * Método para obtener los servicios por solicitud.
     * 
     * @param type array. Parametro para obtener los valores de la consulta.
     * @date 22/03/2016.
     * @author D4P.
     */
    function servicioPorSolicitud($data) {

        $sql = "SELECT NRO_SERVICIO,
                       NRO_SOLICITUD,
                       TIPO_SERVICIO,
                       SERV_DESCR,
                       COD_ESTADO,
                       EST_DESCR,
                       TO_CHAR(FECHA_SOLICITA, 'dd/mm/yyyy') FECHA_SOLICITA,
                       VALOR,
                       CANTIDAD,
                       TO_CHAR(FECHA_SERVICIO, 'dd/mm/yyyy') FECHA_SERVICIO,
                       NRO_FACTURA,
                       COMISION,
                       TO_CHAR(FECHA_RADICADO, 'dd/mm/yyyy') FECHA_RADICADO,
                       OBSERVACIONES,
                       USR_SOLICITA,
                       FECHA_CREACION,
                       USR_CREACION
                  FROM BSME.V_SERVICIO
                 WHERE NRO_SOLICITUD = " . $data['nro_solicitud'] . " 
                   AND ACTIVO = 'S' 
                 ORDER BY nro_servicio DESC";

        $query = $this->db->query($sql);

        $rpt = $query->result();
        //echo $sql;
        return $rpt;
    }
    
    /**
     * Método para obtener los servicios solicitados por filtro.
     * 
     * @param array $data con los resultados de la busqueda.
     * @return type
     * @date 07/04/2016.
     * @author D4P.
     */
    function servicioPorSolicitudFiltrado($data) {
        
        $sql = "SELECT *
                FROM   (SELECT ROWNUM FILA,
                       NRO_SERVICIO,
                       NRO_SOLICITUD,
                       TIPO_SERVICIO,
                       SERV_DESCR,
                       COD_ESTADO,
                       EST_DESCR,
                       TO_CHAR(FECHA_SOLICITA, 'dd/mm/yyyy') FECHA_SOLICITA,
                       VALOR,
                       CANTIDAD,
                       TO_CHAR(FECHA_SERVICIO, 'dd/mm/yyyy') FECHA_SERVICIO,
                       NRO_FACTURA,
                       COMISION,
                       TO_CHAR(FECHA_RADICADO, 'dd/mm/yyyy') FECHA_RADICADO,
                       OBSERVACIONES,
                       USR_SOLICITA,
                       FECHA_CREACION,
                       USR_CREACION
                  FROM BSME.V_SERVICIO
                 WHERE NRO_SOLICITUD = " . $data['nro_solicitud'] . "
                 ORDER BY NRO_SERVICIO DESC )
                 WHERE FILA BETWEEN ".$data['start']." AND ".($data['start'] + $data['length'])." ";

        $query = $this->db->query($sql);

        $rpt = $query->result();
        //echo $sql;
        return $rpt;
    }

    /**
     * Método para obtener los servicios por proveedor.
     * 
     * @param type $data. Parametro que contiene el codigo del proveedor.
     * @date 23/03/2016.
     * @author D4P.
     */
    function serviciosPorProveedor($data) {

        $sql = "SELECT  
                        SEQ_NRO_SERVICIO NRO_SERVICIO,
                        SEQ_NRO_SOLICITUD NRO_SOLICITUD,
                        TIPO_SERVICIO,
                        SERV_DESCR,
                        COD_ESTADO,
                        EST_DESCR,
                        TO_CHAR(FECHA_SOLICITA, 'dd/mm/yyyy') FECHA_SOLICITA,
                        VALOR,
                        CANTIDAD,
                        TO_CHAR(FECHA_SERVICIO, 'dd/mm/yyyy') FECHA_SERVICIO,
                        OBSERVACIONES,
                        USR_SOLICITA,
                        NOM_COMPLE,
                        NRO_FACTURA,
                        COMISION,
                        TO_CHAR(FECHA_RADICADO, 'dd/mm/yyyy') FECHA_RADICADO,
                        ARCHIVO,
                        ACTIVO,
                        BSME.pak_servicio_tramite.obs_tramite(p_seq_nro_servicio=> SEQ_NRO_SERVICIO) OBS_TRAMITE,
                        SEQ_NRO_SERVICIO ACCIONES
                   FROM BSME.V_SERVICIO_SOLICITUD
                  WHERE COD_PROVEEDOR = " . $data['codprove'] . "
                    AND SEQ_NRO_SOLICITUD = ".$data['nro_sol'];
        
        if (isset($data['search']) === TRUE) {
            $sql .= " AND (EST_DESCR LIKE '%{$data['search']}%' 
                        OR SERV_DESCR LIKE '%{$data['search']}%' 
                        OR NOM_COMPLE LIKE '%{$data['search']}%' 
                        OR NRO_FACTURA LIKE '%{$data['search']}%'
                        OR TO_CHAR(FECHA_SERVICIO, 'dd/mm/yyyy') LIKE '%{$data['search']}%')";
        }
        
        if (isset($data['order']) === TRUE) {
            $sql .= " ORDER BY " . $data['order'];
        }
        
        if ($data['start'] !== false) {
        
            $sql = "SELECT *
                      FROM ( SELECT ROWNUM AS FILA, T0.* 
                             FROM ( ".$sql." ) T0 ) 
                     WHERE FILA > " . $data['start'] . " AND FILA <= " .($data['start'] + $data['length']). " ";
        }
        
        //echo $sql;
        /*$para = 'dperez5@unab.edu.co';
        $titulo = 'El título';
        $mensaje = 'Hola-> <br> '.$sql;
        $cabeceras = 'From: webmaster@example.com' . "\r\n";

        mail($para, $titulo, $mensaje, $cabeceras);*/

        $query = $this->db->query($sql);

        $rpt = $query->result();

        return $rpt;
    }

    /**
     * Método para obtener los servicios por proveedor.
     * 
     * @param type $data. Parametro que contiene el codigo del proveedor.
     * @date 23/03/2016.
     * @author D4P.
     */
    function serviciosPorProveedor_total($data) {

        $sql = "SELECT COUNT(*) AS CANTIDAD
                FROM BSME.V_SERVICIO_SOLICITUD
               WHERE COD_PROVEEDOR = " . $data['codprove'] . "
                 AND SEQ_NRO_SOLICITUD = ".$data['nro_sol'];

        $query = $this->db->query($sql);

        $rpt = $query->row();

        return intval($rpt->CANTIDAD);
    }

    /**
     * Método para obtener los servicios por Secuencia de servicio.
     * 
     * @param type $data Parametro que contiene el nro de la secuendia de servicio.
     * @return type los valores de la consulta.
     * @date 04/04/2016.
     * @author D4P.
     */
    function serviciosPorSecuencia($data) {

        $sql = "SELECT SEQ_NRO_SERVICIO NRO_SERVICIO,
                       SEQ_NRO_SOLICITUD NRO_SOLICITUD,
                       TIPO_SERVICIO,
                       SERV_DESCR,
                       COD_ESTADO,
                       EST_DESCR,
                       FECHA_SOLICITA,
                       VALOR,
                       CANTIDAD,
                       FECHA_SERVICIO,
                       OBSERVACIONES,
                       USR_SOLICITA,
                       NOM_COMPLE,
                       NRO_FACTURA,
                       COMISION,
                       FECHA_RADICADO,
                       ARCHIVO,
                       BSME.pak_servicio_tramite.obs_tramite(p_seq_nro_servicio=> SEQ_NRO_SERVICIO) OBS_TRAMITE
                  FROM BSME.V_SERVICIO_SOLICITUD
                 WHERE SEQ_NRO_SERVICIO = " . $data . " ";

        $query = $this->db->query($sql);

        $rpt = $query->result();

        return $rpt;
    }

    /**
     * Método para actualizar el estado del servicio.
     * 
     * @param type $data Arreglo con los parametros para el procedo de actulización.
     * @date 29/03/2016.
     * @author D4P.
     */
    function actualizarEstadoServicio($data) {

        $params = array(
            array('name' => ':p_seq_nro_solicitud',
                'value' => intval($data['seq_nro_sol']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_seq_nro_servicio',
                'value' => intval($data['seq_nro_servicio']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_cod_estado',
                'value' => $data['estado'],
                'type' => SQLT_CHR,
                'length' => 32
            )
        );

        $sql = "BEGIN
                    BSME.PAK_SERVICIO.ACTUALIZA_ESTADO(:p_seq_nro_solicitud, :p_seq_nro_servicio, :p_cod_estado);
                commit;
                END;";

        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {

            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        //var_dump($sql);
        $r = ociexecute($stmt);

        /*
          BEGIN
          bsme.pak_servicio_tramite.INSERTA(p_seq_nro_servicio=> :new.seq_nro_servicio,
          p_cod_estado=> :new.cod_estado,
          p_cod_usr_tramita=> :new.cod_usr_solicita,
          p_fecha_tramite=> SYSDATE,
          p_obs_tramite=> ?,
          p_activo=> 'S',
          p_usuario=> :new.cod_usr_solicita);
          END;
         */

        return $r;
    }
    
    /**
     * Método para registrar los correos que son enviados a los diferentes usuarios.
     * 
     * @param type $data Array con valores a registrar.
     * @date 17/06/2016.
     * @author D4P.
     */
    function registraCorreo($data) {
        
        $params = array(
            array('name' => ':p_seq_nro_servicio',
                'value' => intval($data['seq_nro_servicio']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_cod_estado',
                'value' => $data['cod_estado'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_usuario_dest',
                'value' => $data['usu_dest'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_archivo',
                'value' => $data['archivo'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_ruta',
                'value' => $data['ruta'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_mensaje',
                'value' => $data['mensaje'],
                'type' => SQLT_CHR,
                'length' => 4000
            ),
            array('name' => ':p_activo',
                'value' => $data['activo'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_usuario',
                'value' => $data['usuario'],
                'type' => SQLT_CHR,
                'length' => 32
            )
        );
        //echo json_encode($params);
        $sql = "begin
                    bsme.pak_control_correo.inserta(:p_seq_nro_servicio, 
                                                    :p_cod_estado, 
                                                    :p_cod_usuario_dest, 
                                                    :p_archivo, 
                                                    :p_ruta, 
                                                    :p_mensaje, 
                                                    :p_activo, 
                                                    :p_usuario);
                commit;
                end;                
            ";
        
        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {

            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        //var_dump($sql);
        $r = ociexecute($stmt);
    }


    /**
     * Método paera obtener el valor del servicio.
     * 
     * @param array $data con datos de la consulta.
     * @return array con resultados.
     * @author D4P.
     */
    function valorServicio($data) {

        $sql = "SELECT COD,
                       DESCRI, 
                       VALOR
                FROM   BSME.V_TIPO_SERV_PROVE
                WHERE  COD_PROVEE = '" . $data['codprove'] . "'
                AND    COD = '" . $data['tipservi'] . "' ";

        $query = $this->db->query($sql);

        $resultado = $query->result();

        return $resultado[0];
    }
    
    /**
     * Método para obtener nombre de archivo del servicio.
     * 
     * @param numero de servicio.
     * @return resultado de la consulta.
     * @date 12/04/2016.
     * @author D4P
     */
    function obtenerNombreArchivo($data) {
        
        $sql = "SELECT BSME.PAK_SERVICIO.ARCHIVO(".$data.") ARCHIVO
                  FROM DUAL ";
        
        $query = $this->db->query($sql);

        $resultado = $query->result();

        return $resultado[0];
    }
    
    /**
     * Método para obtener los servicios que ya han sido pagados y poder generar 
     * el reporte de conciliacion entre dos fechas dadas.
     * 
     * @param array $data con los parametros de busqueda.
     * @return array con los resultados de la consulta.
     * @date 22/04/2016.
     * @author D4P.  OR COD_ESTADO = 'PAG'
     */
    function reporteConciliacion($data) {
        
        $sql = "SELECT NVL(S.NRO_FACTURA, '--') FACTURA,
                       S.VALOR VALOR_UNITARIO,
                       S.CANTIDAD CANTIDAD,
                       (S.VALOR*S.CANTIDAD) VALOR_SIN_IVA,
                       (S.VALOR*S.CANTIDAD) * BSME.PAK_PARAMETRO.VALOR_PARAM(P_COD_PARAMETRO=> 'IVA', P_TIPO_PARAM=> 'N') IVA,
                       (S.VALOR*S.CANTIDAD) + (S.VALOR*S.CANTIDAD)*BSME.PAK_PARAMETRO.VALOR_PARAM(P_COD_PARAMETRO=> 'IVA', P_TIPO_PARAM=> 'N') VALOR_IVA,
                       S.FECHA_SOLICITA FECHA_INICIAL,
                       TRUNC(S.FECHA_ULT_MODIFICACION) FECHA_FINAL,
                       S.FECHA_RADICADO FECHA_RADICADO,
                       TS.DESCRIPCION DESCRIPCION
                  FROM BSME.SERVICIO S, BSME.TIPO_SERVICIO TS
                 WHERE S.COD_TIPO_SERVICIO = TS.COD_TIPO_SERVICIO
                   AND SEQ_NRO_SOLICITUD = ".$data['nro_soli']."
                   AND S.ACTIVO = 'S'
                   AND COD_ESTADO = 'APR'
                   AND TRUNC(S.FECHA_ULT_MODIFICACION) BETWEEN TO_DATE('".$data['fechaini']."', 'dd/mm/yyyy') AND TO_DATE('".$data['fechafin']."', 'dd/mm/yyyy')";
        
        $query = $this->db->query($sql);
        
        $rpt = $query->result();
        
        return $rpt;
    }
    
    /**
     * Método para obtener los servicios que ya han sido pagados y poder generar 
     * el reporte de conciliacion entre dos fechas dadas.
     * 
     * @param array $data con los parametros de busqueda.
     * @return array con los resultados de la consulta.
     * @date 22/04/2016.
     * @author D4P.
     */
    function reporteTerminacion($data) {
        
        $sql = "SELECT NVL(S.NRO_FACTURA, '--') FACTURA,
                       S.VALOR VALOR_UNITARIO,
                       S.CANTIDAD CANTIDAD,
                       (S.VALOR*S.CANTIDAD) VALOR_SIN_IVA,
                       (S.VALOR*S.CANTIDAD) * BSME.PAK_PARAMETRO.VALOR_PARAM(P_COD_PARAMETRO=> 'IVA', P_TIPO_PARAM=> 'N') IVA,
                       (S.VALOR*S.CANTIDAD) + (S.VALOR*S.CANTIDAD)*BSME.PAK_PARAMETRO.VALOR_PARAM(P_COD_PARAMETRO=> 'IVA', P_TIPO_PARAM=> 'N') VALOR_IVA,
                       S.FECHA_SOLICITA FECHA_INICIAL,
                       TRUNC(S.FECHA_ULT_MODIFICACION) FECHA_FINAL,
                       S.FECHA_RADICADO FECHA_RADICADO,
                       TS.DESCRIPCION DESCRIPCION
                  FROM BSME.SERVICIO S, BSME.TIPO_SERVICIO TS
                 WHERE S.COD_TIPO_SERVICIO = TS.COD_TIPO_SERVICIO
                   AND SEQ_NRO_SOLICITUD = ".$data['nro_soli']."
                   AND S.ACTIVO = 'S'
                   AND COD_ESTADO = 'PAG'
                   AND TRUNC(S.FECHA_ULT_MODIFICACION) BETWEEN TO_DATE('".$data['fechaini']."', 'dd/mm/yyyy') AND TO_DATE('".$data['fechafin']."', 'dd/mm/yyyy')";
        
        $query = $this->db->query($sql);
        
        $rpt = $query->result();
        
        return $rpt;
    }
    
    /**
     * Método para obtener los servicios pagados o aprobados de determinado proveedor.
     * 
     * @param array $data parametros de busqueda.
     * @return array con resultado de la consulta.
     * @date 22/04/2016.
     * @author D4P.
     */
    function reporteConciliacionFiltrado($data) {
        
        $sql = "SELECT *
                FROM (SELECT ROWNUM FILA,
                             NVL(S.NRO_FACTURA, '--') FACTURA,
                             S.VALOR VALOR_UNITARIO,
                             S.CANTIDAD CANTIDAD,
                             (S.VALOR*S.CANTIDAD) VALOR_SIN_IVA,
                             (S.VALOR*S.CANTIDAD) * BSME.PAK_PARAMETRO.VALOR_PARAM(P_COD_PARAMETRO=> 'IVA', P_TIPO_PARAM=> 'N') IVA,
                             (S.VALOR*S.CANTIDAD) + (S.VALOR*S.CANTIDAD)*BSME.PAK_PARAMETRO.VALOR_PARAM(P_COD_PARAMETRO=> 'IVA', P_TIPO_PARAM=> 'N') VALOR_IVA,
                             S.FECHA_SOLICITA FECHA_INICIAL,
                             TRUNC(S.FECHA_ULT_MODIFICACION) FECHA_FINAL,
                             S.FECHA_RADICADO FECHA_RADICADO            
                        FROM BSME.SERVICIO S
                       WHERE SEQ_NRO_SOLICITUD = ".$data['nro_soli']."
                         AND S.ACTIVO = 'S'
                         AND COD_ESTADO = 'APR'
                         AND TRUNC(S.FECHA_ULT_MODIFICACION) BETWEEN TO_DATE('".$data['fechaini']."', 'dd/mm/yyyy') AND TO_DATE('".$data['fechafin']."', 'dd/mm/yyyy'))
               WHERE FILA BETWEEN ".$data['start']." AND ".$data['length']." ";
        
        $query = $this->db->query($sql);
        
        $rpt = $query->result();
        //echo json_encode($data);
        return $rpt;
    }
    
    /**
     * Método para obtener los servicios pagados o aprobados de determinado proveedor.
     * 
     * @param array $data parametros de busqueda.
     * @return array con resultado de la consulta.
     * @date 22/04/2016.
     * @author D4P.
     */
    function reporteTerminacionFiltrado($data) {
        
        $sql = "SELECT *
                FROM (SELECT ROWNUM FILA,
                             NVL(S.NRO_FACTURA, '--') FACTURA,
                             S.VALOR VALOR_UNITARIO,
                             S.CANTIDAD CANTIDAD,
                             (S.VALOR*S.CANTIDAD) VALOR_SIN_IVA,
                             (S.VALOR*S.CANTIDAD) * BSME.PAK_PARAMETRO.VALOR_PARAM(P_COD_PARAMETRO=> 'IVA', P_TIPO_PARAM=> 'N') IVA,
                             (S.VALOR*S.CANTIDAD) + (S.VALOR*S.CANTIDAD)*BSME.PAK_PARAMETRO.VALOR_PARAM(P_COD_PARAMETRO=> 'IVA', P_TIPO_PARAM=> 'N') VALOR_IVA,
                             S.FECHA_SOLICITA FECHA_INICIAL,
                             TRUNC(S.FECHA_ULT_MODIFICACION) FECHA_FINAL,
                             S.FECHA_RADICADO FECHA_RADICADO            
                        FROM BSME.SERVICIO S
                       WHERE SEQ_NRO_SOLICITUD = ".$data['nro_soli']."
                         AND S.ACTIVO = 'S'
                         AND COD_ESTADO = 'PAG'
                         AND TRUNC(S.FECHA_ULT_MODIFICACION) BETWEEN TO_DATE('".$data['fechaini']."', 'dd/mm/yyyy') AND TO_DATE('".$data['fechafin']."', 'dd/mm/yyyy'))
               WHERE FILA BETWEEN ".$data['start']." AND ".$data['length']." ";
        
        $query = $this->db->query($sql);
        
        $rpt = $query->result();
        //echo json_encode($data);
        return $rpt;
    }
    
    /**
     * Método para obtener el numero de la solicitud del proveedor seleccionado.
     * 
     * @param string $codProvee con el codigo del proveedor.
     * @return array con los resultados de la consulta.
     * @date 25/04/2016.
     * @author D4P.
     */
    function serviciosSolicitudReporte($codProvee) {
        
        $sql = "SELECT SEQ_NRO_SOLICITUD NRO_SOLI
                  FROM BSME.V_SERVICIO_SOLICITUD
                 WHERE COD_PROVEEDOR = '".$codProvee."'
                GROUP BY SEQ_NRO_SOLICITUD " ;
        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            $rpt = $query->result();
            $rpt = $rpt[0];
        }else {
            $rpt = 0;
        }
        
        return $rpt;
    }
    
    /**
     * Método para obtener los servicios que se van a liquidar, para la generacion
     * del reporte.
     * 
     * @param array $data con los parametros de busqueda.
     * @date 05/05/2016.
     * @author D4P.
     */
    function reporteTerminacionPdf($data) {
        
        $sql = "SELECT NVL (NRO_FACTURA, '--') FACTURA,
                       FECHA_RADICADO FECHA_RADICADO,
                       SUM (VALOR) VALOR_UNITARIO,
                       SUM (CANTIDAD) CANTIDAD,
                       SUM (VALOR * CANTIDAD) VALOR_SIN_IVA,
                       SUM (VALOR * CANTIDAD) * BSME.PAK_PARAMETRO.VALOR_PARAM (p_cod_parametro => 'IVA', p_tipo_param => 'N') IVA,
                       SUM (VALOR * CANTIDAD) + SUM (VALOR * CANTIDAD) * BSME.PAK_PARAMETRO.VALOR_PARAM (p_cod_parametro => 'IVA', p_tipo_param => 'N') VALOR_IVA
                  FROM BSME.SERVICIO
                 WHERE COD_ESTADO = 'PAG'
                   AND SEQ_NRO_SOLICITUD = ".$data['nro_soli']."
                   AND ACTIVO = 'S'
                   AND TRUNC (FECHA_ULT_MODIFICACION) BETWEEN TO_DATE('".$data['fechaini']."', 'dd/mm/yyyy') AND TO_DATE('".$data['fechafin']."', 'dd/mm/yyyy')
                GROUP BY NRO_FACTURA, FECHA_RADICADO ";
        
        $query = $this->db->query($sql);
        $rpt = $query->result();
        
        return $rpt;
    }

}

?>