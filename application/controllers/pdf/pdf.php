<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends CI_Controller {

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        //$this->load->model('menu/menu_model');
    }

    /**
     * Método index de la clase del controlador login.
     *
     * @date 04/03/2016
     * @author Diego.Pérez.
     */
    public function index() {
        $this->load->helper('form');
        $this->load->view('pdf/pdf');
    }

}

?>
