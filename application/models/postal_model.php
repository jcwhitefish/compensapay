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
    public function get_postal($condiciones) { 
        // TODO: Asi podemos traer 1 registro en especifico bajo ciertas condiciones
        $query = $this->db->get_where('cat_zipcode', $condiciones);
        return $query->row_array();
    }
}
