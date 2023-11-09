<?php

class Debitnote_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_invoices() {
        $query = $this->db->get('invoices');
        return $query->result();
    }

    public function post_my_debit_note($xml) {
        $this->db->insert('debit_notes', $xml);
        return $this->db->insert_id();
    }

    public function get_note_by_content($xml) {
        $this->db->select('*');
		$this->db->from('debit_notes');
		$this->db->where('xml', $xml);
        $query = $this->db->get();
        return $query->result();
    }

}
?>