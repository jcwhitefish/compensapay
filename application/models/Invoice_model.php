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

    public function get_provider_invoices($user, $rfc_emi) {
        $this->db->select('c.short_name AS name_provee, c2.short_name AS name_client, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c', 'c.id = u.id_company');
        $this->db->join('invoices AS i', 'i.sender_rfc = c.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.receiver_rfc');
		$this->db->where('c.id', $user);
		$this->db->where('i.sender_rfc', $rfc_emi);
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

    public function get_invoices_client($user) {
        $this->db->select('c1.short_name AS name_client, c2.short_name AS name_provee, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c1', 'c1.id = u.id_company');
        $this->db->join('invoices AS i', 'i.sender_rfc = c1.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.receiver_rfc', 'LEFT');
		$this->db->where('c1.id', $user);
		//$this->db->where('i.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_inv_prov_send_by_rfc($rfc) {
        $this->db->select('c2.short_name AS name_client, c1.short_name AS name_provee, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c1', 'c1.id = u.id_company');
        $this->db->join('invoices AS i', 'i.sender_rfc = c1.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.receiver_rfc');
		$this->db->where('c1.rfc', $rfc);
		$this->db->where('i.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_provider_invoices_tabla($user) {
        $this->db->select('c.short_name AS name_provee, c2.short_name AS name_client, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c', 'c.id = u.id_company');
        $this->db->join('invoices AS i', 'i.sender_rfc = c.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.receiver_rfc');
		$this->db->where('c.id', $user);
		//$this->db->where('i.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_client_invoices($user) {
        $this->db->select('c.short_name AS name_client, c2.short_name AS name_provee, i.*');
		$this->db->from('users as u');
        $this->db->join('companies AS c', 'c.id = u.id_company');
        $this->db->join('invoices AS i', 'i.sender_rfc = c.rfc');
        $this->db->join('companies AS c2', 'c2.rfc = i.receiver_rfc');
		$this->db->where('c.id', $user);
		$this->db->where('i.status1', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_movements($user) {
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
		$url= base_url('assets/factura/factura.php?idfactura=');
		$url2 = base_url('boveda/CEP/');
		$query = "SELECT * FROM ( SELECT balance.*, CONCAT('$', FORMAT(balance.amount, 2)) as ammountf, invoices.uuid, 
                       t3.bnk_alias as 'bank_source', t4.bnk_alias as 'bank_receiver', 
(IF((balance.receiver_clabe = t2.account_clabe OR balance.receiver_clabe = t5.arteria_clabe), t2.legal_name, t1.legal_name)) as 'client', 
(IF((balance.source_clabe = t5.arteria_clabe OR balance.source_clabe = t2.account_clabe), t2.legal_name, t1.legal_name)) as 'provider', 
(IF((balance.receiver_clabe = t2.account_clabe OR balance.receiver_clabe = t5.arteria_clabe), t2.id, t1.id)) as 'clientId', 
(IF((balance.source_clabe = t5.arteria_clabe OR balance.source_clabe = t2.account_clabe), t2.id, t1.id)) as 'providerId', 
                    FROM_UNIXTIME(balance.created_at, '%d/%m/%Y') AS 'created_atb',
                    FROM_UNIXTIME(balance.transaction_date, '%d/%m/%Y') AS 'transaction_dateb',
                    CONCAT('$url',invoices.id) AS 'idurl', 
                    CONCAT('$url2',balance.url_cep) AS 'cepUrl'
                FROM balance as balance 
                    LEFT JOIN operations ON balance.operationNumber = operations.operation_number 
                    LEFT JOIN invoices ON invoices.id = operations.id_invoice 
                    LEFT JOIN companies t1 ON t1.id = operations.id_client 
                    LEFT JOIN companies t2 ON t2.id = operations.id_provider 
                    LEFT JOIN cat_bancos t3 ON t3.bnk_code = balance.source_bank 
                    LEFT JOIN cat_bancos t4 ON t4.bnk_code = balance.receiver_bank 
                    LEFT JOIN fintech t5 ON t5.companie_id = operations.id_provider) b 
         WHERE  clientId = '$company' OR providerId = '$company' 
         ORDER BY balance.created_at DESC";
//        $this->db->select('balance.*, CONCAT("$", FORMAT(balance.amount, 2)) as ammountf, invoices.uuid, t3.bnk_alias as "bank_source", t4.bnk_alias as "bank_receiver",
//(CASE WHEN (balance.receiver_clabe = t2.account_clabe OR balance.receiver_clabe = t5.arteria_clabe) THEN t2.legal_name ELSE t1.legal_name END) as "client",
//(CASE WHEN (balance.source_clabe = t5.arteria_clabe OR balance.source_clabe = t2.account_clabe)  THEN t2.legal_name ELSE t1.legal_name END) as "provider",
//        FROM_UNIXTIME(balance.created_at, "%m/%d/%Y") AS "created_at",
//        FROM_UNIXTIME(balance.transaction_date, "%m/%d/%Y") AS "transaction_date",
//        CONCAT("'.base_url('assets/factura/factura.php?idfactura=').'",invoices.id) AS "idurl",
//        CONCAT("'.base_url('boveda/CEP/').'",balance.url_cep) AS "cepUrl"');
//        $this->db->from('balance as balance');
//        $this->db->join('operations', 'balance.operationNumber = operations.operation_number', 'LEFT');
//        $this->db->join('invoices', 'invoices.id = operations.id_invoice', 'LEFT');
//        $this->db->join('companies t1', 't1.id = operations.id_client ', 'LEFT');
//        $this->db->join('companies t2', 't2.id = operations.id_provider', 'LEFT');
//        $this->db->join('cat_bancos t3', 't3.bnk_code = balance.source_bank ', 'LEFT');
//        $this->db->join('cat_bancos t4', 't4.bnk_code = balance.receiver_bank ', 'LEFT');
//		$this->db->join('fintech t5', 't5.companie_id = operations.id_provider ', 'LEFT');
//        $this->db->where('operations.id_provider', $company);
//        $this->db->or_where('operations.id_client', $company);
//		$this->db->order_by('balance.created_at', 'DESC');
//        $query = $this->db->get();
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0)
				return $result->result_array();
		}
        return false;
    }

    public function crearExcel($args, $menu) {
        $letter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $spread = new Spreadsheet();
        $sheet = $spread->getActiveSheet();
        $sheet->setTitle("Hoja 1");
        $i = 1;
        $j = 0;
        switch($menu){
            case 'Facturas':
				$sheet->setCellValue('A1', 'Proveedor');
				$sheet->setCellValue('B1', 'Factura');
				$sheet->setCellValue('C1', 'Fecha Factura');
				$sheet->setCellValue('D1', 'Fecha Alta');
				$sheet->setCellValue('E1', 'Fecha Transacción');
				$sheet->setCellValue('F1', 'Estatus');
				$sheet->setCellValue('G1', 'Subtotal');
				$sheet->setCellValue('H1', 'IVA');
				$sheet->setCellValue('I1', 'Total');
				$sheet->getStyle('A1:I1')->applyFromArray(
					array(
						'font'  => array(
							'bold'  => true,
							'color' => array('rgb' => 'FFFFFF'),
							'size'  => 12,
						),
						'fill' => array(
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
							'color' => array('rgb' => '128293')
						),
					)
				);
				foreach($args as $value){
					$i++;
					$arr = explode(',', $value);
					foreach($arr as $key){
						$sheet->setCellValue( $letter[$j].$i, $key);
						$sheet->getColumnDimension($letter[$j])->setAutoSize(true);
						$j++;
					}
					$j = 0;
				}
                break;
            case 'Movimientos':
				$sheet->setCellValue('A1', 'Monto');
				$sheet->setCellValue('B1', 'Clave de rastreo');
				$sheet->setCellValue('C1', 'Comprobante electrónico (CEP)');
				$sheet->setCellValue('D1', 'Descripción');
				$sheet->setCellValue('E1', 'Banco origen');
				$sheet->setCellValue('F1', 'Banco destino');
				$sheet->setCellValue('G1', 'Razón social origen');
				$sheet->setCellValue('H1', 'RFC origen');
				$sheet->setCellValue('I1', 'Razón social destino');
				$sheet->setCellValue('J1', 'RFC destino');
				$sheet->setCellValue('K1', 'CLABE origen');
				$sheet->setCellValue('L1', 'CLABE destino');
				$sheet->setCellValue('M1', 'Fecha de transacción');
				$sheet->setCellValue('N1', 'CFDI correspondiente');
				$sheet->setCellValue('O1', 'Fecha de Transacción');
				$sheet->getStyle('A1:O1')->applyFromArray(
					array(
						'font'  => array(
							'bold'  => true,
							'color' => array('rgb' => 'FFFFFF'),
							'size'  => 12,
						),
						'fill' => array(
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
							'color' => array('rgb' => '128293')
						),
					)
				);
				foreach($args as $value){
					$i++;
					$arr = explode(',', $value);
					foreach($arr as $key){
						if ($j == 10 || $j == 11){
							$sheet->getStyle($letter[$j].$i)->getNumberFormat()->setFormatCode('####');
							$sheet->getStyle($letter[$j].$i)->getNumberFormat()->setFormatCode('####');
						}
						if ($j == 12 || $j == 14){
							$sheet->setCellValue( $letter[$j].$i, date('Y-m-d', strtotime($key)) );
						}else{
							$sheet->setCellValue( $letter[$j].$i, $key);
						}
						$sheet->getColumnDimension($letter[$j])->setAutoSize(true);
						$j++;
					}
					$j = 0;
				}
				$sheet->removeColumn('C', $i);
                break;
			case 'Estados':
			case 'Comprobantes':
                $sheet->setCellValue('A1', $key);
                break;
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
        $this->db->select('i.*');
		$this->db->from('invoices as i');
		$this->db->where('i.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_invoices_by_client($user) {
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
        $this->db->select('invoices.*, companies.short_name, CONCAT("'.base_url('assets/factura/factura.php?idfactura=').'",invoices.id) AS "idurl"');
		$this->db->from('invoices');
        $this->db->join('companies', 'companies.rfc = invoices.receiver_rfc');
		$this->db->where('sender_rfc', $rfc);
        $this->db->where_in('invoices.status', [1,2]);
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
            "updated_at" => date("Y-m-d")
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
