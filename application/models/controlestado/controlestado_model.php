<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Controlestado_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para obtener todos los estados.
     * 
     * @return array con el resultado de la consulta.
     * @date 07/04/2016.
     * @author D4P.
     */
    function obtenerTodosControlEstados() {
        
        $sql = "SELECT SEQ,
                       COD_OLD,
                       COD_NEW,
                       ACT,
                       TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                  FROM BSME.V_CONTROL_ESTADO
                  ORDER BY SEQ ASC";
        
        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para obtener los estados por filtro de la tabla.
     * 
     * @param array $data con parametros de busqueda.
     * @return array con resultado de la consulta.
     * @date 07/04/2016.
     * @author D4P.
     */
    function obtenerControlEstadosFiltrados($data) {
        
        $sql = "SELECT *
                  FROM   (SELECT ROWNUM FILA,
                                 SEQ,
                                 COD_OLD,
                                 COD_NEW,
                                 ACT,
                                 TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                            FROM BSME.V_CONTROL_ESTADO)
                 WHERE  FILA BETWEEN ".$data['start']." AND ".($data['start'] + $data['length'])."
                ORDER BY SEQ ASC ";
        
        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para guardar estado nuevo.
     * 
     * @param array $data con parametros de inserción.
     * @return resultado.
     * @date 07/04/2016.
     * @author D4P.
     */
    function guardarControlEstado($data) {
        
        $params = array(
            array('name' => ':p_cod_estado_old',
                'value' => strval($data['cod_old']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_estado_new',
                'value' => strval($data['cod_new']),
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
                    bsme.pak_control_estado.INSERTA(:p_cod_estado_old, 
                                                    :p_cod_estado_new, 
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
     * Método para actualizar el estado.
     * 
     * @param array $data con parametros de actualización.
     * @return resultado de la consulta.
     * @date 07/04/2016.
     * @author D4P.
     */
    function actualizarControlEstado($data) {
        
        $params = array(
            array('name' => ':p_seq_nro_control_estado',
                'value' => strval($data['seq_nro']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_estado_old',
                'value' => strval($data['cod_old']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_estado_new',
                'value' => strval($data['cod_new']),
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
                    bsme.pak_control_estado.actualiza(:p_seq_nro_control_estado, 
                                                      :p_cod_estado_old, 
                                                      :p_cod_estado_new, 
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

