<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
/**
 * Class Invoice_model model
 * @property Invoice_model $invData invoice processing model
 */
class Invoice_model extends CI_Model {
	private string $enviroment = 'SANDBOX';
	private string $dbsandbox = 'compensatest_base';
//	private string $dbprod = 'compensapay';
	private string $dbprod = 'compensatest_base';
	public string $base = '';
    public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->base = $this->enviroment === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
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
        $this->db->select('balance.*, CONCAT("$", FORMAT(balance.amount, 2)) as ammountf, invoices.uuid, t1.legal_name as "client", 
        t2.legal_name as "provider", t3.bnk_alias as "bank_source", t4.bnk_alias as "bank_receiver", 
        CONCAT("'.base_url('assets/factura/factura.php?idfactura=').'",invoices.id) AS "idurl", 
        CONCAT("'.base_url('boveda/CEP/').'",balance.url_cep) AS "cepUrl"');
        $this->db->from('balance as balance');
        $this->db->join('operations', 'balance.operationNumber = operations.operation_number', 'LEFT');
        $this->db->join('invoices', 'invoices.id = operations.id_invoice', 'LEFT');
        $this->db->join('companies t1', 't1.id = operations.id_client ', 'LEFT');
        $this->db->join('companies t2', 't2.id = operations.id_provider', 'LEFT');
        $this->db->join('cat_bancos t3', 't3.bnk_code = balance.source_bank ', 'LEFT');
        $this->db->join('cat_bancos t4', 't4.bnk_code = balance.receiver_bank ', 'LEFT');
        $this->db->where('operations.id_provider', $company);
        $this->db->or_where('operations.id_client', $company);
		$this->db->order_by('balance.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
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
							$sheet->setCellValue( $letter[$j].$i, date('Y-m-d', $key) );
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
	/**
	 * Función para obtener todas las facturas y notas de debito que tienen una operación ligada para mostrar en la
	 * tabla de documentos
	 * @param string      $id
	 * @param int         $from
	 * @param int         $to
	 * @param string|null $env
	 * @return array
	 */
	public function getDocsCFDI(string $id, int $from, int $to, string $env = null): array	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//se crea la variable url de las facturas para concatenarlo
		$url = base_url('assets/factura/factura.php?idfactura=');
		//Se crea el query para obtener las facturas
		$query = "SELECT t2.id, t3.short_name AS 'emisor', t4.short_name AS 'receptor', t2.uuid, 
       CONCAT('$url', t2.id) AS 'idurl', 
DATE_FORMAT(FROM_UNIXTIME(t2.invoice_date), '%d-%m-%Y') AS 'dateCFDI',  
DATE_FORMAT(FROM_UNIXTIME(t2.created_at), '%d-%m-%Y') AS 'dateCreate',  
DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'dateToPay', 
t2.subtotal, t2.iva, t2.total, 'factura' AS tipo
FROM $this->base.operations t1 
INNER JOIN $this->base.invoices t2 ON t1.id_invoice = t2.id OR t1.id_invoice_relational = t2.id
LEFT JOIN $this->base.companies t3 ON t2.sender_rfc = t3.rfc
LEFT JOIN $this->base.companies t4 ON t2.receiver_rfc = t4.rfc
WHERE (t1.id_client = $id OR t1.id_provider = $id) AND t2.invoice_date >= '$from' AND t2.invoice_date <= '$to'
ORDER BY t2.invoice_date DESC";
		//se verifica que la consulta se ejecute bien
		if($invoices = $this->db->query($query)){
			//se verifica que haya informacion
			if ($invoices->num_rows() > 0){
				//Se crea query para obtener notas de debito
				$query = "SELECT t2.id, t3.short_name AS 'emisor', t4.short_name AS 'receptor', t2.uuid, 
CONCAT('$url', t2.id) AS 'idurl',
DATE_FORMAT(FROM_UNIXTIME(t2.created_at), '%d-%m-%Y') AS 'dateCFDI',  
DATE_FORMAT(FROM_UNIXTIME(t2.created_at), '%d-%m-%Y') AS 'dateCreate',  
DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'dateToPay', 
t2.total, 'Nota de debito' AS tipo
FROM $this->base.operations t1 
INNER JOIN $this->base.debit_notes t2 ON t1.id_debit_note = t2.id
LEFT JOIN $this->base.companies t3 ON t1.id_client = t3.id
LEFT JOIN $this->base.companies t4 ON t1.id_provider = t4.id
WHERE (t1.id_client = $id OR t1.id_provider = $id) AND t2.created_at >= '$from' AND t2.created_at <= '$to'
ORDER BY t2.created_at DESC";
				//Se verifica que se ejecute bien el segundo query
				if($debit_notes = $this->db->query($query)) {
					//se crea un unico arreglo con la informacion de las facturas y notas de debito y se envia
					$CFDI = $invoices->result_array();
					$CFDI = array_merge($CFDI, $debit_notes->result_array());
					return ["code" => 200,"result" => $CFDI];
				}else{
					//si no hay datos de notas de debito solo se envian las facturas
					return ["code" => 200,"result" => $invoices->result_array()];
				}
			}else{
				//En caso de que no hay informacion lo notifica para que se ingrese otro valor de busqueda
				return ["code" => 404,"message" => "No se encontraron registros",
					"reason" => "No hay resultados con los criterios de busqueda utilizados"];
			}
		}
		//En caso de error igual notifica
		return ["code" => 500, "message" => "Error al extraer la información", "reason" => "Error con la fuente de información"];
	}

	/**
	 * Funcion para obtener todos los movimientos que tiene una cuenta.
	 * @param string      $id Id de la coompañia
	 * @param int         $from fecha de inicio de busqueda
	 * @param int         $to fecha de termino de busqueda
	 * @param string|null $env ambiente en el que se trabajara
	 * @return array
	 */
	public function getDocsMovements(string $id, int $from, int $to, string $env = null): array	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//se crea la variable url de las facturas para concatenarlo
		$factura = base_url('assets/factura/factura.php?idfactura=');
		$cep = base_url('boveda/CEP/');
		//Se crea el query para obtener las facturas
		$query = "SELECT  t1.id, tf1.id, t1.amount, t1.traking_key, t1.descriptor, 
t8.bnk_alias AS 'source_bank', t6.short_name AS 'source_name', t6.rfc AS 'source_rfc', t1.source_clabe, 
t9.bnk_alias AS 'destination_bank', t7.short_name AS 'destiantion_name', t7.rfc AS 'destination_rfc', t1.receiver_clabe, 
DATE_FORMAT(FROM_UNIXTIME(t1.transaction_date), '%d-%m-%Y') AS 'transaction_date',
(CASE WHEN t1.amount = t3.total THEN t3.uuid
WHEN t5.uuid IS NOT NULL THEN t5.uuid
ELSE t4.uuid END) AS 'uuid',
(CASE WHEN t1.amount = t3.total THEN CONCAT('$factura',t3.id) 
WHEN t5.uuid IS NOT NULL THEN CONCAT('$factura',t5.id)
ELSE CONCAT('$factura',t4.id) END) AS 'idurl',
CONCAT('$cep',t1.url_cep) AS 'cepUrl'
FROM $this->base.balance t1
LEFT JOIN $this->base.operations t2 ON t1.operationNumber = t2.operation_number
LEFT JOIN $this->base.invoices t3 ON t2.id_invoice = t3.id 
LEFT JOIN $this->base.invoices t4 ON t2.id_invoice_relational = t4.id
LEFT JOIN $this->base.debit_notes t5 ON t2.id_debit_note = t5.id
LEFT JOIN $this->base.fintech tf1 ON tf1.arteria_clabe = t1.source_clabe
LEFT JOIN $this->base.fintech tf2 ON tf2.arteria_clabe = t1.receiver_clabe
LEFT JOIN $this->base.companies t6 
ON (t1.source_rfc = t6.rfc) OR (t1.source_clabe = t6.account_clabe) OR (t6.id = tf1.companie_id)
LEFT JOIN $this->base.companies t7 
ON (t1.receiver_rfc = t7.rfc) OR (t1.receiver_clabe = t7.account_clabe) OR (t7.id = tf2.companie_id)
INNER JOIN $this->base.cat_bancos t8 ON t1.source_bank = t8.bnk_code
INNER JOIN $this->base.cat_bancos t9 ON t1.receiver_bank = t9.bnk_code
WHERE (t2.id_provider = '$id' OR t2.id_client = '$id') AND t1.transaction_date >= '$from' AND t1.transaction_date <= '$to'
ORDER BY t1.created_at DESC";
		//Verífica que se ejecute bien el query
		if($res = $this->db->query($query)){
			//Verífica que haya resultados
			if ($res->num_rows() > 0) {
				//se crea un único arreglo con la información de los movimientos y se envía
				return ["code" => 200,"result" => $res->result_array()];
			}
			//En caso de que no hay información lo notifica para que se ingrese otro valor de búsqueda
			return ["code" => 404,"message" => "No se encontraron registros",
				"reason" => "No hay resultados con los criterios de busqueda utilizados"];
		}
		return ["code" => 500, "message" => "Error al extraer la información", "reason" => "Error con la fuente de información"];
	}
}
