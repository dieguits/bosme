<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Método para hacer la validacion y el inicio de session.
     *
     * @date 04/03/2016.
     * @author D4P.
     */
    function validarIngreso($data) {
        //print_r($data['usuario']);
        $query = $this->db->get_where('usuario', array('nombreusuario' => $data['usuario'], 'claveusuario' => $data['password']));
        //print_r($query->row()->usuario);
        if ($query->num_rows() > 0) {
            return $row = $query->row();
            return $query;
            //return true;
        } else
            return false;
    }

    /**
     * Método para validar si el usuario tiene ingreso al sistema.
     *
     * @date 08/03/2016.
     * @author D4P.
     */
    function vaidar_ingreso($data) {

        $sql = "SELECT BSME.PAK_USUARIO.chk_ingreso(p_cod_usuario=> '" . $data['codusuario'] . "', p_passwd=> '" . $data['clave'] . "') RPT 
                    FROM   DUAL";

        $query = $this->db->query($sql);
        $result = $query->result();

        return $result[0];
    }

    /**
     * Método para obtener los datos del usuario por el codigo.
     *
     * @date 08/03/2016.
     * @author D4P.
     */
    function obtenerUsuarioByCodUsuario($data) {
        
        $sql = "SELECT COD_USUA, NOMBREC, COD_ROL, CORREO
                    FROM   BSME.V_USUARIO
                    WHERE  COD_USUA = '" . $data['codusuario'] . "' ";

        $query = $this->db->query($sql);
        $result = $query->result();

        return $result[0];
    }

    /**
     * Método de prueba de conexion.
     *
     *
     * @date 04/03/2016.
     */
    function pruebaObtener() {
        $sql = "SELECT * FROM BSME.V_PRUEBA";
        $query = $this->db->query($sql);

        return $query->result();
    }
    
    /**
     * Método para recuperar clave de usuario.
     * 
     * @param type $data
     * @return string
     * @date 07/04/2016.
     * @author D4P.
     */
    function recuperarClave($data) {
        
        $mensaje = '';
        $params = array(
            array('name' => ':p_cod_usuario',
                'value' => strval($data),
                'type' => SQLT_CHR,
                'length' => 32
            ),
            array('name' => ':p_mensaje',
                'value' => &$mensaje,
                'type' => SQLT_CHR,
                'length' => 5000
            )
        );
        
        $sql = "begin
                    bsme.pak_usuario.recupera_clave(:p_cod_usuario, 
                                                    :p_mensaje);
                end;";
        
        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {

            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        
        $rpt = ociexecute($stmt);
        
        if($rpt) {
            $rpt = $mensaje;
        }
        return $rpt;
    }

}

?>