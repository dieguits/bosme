<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contrologin {

    private $permitidos = array();

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('url');
        $this->permitidos = array('login', 'validar_ingreso');
    }

    /**
     * Función para trabajar con las sessiones.
     * 
     * @date 04/04/2016.
     */
    public function is_login() {
        //var_dump($this->CI->uri->segment(1));
        if ($this->CI->session->userdata('ingresado')) {
            //if ($this->CI->uri->segment(1) === "login") {
                //redirect(base_url(), 'location');
            //}
        } else {
            if ($this->CI->uri->uri_string() != '' 
                    && !in_array($this->CI->uri->segment(1), $this->permitidos)) {
                //redirect(site_url('login'));
                redirect(base_url());
            }
        }
    }

}
?>

