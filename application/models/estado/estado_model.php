<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Estado_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener los estados de los servicios.
     *
     * @date 22/03/2016.
     * @author D4P.
     */
    function obtenerEstados($data) {

        $sql = "SELECT EST.COD_ESTADO, EST.DESCRI
                  FROM V_ESTADO_CONTROL EST
                 WHERE EST.ACTIVO = 'S' 
                   AND (EST.COD_OLD LIKE '%".$data."%' 
                        OR EST.COD_ESTADO LIKE '%".$data."%' ) 
                   AND EST.ACTIVO = 'S'
                   AND EST.CTRL_ACT = 'S' ";
        /*
        if($data != '') {
            $sql .= "AND (EST.COD_OLD LIKE '%".$data."%' OR EST.COD_ESTADO LIKE '%".$data."%' )";
                       }*/

        $query = $this->db->query($sql);

        return $query;
    }
    
    /**
     * Método para obtener todos los estados.
     * 
     * @return array con el resultado de la consulta.
     * @date 07/04/2016.
     * @author D4P.
     */
    function obtenerTodosEstados() {
        
        $sql = "SELECT COD, 
                       DESCR,
                       ACT,
                       TO_DATE(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                  FROM BSME.V_ESTADO
                  ORDER BY COD ASC";
        
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
    function obtenerEstadosFiltrados($data) {
        
        $sql = "SELECT *
                  FROM   (SELECT ROWNUM FILA,
                                 COD,
                                 DESCR,
                                 ACT,
                                 TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                            FROM BSME.V_ESTADO)
                 WHERE  FILA BETWEEN ".$data['start']." AND ".($data['start'] + $data['length'])."
                ORDER BY 2 ASC ";
        
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
    function guardarEstado($data) {
        
        $params = array(
            array('name' => ':p_cod_estado',
                'value' => strval($data['cod']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_descripcion',
                'value' => strval($data['descri']),
                'type' => SQLT_CHR,
                'length' => 32
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
                    bsme.pak_estado.INSERTA(:p_cod_estado, 
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
    
    /**
     * Método para actualizar el estado.
     * 
     * @param array $data con parametros de actualización.
     * @return resultado de la consulta.
     * @date 07/04/2016.
     * @author D4P.
     */
    function actualizarEstado($data) {
        
        $params = array(
            array('name' => ':p_cod_estado',
                'value' => strval($data['cod']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_old_estado',
                'value' => strval($data['cod_old']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_descripcion',
                'value' => strval($data['descri']),
                'type' => SQLT_CHR,
                'length' => 32
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
                    bsme.pak_estado.actualiza(:p_cod_estado, 
                                              :p_cod_old_estado, 
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

