<?php

class Operation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_my_operation($user, $tipo) {
        $this->db->select('o.*, ip.uuid, ip.transaction_date, ic.uuid as uuid_relation,
        companies.short_name, companies.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie,
        debit_notes.uuid AS uuid_nota, debit_notes.total as money_nota ');
		$this->db->from('operations as o');
		//$this->db->where('id_uploaded_by', $user);
        $this->db->join('debit_notes', 'debit_notes.id = o.id_debit_note', 'left');
        $this->db->join('invoices as ip', 'ip.id = o.id_invoice', 'left');
        $this->db->join('invoices as ic', 'ic.id = o.id_invoice_relational', 'left');
        if($tipo == 'P'){
            $this->db->join('companies', 'companies.id = o.id_client');
            $this->db->where('o.id_provider', $user);
        }else{
            $this->db->join('companies', 'companies.id = o.id_provider');
            $this->db->where('o.id_client', $user);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_operation_calendar($user, $mes = null) {
        $year = date('Y', time());
        $mes = $mes === null ? date('Y', time()) : $mes;
        $fechaI = date('Y-m-d', strtotime("01-{$mes}-{$year}"));
        $fechaF = date('Y-m-t', strtotime("01-{$mes}-{$year}"));

        //$this->db->select('o.*, ip.uuid, ip.transaction_date, ic.uuid as uuid_relation,
        //c.short_name, c.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie,
        //d.uuid AS uuid_nota, d.total as money_nota ');
        $this->db->select('o.*, ip.id AS urlid, ip.uuid AS uuid, ip.transaction_date, 
                            ic.id AS urlidrel,ic.uuid as uuid_relation, 
                            c.short_name, c.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie,
                            d.id AS urldeb, d.uuid AS uuid_nota, d.total as money_nota ');
		$this->db->from('operations as o');
        $this->db->join('debit_notes as d', 'd.id = o.id_debit_note', 'left');
        $this->db->join('invoices as ip', 'ip.id = o.id_invoice', 'left');
        $this->db->join('invoices as ic', 'ic.id = o.id_invoice_relational', 'left');
        $this->db->join('companies as c', 'c.id = o.id_provider');
        $this->db->where("(o.id_provider = $user OR o.id_client = $user)");
        $this->db->where("(o.status = 0 OR o.status = 4)");
        $this->db->where("(ip.transaction_date BETWEEN '$fechaI' AND '$fechaF')");

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
