<?php

defined('BASEPATH') or exit('No direct script access allowed');


//later erase this mothers
require_once APPPATH . 'models/enties/Invoice.php';

class InvoiceModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_invoices() {
        $query = $this->db->get('invoices');
        $result = $query->result();
        
        $invoices = array();
        foreach ($result as $row) {
            $invoice = new Invoice(
                $row->id,
                $row->id_company,
                $row->sender_rfc,
                $row->receiver_rfc,
                $row->invoice_number,
                $row->uuid,
                $row->invoice_date,
                $row->created_date,
                $row->transaction_date,
                $row->status,
                $row->subtotal,
                $row->iva,
                $row->total,
                $row->xml_document
            );
            $invoices[] = $invoice;
        }
    
        return $invoices;
    }
    
    
    
}
?>