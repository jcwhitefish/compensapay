<?php
class Type_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_all_types() {
        $query = $this->db->get('cat_giro');
        return $query->result();
    }
    
}
