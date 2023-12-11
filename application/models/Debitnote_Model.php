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
        $dn_insert = $this->db->insert_id();
        $this->update_uuid($dn_insert);
        return $dn_insert;
    }

    private function update_uuid($id) {
        //Extrae y actualiza el UUID de la nota
        $this->db->select('LEFT(SUBSTRING_INDEX(debit_notes.xml_document, \'"1.1" UUID="\', -1), 36) AS uuid_nota');
        $this->db->from('debit_notes');
		$this->db->where('id', $id);
        $query = $this->db->get();
        $selected = $query->result();
        $uuid = $selected[0]->uuid_nota;

        $data = array(
			"uuid" => $uuid
		);

        $this->db->where('id', $id);
		$this->db->update('debit_notes', $data);

        return;
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