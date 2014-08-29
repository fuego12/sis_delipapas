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
       
            $this->login();
        
//            $data['container'] = $this->load->view('home/index', null, true);
           
           
        
    }

    public function login() {
        
            $this->form_validation->set_rules('usuario', 'Username', 'required');
            $this->form_validation->set_rules('clave', 'Clave', 'required');

            if ($this->form_validation->run() == FALSE) {
                $login["form"] = array('role' => 'form');
                $login["usuario"] = array('id' => 'usuario_log', 'name' => 'usuario', 'class' => "form-control", 'placeholder' => "Usuario", 'required' => 'true');
                $login["contraseña"] = array('id' => 'clave_log', 'name' => 'clave', 'class' => "form-control", 'placeholder' => "Contraseña", 'required' => 'true');
                $login["inicio_sesion"] = array('name' => 'inicio_sesion', 'class' => "btn btn-lg btn-success btn-block", 'value' => "Inicio de sesión");
                $data['container'] = $this->load->view('login/login_view', $login, true);
//                $data['clinica'] = $this->mod_clinica->get_clinica();
                $this->load->view('home/body', $data);
            } else {
                $usuario = $this->input->post('usuario');
                $clave = md5($this->input->post('clave'));
                $usuarios = $this->mod_usuario->get_usuario();

                $acceso = false;
                foreach ($usuarios as $row) {
                    if ($row->nomb_usu == $usuario && $row->pass_usu == $clave && $row->esta_usu == 'A') {
                        $acceso = true;
                        $rol = $row->codi_rol;
                        break;
                    }
                }

                if ($acceso) {
//                    $sesion_activa = array(
//                        'estado_sesion' => 'A',
//                        'logi_usu' => $usuario,
//                        'codi_rol' => $rol,
//                        'logged' => true
//                    );
//                    $this->session->set_userdata($sesion_activa);
                    echo "Usuario correcto";
//                    $this->session->set_userdata('error_login_1', 'Correcto');
//                        $this->load->view('home_view');
//                    header('Location: ' . base_url() . 'home');
                } else {
                    echo "Usuario incorrecto";
//                    $this->session->set_userdata('error_login_1', 'El usuario y/o contraseña son incorrectas');
//                    header('Location: ' . base_url('login'));
                    
                }
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
