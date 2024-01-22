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
	private string $enviroment = '';
	private string $dbsandbox = '';
//	private string $dbprod = 'compensapay';
	private string $dbprod = '';
	public string $base = '';
    public function __construct() {
        parent::__construct();
        $this->load->database();
		require 'conf.php';
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
            case 'cfdi':
				$sheet->setCellValue('A1', 'Emisor');
				$sheet->setCellValue('B1', 'Receptor');
				$sheet->setCellValue('C1', 'CFDI');
				$sheet->setCellValue('D1', 'Fecha CFDI');
				$sheet->setCellValue('E1', 'Fecha Alta');
				$sheet->setCellValue('F1', 'Fecha limite de pago');
				$sheet->setCellValue('G1', 'Total');
				$sheet->setCellValue('H1', 'tipo');
				$sheet->getStyle('A1:H1')->applyFromArray(
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
					$arr = explode('|', $value);
					foreach($arr as $key){
						$sheet->setCellValue( $letter[$j].$i, $key);
						$sheet->getColumnDimension($letter[$j])->setAutoSize(true);
						$j++;
					}
					$j = 0;
				}
                break;
            case 'movimientos':
				$sheet->setCellValue('A1', 'Monto');
				$sheet->setCellValue('B1', 'Número de referencia');
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
				$sheet->setCellValue('M1', 'CFDI correspondiente');
				$sheet->setCellValue('N1', 'Fecha de Transacción');
				$sheet->getStyle('A1:N1')->applyFromArray(
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
					$arr = explode('|', $value);
					foreach($arr as $key){
						if ($j == 10 || $j == 11 || $j == 12){
							$sheet->getStyle($letter[$j].$i)->getNumberFormat()->setFormatCode('####');
							$sheet->getStyle($letter[$j].$i)->getNumberFormat()->setFormatCode('####');
						}
						if ($j == 13){
							$sheet->setCellValue( $letter[$j].$i, date('d-m-Y', strtotime($key)) );
						}else{
							$sheet->setCellValue( $letter[$j].$i, $key);
						}
						$sheet->getColumnDimension($letter[$j])->setAutoSize(true);
						$j++;
					}
					$j = 0;
				}
				$sheet->removeColumn('C', 1);
                break;
			case 'Estados':
			case 'comprobantes':
				$sheet->setCellValue('A1', 'Descargar CEP');
				$sheet->setCellValue('B1', 'Institución emisora');
				$sheet->setCellValue('C1', 'Institución receptora');
				$sheet->setCellValue('D1', 'Cuenta beneficiaria');
				$sheet->setCellValue('E1', 'Clave de rastreo');
				$sheet->setCellValue('F1', 'Numero de referencia');
				$sheet->setCellValue('G1', 'Fecha de pago');
				$sheet->setCellValue('H1', 'Monto del pago');
				$sheet->getStyle('A1:H1')->applyFromArray(
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
					$arr = explode('|', $value);
					foreach($arr as $key){
						if ($j ==3){
							$sheet->getStyle($letter[$j].$i)->getNumberFormat()->setFormatCode('####');
							$sheet->getStyle($letter[$j].$i)->getNumberFormat()->setFormatCode('####');
						}
						if ($j == 6){
							$sheet->setCellValue( $letter[$j].$i, date('d-m-Y', strtotime($key)) );
						}else{
							$sheet->setCellValue( $letter[$j].$i, $key);
						}
						$sheet->getColumnDimension($letter[$j])->setAutoSize(true);
						$j++;
					}
					$j = 0;
				}
				$sheet->removeColumn('A',1);
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
	 * Función para obtener todas las facturas y notas de débito que tienen una operación ligada para mostrar en la
	 * tabla de documentos
	 * @param string      $id id de la compañía de la que se quieren obtener datos
	 * @param int         $from fecha de inicio de búsqueda
	 * @param int         $to fecha de termino de búsqueda
	 * @param string|null $env ambiente en el que se trabajara
	 * @return array
	 */
	public function getDocsCFDI(string $id, int $from, int $to, string $env = null): array	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//se crea la variable url de las facturas para concatenarlo
		$url = base_url('assets/factura/factura.php?idfactura=');
		$url2 = base_url('assets/factura/nota.php?idnota=');
		//Se crea el query para obtener las facturas
		$query = "SELECT * FROM (
(SELECT CONCAT(t1.id,'f') AS id2, t2.id, t3.short_name AS 'emisor', t4.short_name AS 'receptor', t2.uuid,
       CONCAT('$url', t2.id) AS 'idurl',
DATE_FORMAT(FROM_UNIXTIME(t2.invoice_date), '%d-%m-%Y') AS 'dateCFDI',
DATE_FORMAT(FROM_UNIXTIME(t2.created_at), '%d-%m-%Y') AS 'dateCreate',
DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'dateToPay',
t2.total, 'Factura' AS tipo, t1.created_at
FROM $this->base.operations t1
INNER JOIN $this->base.invoices t2 ON t1.id_invoice = t2.id OR t1.id_invoice_relational = t2.id
LEFT JOIN $this->base.companies t3 ON t2.sender_rfc = t3.rfc
LEFT JOIN $this->base.companies t4 ON t2.receiver_rfc = t4.rfc
WHERE (t1.id_client = $id OR t1.id_provider = $id) AND t2.status = 3 AND t2.created_at >= '$from' AND t2.created_at <= '$to')
UNION
(SELECT CONCAT(t1.id,'n') AS id2, t2.id, t3.short_name AS 'emisor', t4.short_name AS 'receptor', t2.uuid,
       CONCAT('$url2', t2.id) AS 'idurl',
DATE_FORMAT(FROM_UNIXTIME(t2.debitNote_date), '%d-%m-%Y') AS 'dateCFDI',
DATE_FORMAT(FROM_UNIXTIME(t2.created_at), '%d-%m-%Y') AS 'dateCreate',
DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'dateToPay',
t2.total, 'Nota de crédito' AS tipo, t1.created_at
FROM $this->base.operations t1
INNER JOIN $this->base.debit_notes t2 ON t1.id_debit_note = t2.id
LEFT JOIN $this->base.companies t3 ON t2.sender_rfc = t3.rfc
LEFT JOIN $this->base.companies t4 ON t2.receiver_rfc = t4.rfc
WHERE (t3.id = $id OR t4.id = $id) AND t2.status = 3 AND t2.created_at >= '$from' AND t2.created_at <= '$to')
) AS T ORDER BY T.created_at";

		//se verifica que la consulta se ejecute bien
		if($invoices = $this->db->query($query)){
			//se verifica que haya informacion
			if ($invoices->num_rows() > 0){
				//Se crea query para obtener notas de debito
//				$query = "SELECT t2.id, t3.short_name AS 'emisor', t4.short_name AS 'receptor', t2.uuid,
//CONCAT('$url', t2.id) AS 'idurl',
//DATE_FORMAT(FROM_UNIXTIME(t2.created_at), '%d-%m-%Y') AS 'dateCFDI',
//DATE_FORMAT(FROM_UNIXTIME(t2.created_at), '%d-%m-%Y') AS 'dateCreate',
//DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'dateToPay',
//t2.total, 'Nota de Crédito ' AS tipo
//FROM $this->base.operations t1
//INNER JOIN $this->base.debit_notes t2 ON t1.id_debit_note = t2.id
//LEFT JOIN $this->base.companies t3 ON t1.id_client = t3.id
//LEFT JOIN $this->base.companies t4 ON t1.id_provider = t4.id
//WHERE (t1.id_client = $id OR t1.id_provider = $id) AND t2.created_at >= '$from' AND t2.created_at <= '$to'
//ORDER BY t2.created_at DESC";
				return ["code" => 200,"result" => $invoices->result_array()];
				//Se verifica que se ejecute bien el segundo query
//				if($debit_notes = $this->db->query($query)) {
//					//se crea un unico arreglo con la informacion de las facturas y notas de debito y se envia
//					$CFDI = $invoices->result_array();
//					$CFDI = array_merge($CFDI, $debit_notes->result_array());
//					return ["code" => 200,"result" => $CFDI];
//				}else{
//					//si no hay datos de notas de debito solo se envian las facturas
//
//				}
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
	 * Función para obtener todos los movimientos que tiene una cuenta.
	 * @param string      $id id de la compañía de la que se quieren obtener datos
	 * @param int         $from fecha de inicio de búsqueda
	 * @param int         $to fecha de termino de búsqueda
	 * @param string|null $env ambiente en el que se trabajara
	 * @return array
	 */
	public function getDocsMovements(string $id, int $from, int $to, string $env = null): array	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//se crea la variable url de las facturas para concatenarlo
		$urlF = base_url('assets/factura/factura.php?idfactura=');
		$urlN = base_url('assets/factura/nota.php?idnota=');
		$cep = base_url('boveda/CEP/');
		//Se crea el query para obtener las facturas
		$query = "SELECT t0.amount, t0.traking_key, t0.descriptor,
       DATE_FORMAT(FROM_UNIXTIME(t0.created_at), '%d-%m-%Y') AS 'created_at',
       CONCAT('$cep',t0.url_cep) AS 'cepUrl',
       t3.legal_name AS 'provider', t3.rfc AS 'providerRFC', b1.bnk_alias as 'bank_source', t0.source_clabe,
       t4.legal_name AS 'client', t4.rfc AS	 'clientRFC',  b2.bnk_alias as 'bank_receiver', t0.receiver_clabe,
       (CASE
           WHEN t0.amount = t2.total THEN t2.uuid
           WHEN t0.amount = c1.total THEN c1.uuid
           WHEN t0.amount = c2.total THEN c2.uuid
           ELSE 'No Aplica' END) AS 'uuid',
       (CASE
           WHEN t0.amount = t2.total THEN CONCAT('$urlF',t2.id)
           WHEN t0.amount = c1.total THEN CONCAT('$urlF',c1.id)
           WHEN t0.amount = c2.total THEN CONCAT('$urlN',c2.id)
           ELSE 'No Aplica' END) AS 'idurl'
FROM $this->base.balance t0
	LEFT JOIN $this->base.operations t1 ON t0.operationNumber = t1.operation_number
	LEFT JOIN $this->base.invoices t2 ON t1.id_invoice = t2.id
	LEFT JOIN $this->base.invoices c1 ON t1.id_invoice_relational = c1.id
	LEFT JOIN $this->base.debit_notes c2 ON t1.id_debit_note = c2.id
	LEFT JOIN $this->base.fintech f1 ON f1.arteria_clabe = t0.source_clabe
	LEFT JOIN $this->base.fintech f2 ON f2.arteria_clabe = t0.receiver_clabe
	LEFT JOIN $this->base.companies t3 ON t3.rfc = t0.source_rfc OR t3.id = f1.companie_id OR t3.account_clabe = t0.source_clabe
	LEFT JOIN $this->base.companies t4 ON t4.rfc = t0.receiver_rfc OR t4.id = f2.companie_id OR t4.account_clabe = t0.receiver_clabe
	INNER JOIN $this->base.cat_bancos b1 ON t0.source_bank = b1.bnk_code
	INNER JOIN $this->base.cat_bancos b2 ON t0.receiver_bank = b2.bnk_code
	WHERE (t3.id = $id OR t4.id = $id) AND t0.created_at >= '$from' AND t0.created_at <= '$to'";
		var_dump ($query);
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
		//en caso de que no se logre ejecutar el
		return ["code" => 500, "message" => "Error al extraer la información", "reason" => "Error con la fuente de información"];
	}
	/**
	 * Función para obtener todas las facturas y notas de débito que ha emitido una empresa.
	 * @param string      $id   ID de compañía
	 * @param int         $from fecha de inicio de búsqueda
	 * @param int         $to   fecha de termino de búsqueda
	 * @param string|null $env  ambiente en el que se trabajara
	 * @return array
	 */
	public function getCFDIByCompany(string $id, int $from, int $to, string $env = null): array	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//se crea la variable url de las facturas para concatenarlo
		$urlF = base_url('assets/factura/factura.php?idfactura=');
		$urlN = base_url('assets/factura/nota.php?idnota=');
		//Se crea el query para obtener las facturas
		$query = "SELECT * FROM (
(SELECT CONCAT(t1.id,'f') AS id2, t1.id, t2.short_name AS 'emisor', t3.short_name AS 'receptor', t1.uuid,
CONCAT('$urlF', t1.id) AS 'idurl',
DATE_FORMAT(FROM_UNIXTIME(t1.invoice_date), '%d-%m-%Y') AS 'dateCFDI',
DATE_FORMAT(FROM_UNIXTIME(t1.created_at), '%d-%m-%Y') AS 'dateCreate',
DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'dateToPay', t1.total, 'Factura' AS tipo,
t1.status, t2.id AS 'senderId', t3.id AS 'receptorId', t1.created_at
FROM $this->base.invoices t1
LEFT JOIN $this->base.companies t2 ON t1.sender_rfc = t2.rfc
LEFT JOIN $this->base.companies t3 ON t1.receiver_rfc = t3.rfc
WHERE (t1.id_company = $id) AND t1.created_at >= '$from' AND t1.created_at <= '$to')
UNION
(SELECT CONCAT(t1.id,'n') AS id2, t1.id, t2.short_name AS 'emisor', t3.short_name AS 'receptor', t1.uuid,
CONCAT('$urlN', t1.id) AS 'idurl',
DATE_FORMAT(FROM_UNIXTIME(t1.debitNote_date), '%d-%m-%Y') AS 'dateCFDI',
DATE_FORMAT(FROM_UNIXTIME(t1.created_at), '%d-%m-%Y') AS 'dateCreate',
DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'dateToPay', t1.total, 'Nota de crédito' AS tipo,
t1.status, t2.id AS 'senderId', t3.id AS 'receptorId', t1.created_at
FROM $this->base.debit_notes t1
LEFT JOIN $this->base.companies t2 ON t1.sender_rfc = t2.rfc
LEFT JOIN $this->base.companies t3 ON t1.receiver_rfc = t3.rfc
WHERE (t1.id_company = $id) AND t1.created_at >= '$from' AND t1.created_at <= '$to')) AS T
ORDER BY T.created_at";
//		var_dump ($query);
		//se verifica que la consulta se ejecute bien
		if($invoices = $this->db->query($query)){
			//se verifica que haya informacion
			if ($invoices->num_rows() > 0){
				//Se crea query para obtener notas de debito
//				$query = "SELECT t2.short_name AS 'emisor', t3.short_name AS 'receptor', t1.uuid,
//CONCAT('$url', t1.id) AS 'idurl',
//DATE_FORMAT(FROM_UNIXTIME(t1.debitNote_date), '%d-%m-%Y') AS 'dateCFDI',
//DATE_FORMAT(FROM_UNIXTIME(t1.created_at), '%d-%m-%Y') AS 'dateCreate',
//DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'dateToPay',
//t1.total, 'Nota de crédito' AS tipo, t1.status
//FROM $this->base.debit_notes t1
//LEFT JOIN $this->base.companies t2 ON t1.sender_rfc = t2.rfc
//LEFT JOIN $this->base.companies t3 ON t1.receiver_rfc = t3.rfc
//WHERE (t1.id_company = $id) AND t1.created_at >= '$from' AND t1.created_at <= '$to'
//ORDER BY t1.created_at DESC";
//				var_dump ($query);
				//Se verifica que se ejecute bien el segundo query
				return ["code" => 200,"result" => $invoices->result_array()];
//				if($debit_notes = $this->db->query($query)) {
//					//se crea un unico arreglo con la informacion de las facturas y notas de debito y se envia
//					$CFDI = $invoices->result_array();
//					$CFDI = array_merge($CFDI, $debit_notes->result_array());
//					return ["code" => 200,"result" => $CFDI];
//				}else{
//					//si no hay datos de notas de debito solo se envian las facturas
//
//				}
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
	 * Función para guardar los CFDI de tipo ingreso
	 * @param array       $cfdi      Cadena con el xml del CFDI
	 * @param int         $companyID ID de la compañía emisora
	 * @param int         $userID    ID del usuario que hizo la carga del archivo
	 * @param string|null $env       Ambiente en el que se trabajara
	 * @return array Resultado de la operación
	 */
	public function saveCFDI_I(array $cfdi, int $companyID, int $userID, string $env = null): array {
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//Se obtienen y transforman fechas
		$invoiceDate = strtotime($cfdi['fecha']);
		$idReceptor = $this->getReceptorByRFC($cfdi['receptor']['rfc'], $env);
		if (isset($idReceptor['code'])){
			return ["code" => 500, "message" => "Error al guardar información", "reason" => "No esta registrada la empresa receptora"];
		}
		$paymentDate = $this->getPaymentDate($companyID,$idReceptor,$env);
		$paymentDate = strtotime('now +'.$paymentDate.' days');
		//Se crea el query para guardar el archivo en BD
		$query = "INSERT INTO $this->base.invoices 
    (id_company, id_user, sender_rfc, receiver_rfc, uuid, invoice_date, payment_date, status, total, xml_document)
    VALUES ('$companyID','$userID','{$cfdi['emisor']['rfc']}','{$cfdi['receptor']['rfc']}', '{$cfdi['uuid']}', '$invoiceDate',
            '$paymentDate',0,'{$cfdi['monto']}','{$cfdi['xml']}')";
		$this->db->db_debug = FALSE;
		if(!@$this->db->query($query)){
			return ["code" => 500, "message" => "Error al guardar información", "reason" => "CFDI duplicado"];
			// do something in error case
		}else{
			return ["code" => 200, "message" => "CFDI guardado con éxito"];
			// do something in success case
		}
		return ["code" => 500, "message" => "Error al guardar información", "reason" => "Error con la fuente de información"];
	}
	public function saveCFDI_E(array $cfdi, int $companyID, int $userID, int $id_invoice, string $conciliaDate, string $env = null): array {
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//Se obtienen y transforman fechas
		$invoiceDate = strtotime($cfdi['fecha']);
		$idReceptor = $this->getReceptorByRFC($cfdi['receptor']['rfc'], $env);
		if (isset($idReceptor['code'])){
			return ["code" => 500, "message" => "Error al guardar información", "reason" => "No esta registrada la empresa receptora"];
		}
		$paymentDate = strtotime($conciliaDate);
		//Se crea el query para guardar el archivo en BD
		$query = "INSERT INTO $this->base.debit_notes 
    (id_invoice, id_company, sender_rfc, receiver_rfc, uuid, debitnote_date, payment_date, total, xml_document)
    VALUES ('$id_invoice','$companyID','{$cfdi['emisor']['rfc']}','{$cfdi['receptor']['rfc']}', '{$cfdi['uuid']}', '$invoiceDate',
            '$paymentDate','{$cfdi['monto']}','{$cfdi['xml']}')";
		$this->db->db_debug = FALSE;
		if(!@$this->db->query($query)){
			return ["code" => 500, "message" => "Error al guardar información", "reason" => "CFDI duplicado"];
			// do something in error case
		}else{
			return ["code" => 200, "id" => $this->db->insert_id()];
			// do something in success case
		}
		return ["code" => 500, "message" => "Error al guardar información", "reason" => "Error con la fuente de información"];
	}
	public function getPaymentDate(int $companyID_1, int $companyID_2, string $env = null){
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//Se crea el query para obtener la información
		$query = "SELECT (IF(t2.paydays IS NULL, t1.dias_pago, t2.paydays)) AS 'payDay',
(IF(t2.paydays IS NULL, 'company', 'relation')) AS 'table'
FROM $this->base.companies t1
LEFT JOIN $this->base.clientprovider t2 ON t2.provider_id = t1.id
WHERE IF(t2.paydays IS NOT NULL, t2.provider_id = '$companyID_1' AND t2.client_id = '$companyID_2', t1.id = '$companyID_1')";
		//Se verífica que la consulta se ejecute
		if($res = $this->db->query($query)){
			//Se verífica que haya información
			if ($res->num_rows() > 0){
				$res = $res->result_array()[0];
				if ($res['table'] === 'relation'){
					return $res['payDay'];
				}
				$query = "INSERT INTO $this->base.clientprovider (provider_id, client_id, paydays)
VALUES ('$companyID_1', '$companyID_2', '{$res['payDay']}')";
				if ($this->db->query($query)){
					return $res['payDay'];
				}
				return ["code" => 500,"message" => "Error al obtener fecha de pago",
					"reason" => "No se pudo generar la relación entre emisor y receptor de CFDI"];
			}else{
				//En caso de que no hay informacion lo notifica para que se ingrese otro valor de busqueda
				return ["code" => 404,"message" => "No se encontraron registros",
					"reason" => "No hay resultados con los criterios de búsqueda utilizados"];
			}
		}
		return ["code" => 500,"message" => "Error al obtener fecha de pago",
			"reason" => "Error con la fuente de información"];
	}
	public function getReceptorByRFC(string $rfc, string$env= null)
	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		$query = "SELECT id FROM $this->base.companies WHERE rfc = '$rfc'";
		if($res = $this->db->query($query)){
			if ($res->num_rows() > 0){
				return $res->result_array()[0]['id'];
			}
			return ["code" => 404,"message" => "No se encontraron registros",
				"reason" => "No hay resultados con los criterios de búsqueda utilizados"];
		}
		return ["code" => 500,"message" => "Error al obtener fecha de pago",
			"reason" => "Error con la fuente de información"];
	}
	public function getContraCFDI(int $provider, int $receiver, float $total, string$env= null){
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//se crea la variable url de las facturas para concatenarlo
		$url = base_url('assets/factura/factura.php?idfactura=');
		//Se crea el query para obtener la información
		$query = "SELECT t1.id, t2.short_name AS 'sender', t3.short_name AS 'receiver', t1.total, t1.status, t1.uuid, 
DATE_FORMAT(FROM_UNIXTIME(t1.invoice_date), '%d-%m-%Y') AS 'dateCFDI',
CONCAT('$url', t1.id) AS 'idurl'
FROM $this->base.invoices t1
INNER JOIN $this->base.companies t2 ON t1.sender_rfc = t2.rfc
INNER JOIN $this->base.companies t3 ON t1.receiver_rfc = t3.rfc
INNER JOIN $this->base.fintech t4 ON t4.id = t2.id
WHERE t2.id = $provider AND t3.id = $receiver AND t1.total > $total AND t1.status = 0";
//		var_dump($query);
		if($res = $this->db->query($query)){
			if ($res->num_rows() > 0){
				return $res->result_array();
			}
			return ["code" => 404,"message" => "No se encontraron registros",
				"reason" => "No hay resultados con los criterios de búsqueda utilizados"];
		}
		return ["code" => 500,"message" => "Error al obtener fecha de pago",
			"reason" => "Error con la fuente de información"];
	}
	public function getCFDIById(int $id, string$env= null){
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		$query = "SELECT t1.*, t2.short_name AS 'receiver', t2.rfc AS 'receiverRfc', t3.short_name AS 'provider', t3.short_name AS 'providerRfc' 
FROM $this->base.invoices t1
    INNER JOIN $this->base.companies t2 ON t1.receiver_rfc = t2.rfc
    INNER JOIN $this->base.companies t3 ON t1.sender_rfc = t3.rfc
WHERE t1.id = '$id'";
		if($res = $this->db->query($query)){
			if ($res->num_rows() > 0){
				return $res->result_array()[0];
			}
			return ["code" => 404,"message" => "No se encontraron registros",
				"reason" => "No hay resultados con los criterios de búsqueda utilizados"];
		}
		return ["code" => 500,"message" => "Error al obtener datos",
			"reason" => "Error con la fuente de información"]; //
	}
}
