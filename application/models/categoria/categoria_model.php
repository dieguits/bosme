<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener las categorias de las solicitudes.
     *
     * @date 30/03/2016.
     * @author D4P.
     */
    function obtenerCategorias() {

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
    function obtenerTodasCategorias() {
        
        $sql = "SELECT COD, 
                       DESCR,
                       ACT,
                       TO_DATE(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                  FROM BSME.V_CATEGORIA
                  ORDER BY COD ASC";

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
    function obtenerCategoriasFiltradas($data) {
        
        $sql = "SELECT *
                  FROM   (SELECT ROWNUM FILA,
                                 COD,
                                 DESCR,
                                 ACT,
                                 TO_CHAR(FECHA_CREA, 'dd/mm/yyyy') FECHA_CREA
                            FROM BSME.V_CATEGORIA)
                 WHERE  FILA BETWEEN ".$data['start']." AND ".($data['start'] + $data['length'])."
                ORDER BY 2 ASC ";
        
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
    function guardarCategoria($data) {
        
        $params = array(
            array('name' => ':p_cod_categoria',
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
                    BSME.pak_categoria.INSERTA(:p_cod_categoria, 
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
     * Método para actualizar la categoria.
     * 
     * @param array $data con los parametros de entrada.
     * @return respuesta.
     * @date 05/04/2016.
     * @author D4P.
     */
    function actualizarCategoria($data) {
        
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

