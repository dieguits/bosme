<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function obtenerMenus() {
        
        $sql = "SELECT SEQ_NRO,
                       DESCR
                  FROM BSME.V_MENU
                 WHERE ACT = 'S'
                ORDER BY SEQ_NRO ASC";

        $query = $this->db->query($sql);

        $resultado = $query;

        return $resultado;
    }
    
    /**
     * Métódo para dibujar el menu.
     * 
     * @date 11/04/2016.
     * @author D4P.
     */
    function dibujarMenu($data) {
        
        $sql = "SELECT SEQ_MENU,
                       MODO,
                       ACT,
                       DESCR,
                       NIVEL,
                       NVL(SUBNIVEL, '-1') SUBNIVEL,
                       ORDEN,
                       NVL(RUTA, '#') RUTA
                  FROM BSME.V_MENU_PADRE
                 WHERE CODIGO_ROL = '".$data['rol']."'
                   AND NIVEL = '".$data['nivel']."' ";
        if($data['subnivel']) {
            $sql .= " AND SUBNIVEL IS NOT NULL ";
        }else {
            $sql .= " AND SUBNIVEL IS NULL ";
        }
                   
        $sql .= "  AND ACT = 'S'
                ORDER BY ORDEN ASC";
        //var_dump($sql);
        $query = $this->db->query($sql);

        $resultado = $query;

        return $resultado;
    }


    /**
     * Método para obtener los usuarios que pueden administrar bolsas.
     *
     * @date 14/03/2016.
     * @author D4P.
     */
    function ObtenerMenuPadres() {

        $sql = "SELECT SEQ_NRO,
                       DESCR,
                       ACT
                  FROM BSME.V_MENU
                 WHERE NIV = '1'
                   AND ACT = 'S'
                ORDER BY SEQ_NRO  ";

        $query = $this->db->query($sql);

        $resultado = $query;

        return $resultado;
    }
    
    /**
     * Método para obtener el total de los usuarios creados.
     * 
     * @return type resultado de la consulta.
     * @date 06/04/2016.
     * @author D4P.
     */
    function obtenerTodosMenus() {
        
        $sql = "SELECT SEQ_NRO,
                       DESCR,
                       NIV,
                       SUBNIV,
                       ORDEN,
                       RUTA,
                       ACT,
                       TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA,
                       DESCRP
                  FROM BSME.V_MENU
                ORDER BY SEQ_NRO ASC, ORDEN DESC";

        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para obtener los menus de acuerdo al filtro de la tabla.
     * 
     * @param array $data parametros de busqueda.
     * @return array con resultado de la consulta.
     * @date 06/04/2016.
     * @author D4P.
     */
    function obtenerMenusFiltrados($data) {
        
        $sql = "SELECT *
                  FROM (SELECT ROWNUM FILA,
                               SEQ_NRO,
                               DESCR,
                               NIV,
                               SUBNIV,
                               ORDEN,
                               RUTA,
                               ACT,
                               TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA,
                               DESCRP
                          FROM BSME.V_MENU)
                 WHERE  FILA BETWEEN ".$data['start']." AND ".($data['start'] + $data['length'])." 
                 ORDER BY SEQ_NRO ASC, ORDEN DESC ";
        
        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para hacer el guardado del usuario.
     * 
     * @param array $data parametros para hacer la insercion.
     * @return respuesta con el resultado.
     * @date 06/04/2016.
     * @author D4P.
     */
    function guardarMenu($data) {
        
        $params = array(
            array('name' => ':p_descripcion',
                'value' => strval($data['descri']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_nivel',
                'value' => strval($data['nivel']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_subnivel',
                'value' => $data['subnivel'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_orden',
                'value' => $data['orden'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_ruta',
                'value' => $data['ruta'],
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
                    bsme.pak_menu.INSERTA(:p_descripcion, 
                                          :p_nivel, 
                                          :p_subnivel, 
                                          :p_orden, 
                                          :p_ruta, 
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
    
    function actualizarMenu($data) {
        
        $params = array(
            array('name' => ':p_seq_nro_menu',
                'value' => intval($data['seq']),
                'type' => SQLT_NUM,
                'length' => 32
            ),
            array('name' => ':p_descripcion',
                'value' => strval($data['descri']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_nivel',
                'value' => strval($data['nivel']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_subnivel',
                'value' => $data['subnivel'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_orden',
                'value' => $data['orden'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_ruta',
                'value' => $data['ruta'],
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
                    bsme.pak_menu.actualiza(:p_seq_nro_menu, 
                                            :p_descripcion, 
                                            :p_nivel, 
                                            :p_subnivel, 
                                            :p_orden, 
                                            :p_ruta, 
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

