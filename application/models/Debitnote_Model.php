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

}
?>