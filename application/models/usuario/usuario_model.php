<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para obtener los usuarios que pueden administrar bolsas.
     *
     * @date 14/03/2016.
     * @author D4P.
     */
    function getUsuarios() {

        $sql = "SELECT USUA.COD_USUA, USUA.NOMBREC
                      FROM BSME.V_USUARIO USUA
                     WHERE USUA.ACTIVO = 'S'
                       AND USUA.COD_ROL = 'ADM' ";

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
    function getUsuariosSinRol() {

        $sql = "SELECT USUA.COD_USUA, USUA.NOMBREC
                      FROM BSME.V_USUARIO USUA
                     WHERE USUA.ACTIVO = 'S' ";

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
    function obtenerTodosUsuarios() {
        
        $sql = "SELECT COD_USUA,
                       NOMBRE || ' ' || APELLIDO NOMBREC,
                       NOMBRE,
                       APELLIDO,
                       COD_ROL,
                       ACTIVO,
                       CORREO,
                       TO_CHAR(FECHA_CREACION, 'dd/mm/yyyy') FECHA_CREA,
                       DESCRI,
                       CLAVE,
                       COD_BACK
                  FROM BSME.V_USUARIO_ROL";

        $query = $this->db->query($sql);
        $resultado = $query->result();
        
        return $resultado;
    }
    
    /**
     * Método para obtener los usuarios de acuerdo al filtro de la tabla.
     * 
     * @param array $data parametros de busqueda.
     * @return array con resultado de la consulta.
     * @date 06/04/2016.
     * @author D4P.
     */
    function obtenerUsuariosFiltrados($data) {
        
        $sql = "SELECT *
                  FROM (SELECT ROWNUM FILA,
                               COD_USUA,
                               NOMBRE || ' ' || APELLIDO NOMBREC,
                               NOMBRE,
                               APELLIDO,
                               COD_ROL,
                               ACTIVO,
                               CORREO,
                               TO_CHAR(FECHA_CREACION, 'dd/mm/yyyy') FECHA_CREA,
                               DESCRI,
                               CLAVE,
                               COD_BACK
                          FROM BSME.V_USUARIO_ROL)
                 WHERE  FILA BETWEEN ".$data['start']." AND ".($data['start'] + $data['length'])." ";
                 
        
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
    function guardarUsuario($data) {
        
        $params = array(
            array('name' => ':p_cod_usuario',
                'value' => strval($data['cod']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_codigo_rol',
                'value' => strval($data['rol']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_nombre',
                'value' => $data['nombre'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_apellido',
                'value' => $data['apellido'],
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_correo',
                'value' => $data['correo'],
                'type' => SQLT_CHR,
                'length' => 45
            ),
            array('name' => ':p_passwd',
                'value' => $data['clave'],
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
            array('name' => ':p_cod_usr_backup',
                'value' => strval($data['usrback']),
                'type' => SQLT_CHR,
                'length' => 32
            )
        );

        $sql = "BEGIN
                    bsme.pak_usuario.inserta (:p_cod_usuario,
                                              :p_codigo_rol,
                                              :p_nombre,
                                              :p_apellido,
                                              :p_correo,
                                              :p_passwd,
                                              :p_activo,
                                              :p_usuario,
                                              :p_cod_usr_backup);
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
     * Método para actualizar usuario.
     * 
     * @param array $data con parametros.
     * @return array con resultados de la consulta.
     * @date 12/04/2016.
     * @author D4P.
     */
    function actualizarUsuario($data) {
        
        $params = array(
            array('name' => ':p_cod_usuario',
                'value' => strval($data['cod']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_cod_old_usuario',
                'value' => strval($data['cod_old']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_codigo_rol',
                'value' => strval($data['rol']),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_nombre',
                'value' => $data['nombre'],
                'type' => SQLT_CHR,
                'length' => 45
            ),
            array('name' => ':p_apellido',
                'value' => $data['apellido'],
                'type' => SQLT_CHR,
                'length' => 45
            ),
            array('name' => ':p_correo',
                'value' => $data['correo'],
                'type' => SQLT_CHR,
                'length' => 45
            ),
            array('name' => ':p_passwd',
                'value' => $data['clave'],
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
            array('name' => ':p_cod_usr_backup',
                'value' => strval($data['usrback']),
                'type' => SQLT_CHR,
                'length' => 32
            )
        );
        //echo json_encode($params);
        $sql = "BEGIN
                    bsme.pak_usuario.actualiza (:p_cod_usuario,
                                                :p_cod_old_usuario,
                                                :p_codigo_rol,
                                                :p_nombre,
                                                :p_apellido,
                                                :p_correo,
                                                :p_passwd,
                                                :p_activo,
                                                :p_usuario,
                                                :p_cod_usr_backup);
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
     * Método para obtener los datos de un determinado usuario.
     * 
     * @param array $data con parametros de busqueda.
     * @date 12/04/2016.
     * @author D4P.
     */
    public function obtenerDatosUsuario($data) {
        
        $sql = "SELECT COD_USUA,
                       NOMBREC,
                       COD_ROL,
                       ACTIVO,
                       CORREO,
                       COD_BACKUP
                  FROM BSME.V_USUARIO
                 WHERE ACTIVO = '".$data['activo']."'
                   AND COD_USUA = '".$data['usuario']."' ";
        
        $query = $this->db->query($sql);
        
        $resultado = $query->result();
        
        return $resultado[0];
    }

}
?>

