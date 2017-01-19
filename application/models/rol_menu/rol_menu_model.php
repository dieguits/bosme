<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rol_menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener los roles.
     *
     * @date 11/04/2016.
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
     * @date 11/04/2016.
     * @author D4P.
     */
    function obtenerTodosRolesMenu() {
        
        $sql = "SELECT SEQ_ROL_MENU,
                       COD_ROL,
                       DESCR_ROL,
                       SEQ_MENU,
                       DESCR_MENU,
                       MODO,
                       DESCR_MODO,
                       ACT,
                       TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                  FROM BSME.V_ROL_MENU";

        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para filtrar los datos de busqueda de la consulta.
     * 
     * @param array $data con los parametros para el filtro.
     * @return array con los resultados de la consulta.
     * @date 11/04/2016.
     * @author D4P.
     */
    function obtenerRolesMenuFiltrados($data) {
        
        $sql = "SELECT *
                  FROM (SELECT ROWNUM FILA,
                               SEQ_ROL_MENU,
                               COD_ROL,
                               DESCR_ROL,
                               SEQ_MENU,
                               DESCR_MENU,
                               MODO,
                               DESCR_MODO,
                               ACT,
                               TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                          FROM BSME.V_ROL_MENU)
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
    function guardarRolMenu($data) {
        
        $params = array(
            array('name' => ':p_codigo_rol',
                'value' => strval($data['rol']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_seq_nro_menu',
                'value' => intval($data['menu']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_modo',
                'value' => strval($data['modo']),
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
                    bsme.pak_rol_menu.inserta (:p_codigo_rol,
                                               :p_seq_nro_menu,
                                               :p_modo,
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
    function actualizarRolMenu($data) {
        
        $mensaje = '';
        
        $params = array(
            array('name' => ':p_seq_nro_rol_menu',
                'value' => intval($data['seq_nro_rol_menu']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_codigo_rol',
                'value' => strval($data['rol']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_seq_nro_menu',
                'value' => intval($data['menu']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_modo',
                'value' => strval($data['modo']),
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
                'length' => 1000
            )
        );

        $sql = "BEGIN
                    bsme.pak_rol_menu.actualiza (:p_seq_nro_rol_menu,
                                                 :p_codigo_rol,
                                                 :p_seq_nro_menu,
                                                 :p_modo,
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
        
        return $mensaje;
    }
    
    /**
     * Método que valida si se puede hacer la inserción de un nuevo registro.
     * 
     * @param array $data con los parametros.
     * @return string con la validación.
     * @date 11/04/2016.
     * @author D4P.
     */
    function permiteInsertar($data) {
        
        $sql = "SELECT bsme.pak_rol_menu.check_permite(p_codigo_rol=> '".$data['rol']."', p_seq_nro_menu=> ".$data['menu'].") permite
                  FROM DUAL";
        
        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado[0];
    }

}
?>


