<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rol_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener los roles.
     *
     * @date 06/04/2016.
     * @author D4P.
     */
    function obtenerRoles() {

        $sql = "SELECT COD,
                       DESCR,
                       ACT,
                       TO_DATE(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                  FROM BSME.V_ROL
                 WHERE ACT = 'S' ";

        $query = $this->db->query($sql);

        return $query;
    }
    
    /**
     * Método para obtener todos los roles.
     * 
     * @return array con los resultados de la consulta.
     * @date 06/04/2016.
     * @author D4P.
     */
    function obtenerTodosRoles() {
        
        $sql = "SELECT COD,
                       DESCR,
                       ACT,
                       TO_DATE(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                  FROM BSME.V_ROL";

        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para filtrar los datos de busqueda de la consulta.
     * 
     * @param array $data con los parametros para el filtro.
     * @return array con los resultados de la consulta.
     * @date 06/04/2016.
     * @author D4P.
     */
    function obtenerRolesFiltrados($data) {
        
        $sql = "SELECT *
                  FROM (SELECT ROWNUM FILA,
                               COD,
                               DESCR,
                               ACT,
                               TO_DATE(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                          FROM BSME.V_ROL)
                 WHERE FILA BETWEEN ".$data['start']." AND ".($data['start'] + $data['length'])." ";

        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para guardar un nuevo rol.
     * 
     * @param array $data con los parametro de insercion.
     * @return respuesta con resultado.
     * @date 06/04/2016.
     * @author D4P.
     */
    function guardarRol($data) {
        
        $params = array(
            array('name' => ':p_codigo_rol',
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
                'value' => $data['usuario'],
                'type' => SQLT_CHR,
                'length' => 32
            )
        );

        $sql = "BEGIN
                    bsme.pak_rol.INSERTA(:p_codigo_rol, 
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
     * Método para actualizar el rol.
     * 
     * @param array $data con los parametros de entrada.
     * @return respuesta.
     * @date 06/04/2016.
     * @author D4P.
     */
    function actualizarRol($data) {
        
        $params = array(
            array('name' => ':p_codigo_rol',
                'value' => strval($data['cod']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_old_rol',
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
                'value' => $data['usuario'],
                'type' => SQLT_CHR,
                'length' => 32
            )
        );

        $sql = "BEGIN
                    bsme.pak_rol.actualiza(:p_codigo_rol, 
                                           :p_cod_old_rol, 
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


