<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parametro_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener las categorias de las solicitudes.
     *
     * @date 30/03/2016.
     * @author D4P.
     */
    function obtenerParametros() {

        $sql = "SELECT COD, 
                       DESCR
                  FROM BSME.V_CATEGORIA
                 WHERE ACT = 'S' ";

        $query = $this->db->query($sql);

        return $query;
    }

    /**
     * Función para consultar todas las categorias.
     * 
     * @return type todo el registro de categorias.
     * @date 05/04/2016.
     * @author D4P.
     */
    function obtenerTodosParametros() {

        $sql = "SELECT COD_PARAM,
                       DESCR,
                       TIPO_PARAM,
                       CASE WHEN TIPO_PARAM = 'N' THEN 'NUMERICO'
                       ELSE 'CARACTERES' END PARAM_DESCR,
                       VLR_N,
                       VLR_C,
                       ACT,
                       TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                  FROM BSME.V_PARAMETRO ";

        $query = $this->db->query($sql);
        $resultado = $query->result();

        return $resultado;
    }

    /**
     * Función para obtener las categorias por inicio y fin.
     * 
     * @param array $data con los parametros de la busqueda. 
     * @return type los registros por la busqueda
     * @date 05/04/2016.
     * @author D4P.
     */
    function obtenerParametrosFiltrados($data) {

        $sql = "SELECT *
                  FROM (SELECT ROWNUM FILA, 
                               COD_PARAM,
                               DESCR,
                               TIPO_PARAM,
                               CASE WHEN TIPO_PARAM = 'N' THEN 'NUMERICO'
                               ELSE 'CARACTERES' END PARAM_DESCR,
                               VLR_N,
                               VLR_C,
                               ACT,
                               TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                          FROM BSME.V_PARAMETRO)
                 WHERE  FILA BETWEEN " . $data['start'] . " AND " . ($data['start'] + $data['length']) . " ";

        $query = $this->db->query($sql);
        $resultado = $query->result();

        return $resultado;
    }

    /**
     * Método para guardar una nueva categoria.
     * 
     * @param type $data parametros de entrada.
     * @date 05/04/2016.
     * @author D4P.
     */
    function guardarParametro($data) {
        
        $params = array(
            array('name' => ':p_cod_parametro',
                'value' => strval($data['codigo']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_descripcion',
                'value' => strval($data['descri']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_tipo_parametro',
                'value' => strval($data['tiparam']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_vlr_n',
                'value' => strval($data['vlrn']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_vlr_c',
                'value' => strval($data['vlrc']),
                'type' => SQLT_CHR,
                'length' => 32
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

        $sql = "BEGIN
                    bsme.pak_parametro.inserta (:p_cod_parametro,
                                                :p_descripcion,
                                                :p_tipo_parametro,
                                                :p_vlr_n,
                                                :p_vlr_c,
                                                :p_activo,
                                                :p_usuario);
                    COMMIT;
                END;";

        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {

            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }

        $rpt = ociexecute($stmt);

        return $rpt;
    }

    /**
     * Método para actualizar la categoria.
     * 
     * @param array $data con los parametros de entrada.
     * @return respuesta.
     * @date 05/04/2016.
     * @author D4P.
     */
    function actualizarParametro($data) {

        $params = array(
            array('name' => ':p_cod_parametro',
                'value' => strval($data['codigo']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_descripcion',
                'value' => strval($data['descri']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_tipo_parametro',
                'value' => strval($data['tiparam']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_vlr_n',
                'value' => strval($data['vlrn']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_vlr_c',
                'value' => strval($data['vlrc']),
                'type' => SQLT_CHR,
                'length' => 32
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

        $sql = "BEGIN
                    bsme.pak_parametro.actualiza (:p_cod_parametro,
                                                  :p_descripcion,
                                                  :p_tipo_parametro,
                                                  :p_vlr_n,
                                                  :p_vlr_c,
                                                  :p_activo,
                                                  :p_usuario);
                    COMMIT;
                END;";

        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {

            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }

        $rpt = ociexecute($stmt);

        return $rpt;
    }

}
?>

