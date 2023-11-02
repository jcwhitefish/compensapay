<?php

class Operation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function get_my_operation($user) {
        $this->db->select('*');
		$this->db->from('operations');
		//$this->db->where('id_uploaded_by', $user);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_operation_by_id($id) {
        $this->db->select('*');
		$this->db->from('operations');
		$this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function post_my_invoice($xml) {
        $this->db->insert('operations', $xml);
        return $this->db->insert_id();
    }
    
  
}
?>