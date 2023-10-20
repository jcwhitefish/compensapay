<?php

class Invoice_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_invoices() {
        $query = $this->db->get('invoices');
        return $query->result();
    }

    public function get_my_invoices($user) {
        $this->db->select('*');
		$this->db->from('invoices');
		$this->db->where('id_user', $user);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_invoices_by_id($id) {
        $this->db->select('*');
		$this->db->from('invoices');
		$this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_invoices_by_client($emisor) {
        $this->db->select('*');
		$this->db->from('invoices');
		$this->db->where('sender_rfc', $emisor);
        $query = $this->db->get();
        return $query->result();
    }

    public function post_my_invoice($xml) {
        $this->db->insert('invoices', $xml);
        return $this->db->insert_id();
    }

    
  
}
?>