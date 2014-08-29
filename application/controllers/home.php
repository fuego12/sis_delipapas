<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_usuario'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->logged()) {
            header('Location: ' . base_url('login'));
        } else {
            $data['container'] = $this->load->view('home/home_view', null, true);
            $this->load->view('home/body', $data);
        }
    }

    

    public function registrar_prueba() {
        $usuario = "Yuichi";
        $pass = md5("1234");
        $data = array(
            'nomb_usu' => $usuario,
            'pass_usu' => $pass,
            'esta_usu' => 'A',
            'codi_rol' => '1'
        );
        $this->mod_usuario->insert_usuario($data);
        echo "Registrado";
    }

    public function logged() {
        return $this->session->userdata('logged');
    }

    public function admin() {
        if ($this->session->userdata('codi_rol') == '1') {
            return true;
        } else {
            return false;
        }
    }

}
