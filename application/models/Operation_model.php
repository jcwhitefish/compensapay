<?php

class Operation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function get_my_operation($user) {
        $this->db->select('operations.*, ip.uuid, ip.created_at as date_invoice, ic.uuid as uuid_relation,
        companies.short_name, companies.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie,
        LEFT(SUBSTRING_INDEX(debit_notes.xml_document, \'"1.1" UUID="\', -1), 36) AS uuid_nota, debit_notes.total as money_nota ');
		$this->db->from('operations');
		//$this->db->where('id_uploaded_by', $user);
        $this->db->join('debit_notes', 'debit_notes.id = operations.id_debit_note', 'left');
        $this->db->join('invoices as ip', 'ip.id = operations.id_invoice', 'left');
        $this->db->join('invoices as ic', 'ic.id = operations.id_invoice_relational', 'left');
        $this->db->join('companies', 'companies.id = operations.id_provider');
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