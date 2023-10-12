<?php
class Invoice {
    public $id;
    public $id_company;
    public $sender_rfc;
    public $receiver_rfc;
    public $invoice_number;
    public $uuid;
    public $invoice_date;
    public $created_date;
    public $transaction_date;
    public $status;
    public $subtotal;
    public $iva;
    public $total;
    public $xml_document;

    public function __construct(
        $id, $id_company, $sender_rfc, $receiver_rfc, $invoice_number, $uuid,
        $invoice_date, $created_date, $transaction_date, $status,
        $subtotal, $iva, $total, $xml_document
    ) {
        $this->id = $id;
        $this->id_company = $id_company;
        $this->sender_rfc = $sender_rfc;
        $this->receiver_rfc = $receiver_rfc;
        $this->invoice_number = $invoice_number;
        $this->uuid = $uuid;
        $this->invoice_date = $invoice_date;
        $this->created_date = $created_date;
        $this->transaction_date = $transaction_date;
        $this->status = $status;
        $this->subtotal = $subtotal;
        $this->iva = $iva;
        $this->total = $total;
        $this->xml_document = $xml_document;
    }
}
