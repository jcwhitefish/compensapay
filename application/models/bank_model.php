<?php
class Bank_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_all_banks() {
        $query = $this->db->get('cat_bank');
        return $query->result();
    }
    public function get_bank($clabe) { 
        $condiciones = array('bnk_clave' => $clabe);
        $query = $this->db->where($condiciones);
        $query = $this->db->get('cat_bancos');
        return $query->result(); 
    }
    
}
