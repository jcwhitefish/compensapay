<?php
/**
 * Class Operation_model model
 * @property Operation_model $OpData Operation processing model
 */
class Operation_model extends CI_Model {
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
	public function getConciliacionesByCompany (string $id, int $from, int $to, string $env = null): array	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//se crea la variable url de las facturas para concatenarlo
		$url = base_url('assets/factura/factura.php?idfactura=');
		//Se crea el query para obtener las facturas
		$query = "SELECT t1.id ,t1.status, t1.operation_number, t2.short_name AS 'receptor', t3.short_name AS 'emisor', t4.uuid AS 'uuid1',
       CONCAT('$url', t4.id) AS 'idurl', t3.account_clabe, 
       t4.total AS 'total1', DATE_FORMAT(FROM_UNIXTIME(t4.invoice_date), '%d-%m-%Y') AS 'dateCFDI1', 
       (case WHEN t5.id IS NULL THEN t6.uuid ELSE t5.uuid END) AS 'uuid2',
       (case WHEN t5.id IS NULL THEN CONCAT('$url', t6.id) ELSE CONCAT('$url', t5.id) END) AS 'idur2', 
       (case WHEN t5.id IS NULL THEN t6.total ELSE t5.total END) AS 'total2', 
       (case WHEN t5.id IS NULL 
           THEN DATE_FORMAT(FROM_UNIXTIME(t6.debitNote_date), '%d-%m-%Y') 
           ELSE DATE_FORMAT(FROM_UNIXTIME(t5.invoice_date), '%d-%m-%Y') END) AS 'dateCFDI2', 
    	(case WHEN t5.id IS NULL 
    	    THEN DATE_FORMAT(FROM_UNIXTIME(t6.payment_date), '%d-%m-%Y') 
    	    ELSE DATE_FORMAT(FROM_UNIXTIME(t5.payment_date), '%d-%m-%Y') END) AS 'datePago', 
    	DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'conciliationDate', 
    	(CASE WHEN t1.id_provider = '$id' THEN 'emisor' ELSE 'receptor' END) AS 'role'
		FROM compensatest_base.operations t1 
		    INNER JOIN compensatest_base.companies t2 ON t2.id = t1.id_client 
		    INNER JOIN compensatest_base.companies t3 ON t3.id = t1.id_provider 
		    INNER JOIN compensatest_base.invoices t4 ON t1.id_invoice = t4.id
		    LEFT JOIN compensatest_base.invoices t5 ON t1.id_invoice_relational = t5.id
		    LEFT JOIN compensatest_base.debit_notes t6 ON t1.id_debit_note = t6.id
		WHERE (t1.id_client = $id OR t1.id_provider = $id) 
		  AND t1.created_at >= '$from' AND t1.created_at <= '$to'
		ORDER BY t1.created_at DESC";
		//Se verífica que la consulta se ejecute bien
		if($res = $this->db->query($query)){
			//se verífica que haya información
			if ($res->num_rows() > 0){
				//si no hay datos de notas de debito solo se envian las facturas
				return ["code" => 200,"result" => $res->result_array()];
			}else{
				//En caso de que no hay informacion lo notifica para que se ingrese otro valor de busqueda
				return ["code" => 404,"message" => "No se encontraron registros",
					"reason" => "No hay resultados con los criterios de búsqueda utilizados"];
			}
		}
		//En caso de error igual notifica
		return ["code" => 500, "message" => "Error al extraer la información", "reason" => "Error con la fuente de información"];
	}
}
