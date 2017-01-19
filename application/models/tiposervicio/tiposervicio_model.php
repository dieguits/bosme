<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tiposervicio_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener las categorias de las solicitudes.
     *
     * @date 30/03/2016.
     * @author D4P.
     */
    function obtenerTipoServicio() {

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
    function obtenerTodosTipoServicio() {
        
        $sql = "SELECT COD,
                       DESCRI,
                       VALOR,
                       COD_PROVEE,
                       ACT,
                       TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA,
                       SEQ_NRO,
                       PROV_DESCRI
                  FROM BSME.V_TIPO_SERV_PROVE
                ORDER BY SEQ_NRO DESC";

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
    function obtenerTipoServicioFiltrados($data) {
        
        $sql = "SELECT *
                  FROM   (SELECT ROWNUM FILA,
                                 COD,
                                 DESCRI,
                                 VALOR,
                                 COD_PROVEE,
                                 ACT,
                                 TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA,
                                 SEQ_NRO,
                                 PROV_DESCRI
                            FROM BSME.V_TIPO_SERV_PROVE)
                 WHERE  FILA BETWEEN ".$data['start']." AND ".($data['start'] + $data['length'])." 
                ORDER BY SEQ_NRO DESC";
        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para guardar un nuevo tipo de servicio.
     * 
     * @param type $data parametros de entrada.
     * @date 05/04/2016.
     * @author D4P.
     */
    function guardarTipoServicio($data) {
        
        $mensaje = '';
        $params = array(
            array('name' => ':p_seq_nro_tipo_servicio',
                'value' => intval($data['seq_nro']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_cod_tipo_servicio',
                'value' => strval($data['cod']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_old_tipo_servicio',
                'value' => strval($data['cod_old']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_descripcion',
                'value' => strval($data['descri']),
                'type' => SQLT_CHR,
                'length' => 60
            ),
            array('name' => ':p_valor',
                'value' => $data['valor'],
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_cod_proveedor',
                'value' => strval($data['prove']),
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
            ),
            array('name' => ':p_mensaje',
                'value' => &$mensaje,
                'type' => SQLT_CHR,
                'length' => 32
            )
        );

        $sql = "BEGIN
                    bsme.pak_tipo_servicio.registra_tipo_servicio (
                        :p_seq_nro_tipo_servicio,
                        :p_cod_tipo_servicio,
                        :p_cod_old_tipo_servicio,
                        :p_descripcion,
                        :p_valor,
                        :p_cod_proveedor,
                        :p_activo,
                        :p_usuario,
                        :p_mensaje);
                COMMIT;
                END;";

        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {

            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        
        $rpt = ociexecute($stmt);
        //echo '-> '.$mensaje.' <- '.json_encode($params);
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
    function actualizarTipoServicio($data) {
        
        $params = array(
            array('name' => ':p_cod_categoria',
                'value' => strval($data['cod']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_old_categoria',
                'value' => strval($data['cod_old']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_descripcion',
                'value' => strval($data['descri']),
                'type' => SQLT_CHR,
                'length' => 60
            ),
            array('name' => ':p_activo',
                'value' => $data['activo'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_usuario',
                'value' => $data['usurio'],
                'type' => SQLT_CHR,
                'length' => 32
            )
        );

        $sql = "BEGIN
                    bsme.pak_categoria.actualiza (:p_cod_categoria,
                                                  :p_cod_old_categoria,
                                                  :p_descripcion,
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


