<?php
class Regimen_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_all_regimenes($type) {
        $regimen = 'rg_p'.$type; 
        $condiciones = array($regimen => '1');
        $query = $this->db->where($condiciones);
        $query = $this->db->get('cat_regimenfiscal');
        return $query->result(); 
    }
    
}
