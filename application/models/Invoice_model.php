<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $this->db->select('balance.*, invoices.uuid, t1.legal_name as "client", t2.legal_name as "provider", t3.bnk_nombre as "bank_source", t4.bnk_nombre as "bank_receiver"');
        $this->db->from('balance as balance');
        $this->db->join('operations', 'balance.traking_key_received = operations.operation_number', 'inner');
        $this->db->join('invoices', 'invoices.id = operations.id_invoice', 'inner');
        $this->db->join('companies t1', 't1.id = operations.id_client ', 'inner');
        $this->db->join('companies t2', 't2.id = operations.id_provider', 'inner');
        $this->db->join('cat_bancos t3', 't3.bnk_clave = balance.source_bank ', 'inner');
        $this->db->join('cat_bancos t4', 't4.bnk_clave = balance.receiver_bank ', 'inner');

        $this->db->where('balance.source_rfc', $rfc);
        $this->db->or_where('balance.receiver_rfc', $rfc);
        $query = $this->db->get();
       return $query->result();
    }

    public function crearExcel($args, $menu) {
        //var_dump($args);
        $spread = new Spreadsheet();

        $sheet = $spread->getActiveSheet();
        $sheet->setTitle("Hoja 1");
        $i = 1;
        $j = 0;
        switch($menu){
            case 'Facturas':
                $sheet->setCellValueByColumnAndRow(1, 1, 'Proveedor');
                $sheet->setCellValueByColumnAndRow(2, 1, 'Factura');
                $sheet->setCellValueByColumnAndRow(3, 1, 'Fecha Factura');
                $sheet->setCellValueByColumnAndRow(4, 1, 'Fecha Alta');
                $sheet->setCellValueByColumnAndRow(5, 1, 'Fecha Transacción');
                $sheet->setCellValueByColumnAndRow(6, 1, 'Estatus');
                $sheet->setCellValueByColumnAndRow(7, 1, 'Subtotal');
                $sheet->setCellValueByColumnAndRow(8, 1, 'IVA');
                $sheet->setCellValueByColumnAndRow(9, 1, 'Total');
                break;
            case 'Movimientos':
                $sheet->setCellValueByColumnAndRow(1, 1, 'Monto');
                $sheet->setCellValueByColumnAndRow(2, 1, 'Clave de rastreo');
                $sheet->setCellValueByColumnAndRow(3, 1, 'Descripción');
                $sheet->setCellValueByColumnAndRow(4, 1, 'Banco origen');
                $sheet->setCellValueByColumnAndRow(5, 1, 'Banco destino');
                $sheet->setCellValueByColumnAndRow(6, 1, 'Razón social origen');
                $sheet->setCellValueByColumnAndRow(7, 1, 'RFC Origen');
                $sheet->setCellValueByColumnAndRow(8, 1, 'Razón social destino');
                $sheet->setCellValueByColumnAndRow(9, 1, 'CLABE origen');
                $sheet->setCellValueByColumnAndRow(10, 1, 'CLABE destino');
                $sheet->setCellValueByColumnAndRow(11, 1, 'Fecha de transacción');
                $sheet->setCellValueByColumnAndRow(12, 1, 'CFDI correspondiente');
                $sheet->setCellValueByColumnAndRow(13, 1, 'Fecha de Transacción');
                break;
            case 'Comprobantes':
                $sheet->setCellValueByColumnAndRow(1, 1, $key);
                break;
            case 'Estados':
                $sheet->setCellValueByColumnAndRow(1, 1, $key);
                break;
        }
        
        foreach($args as $value){
            $i++;
            
            $arr = explode('|', $value);
            foreach($arr as $key){
                $j++;
                $sheet->setCellValueByColumnAndRow($j, $i, $key);
            }
            $j = 0;

        }
        $writer = new Xlsx($spread);
        ob_start();
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();
         
        $opResult = array(
            'status' => 1,
            'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
         );
        return $opResult;

        //$writer->save('./doc_exportados/reporte_de_excel.xlsx');
    }

    public function get_invoices_by_id($id) {
        $this->db->select('*');
		$this->db->from('invoices');
		$this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_invoices_by_client($emisor) {
        $this->db->select('invoices.*, companies.short_name');
		$this->db->from('invoices');
        $this->db->join('companies', 'companies.rfc = invoices.receiver_rfc');
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