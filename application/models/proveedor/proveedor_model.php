<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Proveedor_model extends CI_Model {
		
		function __construct(){
			parent::__construct();
		}
                
        /**
         * Método para obtener los proveedores relacionados con las solicitudes.
         *
         * @date 16/03/2016.
         * @author D4P.
         */
        function obtenerProveedores() {
            
            $sql = "SELECT COD_PROVEEDOR, 
                           NOM_PROVEEDOR, 
                           ORDEN,
                           ESTADO
                      FROM BSME.V_PROVEEDOR 
                    ORDER BY NOM_PROVEEDOR";
            
            $query = $this->db->query($sql);
            //$result = $query->result();
            
            return $query;
        }

	}

?>