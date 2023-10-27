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
        $this->db->from('users');
        $this->db->where('id_company', $user);
        $query = $this->db->get();
        $company = ($query->result())[0]->id_company;
		$this->db->select('*');
        $this->db->from('companies');
        $this->db->where('id', $company);
        $query = $this->db->get();
        $rfc = $query->result()[0]->rfc;
        $this->db->select('*');
		$this->db->from('invoices');
		$this->db->where('receiver_rfc', $rfc);
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

    public function xml_exists($xml) {
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('xml_document', $xml);
        $query = $this->db->get();
        return $query->num_rows() > 0; 
    }

    public function is_your_rfc($id, $rfc) {

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id_company', $id);
        $query = $this->db->get();
        $company = ($query->result())[0]->id_company;
        $this->db->select('*');
        $this->db->from('companies');
        $this->db->where('id', $company);
        $query = $this->db->get();
        return ((($query->result())[0]->rfc) === $rfc);

    }

    public function update_status($id, $status) {

        $factura = array(
			"status" => $status,
            "updated_at" => "2023-25-10"
		);

        $this->db->where('id', $id);
		$this->db->update('operations', $factura);

        return; 
    }
  
}
?>