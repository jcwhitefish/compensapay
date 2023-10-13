<?php

class Operation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function get_my_operation($user) {
        $this->db->select('*');
		$this->db->from('operation');
		$this->db->where('id_uploaded_by', $user);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function post_my_invoice($xml) {
        $this->db->insert('operation', $xml);
        return $this->db->insert_id();
    }
  
}
?>