<?php

class Operation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function get_my_operation($user, $tipo) {
        $this->db->select('operations.*, ip.uuid, ip.transaction_date, ic.uuid as uuid_relation,
        companies.short_name, companies.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie,
        debit_notes.uuid AS uuid_nota, debit_notes.total as money_nota ');
		$this->db->from('operations');
		//$this->db->where('id_uploaded_by', $user);
        $this->db->join('debit_notes', 'debit_notes.id = operations.id_debit_note', 'left');
        $this->db->join('invoices as ip', 'ip.id = operations.id_invoice', 'left');
        $this->db->join('invoices as ic', 'ic.id = operations.id_invoice_relational', 'left');
        if($tipo == 'P'){
            $this->db->join('companies', 'companies.id = operations.id_client');
        }else{
            $this->db->join('companies', 'companies.id = operations.id_provider');
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_operation_by_id($id) {
        $this->db->select('o.*, f.arteria_clabe, c.short_name as name_proveedor, d.uuid as uuid_nota, i.transaction_date, i.uuid AS uuid_factura');
		$this->db->from('operations as o');
        $this->db->join('companies as c', 'c.id = o.id_provider');
        $this->db->join('debit_notes as d', 'd.id = o.id_debit_note');
        $this->db->join('invoices as i', 'i.id = o.id_invoice');
        $this->db->join('fintech as f', 'f.companie_id = c.id', 'left');
		$this->db->where('o.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function post_my_invoice($xml) {
        $this->db->insert('operations', $xml);
        return $this->db->insert_id();
    }
    
  
}
