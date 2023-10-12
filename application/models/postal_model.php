<?php
class Postal_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_all_postal($zip) {
        $condiciones = array('zip_code' => $zip);
        $query = $this->db->where($condiciones);
        $query = $this->db->get('cat_zipcode');
        return $query->result(); 
    }
    
}
