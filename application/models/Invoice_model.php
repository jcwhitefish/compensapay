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

    public function get_provider_invoices($user, $rfc_rec) {
        $this->db->select('c.short_name AS name_provee, c2.short_name AS name_client, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c', 'c.id = u.id_company');
        $this->db->join('invoices AS i', 'i.sender_rfc = c.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.receiver_rfc');
		$this->db->where('c.id', $user);
		$this->db->where('i.receiver_rfc', $rfc_rec);
		$this->db->where('i.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_available_invoices($user) {
        $this->db->select('c.short_name AS name_client, c2.short_name AS name_provee, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c', 'c.id = u.id_company');
        $this->db->join('invoices AS i', 'i.sender_rfc = c.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.receiver_rfc');
		$this->db->where('c.id', $user);
		$this->db->where('i.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_provider_invoices_tabla($user) {
        $this->db->select('c.short_name AS name_provee, c2.short_name AS name_client, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c', 'c.id = u.id_company');
        $this->db->join('invoices AS i', 'i.receiver_rfc = c.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.sender_rfc');
		$this->db->where('c.id', $user);
		$this->db->where('i.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_client_invoices($user) {
        $this->db->select('c.short_name AS name_client, c2.short_name AS name_provee, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c', 'c.id = u.id_company');
        $this->db->join('invoices AS i', 'i.receiver_rfc = c.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.sender_rfc');
		$this->db->where('c.id', $user);
		$this->db->where('i.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_provider_movements($user) {
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
        $this->db->from('balance');
        $this->db->where('source_rfc', $rfc);
        $this->db->or_where('receiver_rfc', $rfc);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_invoices_by_id($id) {
        $this->db->select('i.*');
		$this->db->from('invoices as i');
		$this->db->where('i.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_invoices_by_client($emisor) {
        $this->db->select('invoices.*, companies.short_name');
		$this->db->from('invoices');
        $this->db->join('companies', 'companies.rfc = invoices.sender_rfc');
		$this->db->where('sender_rfc', $emisor);
        $query = $this->db->get();
        return $query->result();
    }

    public function post_my_invoice($xml) {
        $this->db->insert('invoices', $xml);
        return $this->db->insert_id();
    }

    public function uuid_exists($xml) {
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('uuid', $xml);
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

    public function update_status_invoice($id, $status) {
        $factura = array(
			"status" => $status,
            "updated_at" => date("Y-m-d")
		);

        $this->db->where('id', $id);
		$this->db->update('invoices', $factura);

        return;
    }

    public function company($rfc) {

        $this->db->select('*');
        $this->db->from('companies');
        $this->db->where('rfc', $rfc);
        $query = $this->db->get();
        return $query->result();

    }
}
?>