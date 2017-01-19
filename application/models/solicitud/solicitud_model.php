<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Solicitud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener las solicitudes por busqueda en numero de orden o nombre de proveedor.
     *
     * @date 14/03/2016.
     * @author D4P.
     */
    function getSolicitudBySearch($busqueda) {

        /*$sql = "SELECT TO_CHAR(TOC.CTOC_NROOC) ORDEN_NUMERO, PROV.PROV_PROV ID_PROVEEDOR,
                       TOC.CTOC_VLRTOTAL VALOR_TOTAL, NVL(TO_CHAR(TOC.CTOC_FECENT, 'yyyy-MM-dd'), 'N-A') FECHA_ENTREGA,
                       TOC.CTOC_STATUS ESTATUS, 
                       NVL(TO_CHAR(TOC.CTOC_FECINIAC, 'mm/dd/yyyy'), 'N-A') FECHA_INICIO,
                       PROV.PROV_NRONIT NRO_NIT, PROV.PROV_PROV PROV_USER, PROV.PROV_DESCRI PROV_DESCRI,
                       PROV.PROV_RESPON PROV_RESPONSABLE, PROV.PROV_NITRESP NIT_RESPONSABLE, 
                       TRIM(PROV.PROV_NROTLF) TELEFONO_RESP, PROV.PROV_NROFAX FAX_RESPONSABLE, 
                       TRIM(PROV.PROV_MAIL) EMAIL, NVL(SOL.NRO_ORDEN, '0') NRO_ORDEN_LOCAL,
                       SOL.CATEGORIA, SOL.USR_RESP, SOL.V_BOLSA, PROV.PROV_SEROFRE DESCRIPCION,
                       CASE WHEN NVL(TO_CHAR(TOC.CTOC_FECENT, 'yyyy-MM-dd'), 'N-A') = 'N-A' THEN 'VENCIDO'
                            WHEN TOC.CTOC_FECENT > SYSDATE THEN 'VIGENTE'
                        ELSE 'VENCIDO'
                       END AS ESTADO,
                       SOL.NRO_SOL,
                       BSME.PAK_SOLICITUD.SALDO_BOLSA(SOL.COD_PROVE) SALDO_BOLSA,
                       NVL(BSME.PAK_SOLICITUD.VALOR_SERVICIOS(SOL.COD_PROVE) * BSME.PAK_PARAMETRO.VALOR_PARAM('IVA', 'N'), 0) VAL_SER_IVA,
                       NVL(BSME.PAK_SOLICITUD.VALOR_SERVICIOS(SOL.COD_PROVE), 0) VAL_SER,
                       CASE WHEN NVL(BSME.PAK_SOLICITUD.SALDO_BOLSA(SOL.COD_PROVE), 0) < (SOL.V_BOLSA*0.8) THEN 'S'
                        ELSE 'N'
                       END AS ALERTA,
                       CASE WHEN (TO_DATE(SYSDATE, 'dd/mm/yyyy') - TO_DATE(NVL(TOC.CTOC_FECENT, SYSDATE) - 45, 'dd/mm/yyyy')) >= 0 THEN 'S'
                        ELSE 'N' 
                       END AS ALERTAFECHA
                       -- FALTA HACER BUSQUEDA EN CONTRATOS
                  FROM CONSTR.IN_TCTOC@SFI TOC, CONSTR.IN_TPROV@SFI PROV,
                       (SELECT SOL.SEQ_NRO_SOLICITUD NRO_SOL,
                               SOL.NRO_ORDEN NRO_ORDEN,
                               SOL.COD_CATEGORIA CATEGORIA,
                               SOL.COD_USR_RESPONSABLE USR_RESP,
                               SOL.VALOR_BOLSA V_BOLSA,
                               SOL.COD_PROVEEDOR COD_PROVE
                          FROM BSME.SOLICITUD SOL) SOL
                 WHERE TOC.CTOC_PROV = PROV.PROV_PROV
                   AND (TOC.CTOC_NROOC LIKE '%" . $busqueda . "%'
                        OR UPPER (PROV.PROV_DESCRI) LIKE UPPER ('%" . $busqueda . "%'))
                   AND TOC.CTOC_NROOC = SOL.NRO_ORDEN(+)
                UNION
                SELECT TCON.CONT_NROCON ORDEN_NUMERO, PROV.PROV_PROV ID_PROVEEDOR,
                       TCON.CONT_VALOR + CONTR.VALOR_TOTAL_ADICPROR@SFI(TCON.CONT_CIAS,TCON.CONT_VIGCONT, TCON.CONT_TPDO, TCON.CONT_NROCON) VALOR_TOTAL,
                       NVL(TO_CHAR(TCON.CONT_FECTERM, 'yyyy-MM-dd'), 'N-A') FECHA_ENTREGA, 
                       TCON.CONT_STATUS ESTATUS,
                       NVL(TO_CHAR(TCON.CONT_FECINI, 'mm/dd/yyyy'), 'N-A') FECHA_INICIO,
                       PROV.PROV_NRONIT NRO_NIT, PROV.PROV_PROV PROV_USER, PROV.PROV_DESCRI PROV_DESCRI,
                       PROV.PROV_RESPON PROV_RESPONSABLE, PROV.PROV_NITRESP NIT_RESPONSABLE, 
                       TRIM(PROV.PROV_NROTLF) TELEFONO_RESP, PROV.PROV_NROFAX FAX_RESPONSABLE, 
                       TRIM(PROV.PROV_MAIL) EMAIL,
                       NVL(SOL.NRO_ORDEN, '0') NRO_ORDEN_LOCAL,
                       SOL.CATEGORIA, SOL.USR_RESP, SOL.V_BOLSA,
                       --PROV.PROV_SEROFRE DESCRIPCION,
                       TCON.CONT_OBSERV1 || ' ' ||TCON.CONT_OBSERV2 DESCRIPCION,
                       CASE WHEN NVL(TO_CHAR(TCON.CONT_FECTERM, 'yyyy-MM-dd'), 'N-A') = 'N-A' THEN 'VENCIDO'
                            WHEN TCON.CONT_FECTERM > SYSDATE THEN 'VIGENTE'
                        ELSE 'VENCIDO'
                        END AS ESTADO,
                       SOL.NRO_SOL,
                       BSME.PAK_SOLICITUD.SALDO_BOLSA(SOL.COD_PROVE) SALDO_BOLSA,
                       NVL(BSME.PAK_SOLICITUD.VALOR_SERVICIOS(SOL.COD_PROVE) * BSME.PAK_PARAMETRO.VALOR_PARAM('IVA', 'N'), 0) VAL_SER_IVA,
                       NVL(BSME.PAK_SOLICITUD.VALOR_SERVICIOS(SOL.COD_PROVE), 0) VAL_SER,
                       CASE WHEN NVL(BSME.PAK_SOLICITUD.SALDO_BOLSA(SOL.COD_PROVE), 0) < (SOL.V_BOLSA*0.8) THEN 'S'
                        ELSE 'N'
                       END AS ALERTA,
                       --PROV.PROV_SEROFRE DESCRIPCION       
                       CASE WHEN (TO_DATE(SYSDATE, 'dd/mm/yyyy') - TO_DATE(NVL(TCON.CONT_FECTERM, SYSDATE) - 45, 'dd/mm/yyyy')) >= 0 THEN 'S'
                        ELSE 'N' 
                       END AS ALERTAFECHA
                  FROM CONTR.CO_TCONT@SFI TCON, CONSTR.IN_TPROV@SFI PROV,
                       (SELECT SOL.SEQ_NRO_SOLICITUD NRO_SOL,
                               SOL.NRO_ORDEN NRO_ORDEN,
                               SOL.COD_CATEGORIA CATEGORIA,
                               SOL.COD_USR_RESPONSABLE USR_RESP,
                               SOL.VALOR_BOLSA V_BOLSA,
                               SOL.COD_PROVEEDOR COD_PROVE
                          FROM BSME.SOLICITUD SOL) SOL
                 WHERE TCON.CONT_AUXI = PROV.PROV_PROV
                   AND (TCON.CONT_NROCON LIKE '%" . $busqueda . "%'
                        OR UPPER (PROV.PROV_DESCRI) LIKE UPPER ('%" . $busqueda . "%'))
                   AND TCON.CONT_NROCON = SOL.NRO_ORDEN(+)";
        */
        $sql = "SELECT TO_CHAR(TOC.CTOC_NROOC) ORDEN_NUMERO,
                       PROV.PROV_PROV ID_PROVEEDOR,
                       NVL(VGES.VLR_CONTRATO, 0) + NVL(VGES.VLR_ADICION, 0) VALOR_TOTAL,
                       NVL(TO_CHAR(TOC.CTOC_FECENT, 'dd/mm/yyyy'), 'N-A') FECHA_ENTREGA,
                       TOC.CTOC_STATUS ESTATUS, 
                       NVL(TO_CHAR(TOC.CTOC_FECINIAC, 'mm/dd/yyyy'), 'N-A') FECHA_INICIO,
                       PROV.PROV_NRONIT NRO_NIT, 
                       PROV.PROV_PROV PROV_USER, 
                       PROV.PROV_DESCRI PROV_DESCRI,
                       PROV.PROV_RESPON PROV_RESPONSABLE, 
                       PROV.PROV_NITRESP NIT_RESPONSABLE, 
                       TRIM(PROV.PROV_NROTLF) TELEFONO_RESP, 
                       PROV.PROV_NROFAX FAX_RESPONSABLE, 
                       TRIM(PROV.PROV_MAIL) EMAIL, 
                       NVL(SOL.NRO_ORDEN, '0') NRO_ORDEN_LOCAL,
                       SOL.CATEGORIA, 
                       SOL.USR_RESP, 
                       SOL.V_BOLSA,
                       PROV.PROV_SEROFRE DESCRIPCION,
                       CASE WHEN NVL(TO_CHAR(TOC.CTOC_FECENT, 'yyyy-MM-dd'), 'N-A') = 'N-A' THEN 'VENCIDO'
                            WHEN TOC.CTOC_FECENT > SYSDATE THEN 'VIGENTE'
                        ELSE 'VENCIDO'
                       END AS ESTADO,
                       SOL.NRO_SOL,
                       BSME.PAK_SOLICITUD.SALDO_BOLSA(SOL.NRO_SOL) SALDO_BOLSA,
                       CASE WHEN BSME.PAK_SOLICITUD.COBRA_IVA(SOL.NRO_SOL) = 'S' THEN
                        NVL(BSME.PAK_SOLICITUD.VALOR_SERVICIOS(SOL.COD_PROVE, SOL.NRO_SOL) * BSME.PAK_PARAMETRO.VALOR_PARAM('IVA', 'N'), 0) 
                       ELSE 0
                       END VAL_SER_IVA,
                       NVL(BSME.PAK_SOLICITUD.VALOR_SERVICIOS(SOL.COD_PROVE, SOL.NRO_SOL), 0) VAL_SER,
                       CASE WHEN NVL(BSME.PAK_SOLICITUD.SALDO_BOLSA(SOL.NRO_SOL), 0) <= (SOL.V_BOLSA*0.2) THEN 'S'
                        ELSE 'N'
                       END AS ALERTA,
                       CASE WHEN (TO_DATE(SYSDATE, 'dd/mm/yyyy') - TO_DATE(NVL(TOC.CTOC_FECENT, SYSDATE) - 45, 'dd/mm/yyyy')) >= 0 THEN 'S'
                        ELSE 'N' 
                       END AS ALERTAFECHA,
                       SOL.COBRAIVA
                  FROM CONSTR.IN_TCTOC@SFI TOC, CONSTR.IN_TPROV@SFI PROV,
                       CONSTR.IN_VGESTION_CONTRACTUAL@SFI VGES,
                       (SELECT SOL.SEQ_NRO_SOLICITUD NRO_SOL,
                               SOL.NRO_ORDEN NRO_ORDEN,
                               SOL.COD_CATEGORIA CATEGORIA,
                               SOL.COD_USR_RESPONSABLE USR_RESP,
                               SOL.VALOR_BOLSA V_BOLSA,
                               SOL.COD_PROVEEDOR COD_PROVE,
                               SOL.COBRAIVA
                          FROM BSME.SOLICITUD SOL) SOL
                 WHERE TOC.CTOC_PROV = PROV.PROV_PROV
                   AND VGES.ORDEN = TOC.CTOC_NROOC
                   AND (TOC.CTOC_NROOC LIKE '%" . $busqueda . "%'
                        OR UPPER (PROV.PROV_DESCRI) LIKE UPPER ('%" . $busqueda . "%'))
                   AND TOC.CTOC_NROOC = SOL.NRO_ORDEN(+)
                UNION                
                SELECT TO_CHAR(TCON.CONT_NROCON) ORDEN_NUMERO,
                       PROV.PROV_PROV ID_PROVEEDOR,
                       TCON.CONT_VALOR + CONTR.VALOR_TOTAL_ADICPROR@SFI(TCON.CONT_CIAS,TCON.CONT_VIGCONT, 
                       TCON.CONT_TPDO, TCON.CONT_NROCON) VALOR_TOTAL,
                       NVL(TO_CHAR(TCON.CONT_FECTERM, 'dd/mm/yyyy'), 'N-A') FECHA_ENTREGA,
                       TCON.CONT_STATUS ESTATUS,
                       NVL(TO_CHAR(TCON.CONT_FECINI, 'mm/dd/yyyy'), 'N-A') FECHA_INICIO,
                       PROV.PROV_NRONIT NRO_NIT,
                       PROV.PROV_PROV PROV_USER, 
                       PROV.PROV_DESCRI PROV_DESCRI,
                       PROV.PROV_RESPON PROV_RESPONSABLE, 
                       PROV.PROV_NITRESP NIT_RESPONSABLE, 
                       TRIM(PROV.PROV_NROTLF) TELEFONO_RESP, 
                       PROV.PROV_NROFAX FAX_RESPONSABLE, 
                       TRIM(PROV.PROV_MAIL) EMAIL,
                       NVL(SOL.NRO_ORDEN, '0') NRO_ORDEN_LOCAL,
                       SOL.CATEGORIA, 
                       SOL.USR_RESP,
                       SOL.V_BOLSA,
                       TCON.CONT_OBSERV1 || ' ' ||TCON.CONT_OBSERV2 DESCRIPCION,
                       CASE WHEN NVL(TO_CHAR(TCON.CONT_FECTERM, 'yyyy-MM-dd'), 'N-A') = 'N-A' THEN 'VENCIDO'
                            WHEN TCON.CONT_FECTERM > SYSDATE THEN 'VIGENTE'
                        ELSE 'VENCIDO'
                        END AS ESTADO,
                       SOL.NRO_SOL,
                       BSME.PAK_SOLICITUD.SALDO_BOLSA(SOL.NRO_SOL) SALDO_BOLSA,
                       CASE WHEN BSME.PAK_SOLICITUD.COBRA_IVA(SOL.NRO_SOL) = 'S' THEN
                        NVL(BSME.PAK_SOLICITUD.VALOR_SERVICIOS(SOL.COD_PROVE, SOL.NRO_SOL) * BSME.PAK_PARAMETRO.VALOR_PARAM('IVA', 'N'), 0)
                        ELSE 0
                       END VAL_SER_IVA,
                       NVL(BSME.PAK_SOLICITUD.VALOR_SERVICIOS(SOL.COD_PROVE, SOL.NRO_SOL), 0) VAL_SER,
                       CASE WHEN NVL(BSME.PAK_SOLICITUD.SALDO_BOLSA(SOL.NRO_SOL), 0) <= (SOL.V_BOLSA*0.2) THEN 'S'
                        ELSE 'N'
                       END AS ALERTA,
                       CASE WHEN (TO_DATE(SYSDATE, 'dd/mm/yyyy') - TO_DATE(NVL(TCON.CONT_FECTERM, SYSDATE) - 45, 'dd/mm/yyyy')) >= 0 THEN 'S'
                        ELSE 'N' 
                       END AS ALERTAFECHA,
                       SOL.COBRAIVA
                  FROM CONTR.CO_TCONT@SFI TCON, CONSTR.IN_TPROV@SFI PROV,
                       (SELECT SOL.SEQ_NRO_SOLICITUD NRO_SOL,
                               SOL.NRO_ORDEN NRO_ORDEN,
                               SOL.COD_CATEGORIA CATEGORIA,
                               SOL.COD_USR_RESPONSABLE USR_RESP,
                               SOL.VALOR_BOLSA V_BOLSA,
                               SOL.COD_PROVEEDOR COD_PROVE,
                               SOL.COBRAIVA
                          FROM BSME.SOLICITUD SOL) SOL
                 WHERE TCON.CONT_AUXI = PROV.PROV_PROV
                   AND (TCON.CONT_NROCON LIKE '%" . $busqueda . "%'
                        OR UPPER (PROV.PROV_DESCRI) LIKE UPPER ('%" . $busqueda . "%'))
                   AND TCON.CONT_NROCON = SOL.NRO_ORDEN(+)";
        
        $query = $this->db->query($sql);

        $resultado = $query->result();

        return $resultado;
    }

    /**
     * Método para agregar una nueva solicitud.
     *
     * @date 14/03/2016.
     * @authos D4P.
     */
    function agregarSolicitud($data) {
        
        $mensaje = '';
        $params = array(
            array('name' => ':p_seq_nro_solicitud',
                'value' => intval($data['nro_sol']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_nro_orden',
                'value' => intval($data['nro_orden']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_cod_proveedor',
                'value' => strval($data['codProveedor']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_usr_contacto',
                'value' => strval($data['cod_usr_prov']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_usr_responsable',
                'value' => strval($data['usr_resp']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_categoria',
                'value' => strval($data['categoria']),
                'type' => SQLT_CHR,
                'length' => 40
            ),
            array('name' => ':p_valor_bolsa',
                'value' => $data['valortotal'],
                'type' => SQLT_CHR, //SQLT_NUM, //SQLT_FLT,
                'length' => 32
            ),
            array('name' => ':p_fecha_vencimiento',
                'value' => $data['fecha_vence'],
                'type' => SQLT_ODT,
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
            array('name' => ':p_nombre_proveedor',
                'value' => strval($data['nombre_proveedor']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_apellido_proveedor',
                'value' => strval($data['apellido_proveedor']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_proveedor_email',
                'value' => strval($data['correo_proveedor']),
                'type' => SQLT_CHR,
                'length' => 45
            ),
            array('name' => ':p_cobra_iva',
                'value' => $data['chiva'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_mensaje',
                'value' => &$mensaje,
                'type' => SQLT_CHR,
                'length' => 500
            )
        );
        //echo json_encode($params);
        $sql = "begin
                    bsme.pak_solicitud.REGISTRA_SOLICITUD(:p_seq_nro_solicitud,
                                                          :p_nro_orden, 
                                                          :p_cod_proveedor, 
                                                          :p_cod_usr_contacto, 
                                                          :p_cod_usr_responsable, 
                                                          :p_categoria, 
                                                          :p_valor_bolsa, 
                                                          to_date(:p_fecha_vencimiento, 'dd/mm/yyyy'), 
                                                          :p_activo, 
                                                          :p_usuario, 
                                                          :p_nombre_proveedor, 
                                                          :p_apellido_proveedor, 
                                                          :p_proveedor_email,
                                                          :p_cobra_iva,
                                                          :p_mensaje);
                    commit;
                end;";

        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {
            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        
        $r = ociexecute($stmt);

        if ($r) {
            $r = $mensaje;
        }

        return $r;
    }

    /**
     * Método para obtener valores de la bolsa de solicitud.
     *
     * @date 16/03/2016.
     * @author D4P.
     */
    function obtenerSolicitudValor($data) {

        $sql = "SELECT SEQ_NRO,
                       NRO_ORDEN,
                       VALOR_BOLSA,
                       FECHA_VENCIMIENTO,
                       BSME.PAK_SOLICITUD.SALDO_BOLSA(P_NRO_SOLICITUD=> SOL.SEQ_NRO) SALDO_BOLSA,
                       COD_USR_RESPONSABLE,
                       COD_USR_CONTACTO
                  FROM BSME.V_SOLICITUD SOL
                 WHERE SOL.ACTIVO = 'S'
                   AND SOL.COD_PROVEEDOR = ".$data['codprove']." 
                   AND SOL.NRO_ORDEN = ".$data['nro_orden']." ";
        
        $query = $this->db->query($sql);

        $result = $query->result();

        return $result[0];
    }
    
    /**
     * Método para obtener la descripcion del proveedor.
     * 
     * @param string $codprove codigo del proveedor
     * @return string con el nombre del proveedor.
     * @date 04/05/2016.
     * @author D4P.
     */
    function descripcionProveedor($codprove) {
        
        $sql = "SELECT bsme.pak_solicitud.proveedor(p_cod_proveedor=> ".$codprove.") NOMBREC
                  FROM dual";
        
        $query = $this->db->query($sql);
        $result = $query->result();
        
        return $result[0];
    }
    
    /**
     * Método para obtener la descripcion del administrador de la bolsa.
     * @param type $nro_soli
     * @return type
     * @date 04/05/2016.
     * @author D4P.
     */
    function descripcionAdministrador($nro_soli) {
        
        $sql = "SELECT bsme.pak_solicitud.administrador(p_nro_solicitud=> ".$nro_soli.") nombrec
                FROM dual";
        
        $query = $this->db->query($sql);
        $result = $query->result();
        
        return $result[0];
    }

}
?>

