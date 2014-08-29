<?php

class mod_usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_usuario() {
        $consulta = $this->db->get("vusuario");
        return $consulta->result();
    }
    function insert_usuario($data) {
        $this->db->insert('usuario', $data);
    }

}
